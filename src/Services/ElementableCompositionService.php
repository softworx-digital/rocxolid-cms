<?php

namespace Softworx\RocXolid\CMS\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ServiceConsumer;
// rocXolid service traits
use Softworx\RocXolid\Services\Traits\HasServiceConsumer;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractDocumentController;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Services\Exceptions\InvalidStructureException;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms model elements contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Service to handle elementable composition.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 * @todo: delegate element retrieval & data manipulation to element repository (obtained from service consumer)
 */
class ElementableCompositionService implements Contracts\ElementableCompositionService
{
    use HasServiceConsumer;

    /**
     * {@inheritDoc}
     */
    public function compose(Elementable $model, Collection $data): Elementable
    {
        $this
            ->createElementStructure($model, collect($data->get('composition')))
            ->saveStructure($model);

        // $model->push(); // this saves only models, not relationships - connections

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function composePreview(Elementable $model, Collection $data): Elementable
    {
        $this
            ->createElementStructure($model, collect($data->get('composition')));

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function destroyElement(Elementable $model, Collection $data): Elementable
    {
        // find the element to destroy
        $element = $this->getElement($data);

        if ($element instanceof Elementable) {
            $this->destroyStructure($element);
        }

        $model->findPivot($element)->delete();
        $element->delete();

        return $model;
    }

    /**
     * Destroys the structure with the given root element bottom up.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $parent
     */
    protected function destroyStructure(Elementable $parent): Contracts\ElementableCompositionService
    {
        $parent->elements()->each(function ($element, $index) use ($parent) {
            if ($element instanceof Elementable) {
                $this->destroyStructure($element);
            }

            $parent->findPivot($element)->delete();
            $element->delete();
        });

        return $this;
    }

    /**
     * Create in-memory structure of elements (nodes) and pivots (edges) from (request) data.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable &$parent
     * @param \Illuminate\Support\Collection $structure
     * @return \Softworx\RocXolid\CMS\Services\Contracts\ElementableCompositionService
     */
    protected function createElementStructure(Elementable &$parent, Collection $structure): Contracts\ElementableCompositionService
    {
        $structure->each(function ($element_data, $position) use (&$parent) {
            $element_data = collect($element_data);

            $element = $this->createElement($element_data);
            $element->web()->associate($parent->web);

            $parent->addElement($element);

            try {
                if ($element_data->has('children')) {
                    $this->createElementStructure($element, collect($element_data->get('children')));
                }
            } catch (\TypeError $e) {
                throw new InvalidStructureException($parent, $element, $element_data);
            }
        });

        return $this;
    }

    /**
     * Persist in-memory structure of elements (nodes) and pivots (edges).
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     * @return \Softworx\RocXolid\CMS\Services\Contracts\ElementableCompositionService
     */
    protected function saveStructure(Elementable $model): Contracts\ElementableCompositionService
    {
        // this should be enough, however the structure is somehow non-standard
        // and the relations are not resolved properly
        // $parent = tap($parent)->push();

        // custom save mechanism
        return $this
            ->dropEdges($model)
            ->saveNodes($model)
            ->saveEdges($model);
    }

    /**
     * Drop all edges of the structure with the given root element bottom up.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable &$parent
     */
    protected function dropEdges(Elementable $model): Contracts\ElementableCompositionService
    {
        $model->elements()->filter(function ($element) {
            return $element->exists;
        })->each(function ($element, $index) use ($model) {
            if ($element instanceof Elementable) {
                $this->dropEdges($element);
            }

            optional($model->findPivot($element))->delete();
        });

        return $this;
    }

    /**
     * Persist in-memory structure of elements (nodes) in bottom up fashion.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable &$parent
     * @return \Softworx\RocXolid\CMS\Services\Contracts\ElementableCompositionService
     */
    protected function saveNodes(Elementable &$parent): Contracts\ElementableCompositionService
    {
        // use in-memory elements collection created from request
        $parent->elementsBag()->each(function (&$element, $index) use (&$parent) {
            if ($element instanceof Elementable) {
                $this->saveNodes($element);
            }

            $parent->saveElement($element);
        });

        $parent = tap($parent)->save();

        return $this;
    }

    /**
     * Persist in-memory structure of pivots (edges) in bottom up fashion.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable &$parent
     * @return \Softworx\RocXolid\CMS\Services\Contracts\ElementableCompositionService
     */
    protected function saveEdges(Elementable &$parent): Contracts\ElementableCompositionService
    {
        // use in-memory elements collection created from request
        $parent->elementsBag()->each(function (&$element, $index) use (&$parent) {
            if ($element instanceof Elementable) {
                $this->saveEdges($element);
            }

            $parent->savePivot($element);
        });

        return $this;
    }

    /**
     * Obtain (find or create) element to work with based on (request) data.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     * @throws \InvalidArgumentException
     */
    protected function getElement(Collection $data): Element
    {
        if (!$data->has('elementType')) {
            throw new \InvalidArgumentException('Missing [elementType] in node data');
        }

        if (!$data->has('elementId')) {
            throw new \InvalidArgumentException('Missing [elementId] in node data');
        }

        $element_type = $this->resolveElementPolymorphism($data->get('elementType'));

        return $element_type::findOrFail($data->get('elementId'));
    }

    /**
     * Obtain (find or create) element to work with based on (request) data.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     * @throws \InvalidArgumentException
     */
    protected function createElement(Collection $data): Element
    {
        if (!$data->has('elementType')) {
            throw new \InvalidArgumentException('Missing [elementType] in node data');
        }

        $element_type = $this->resolveElementPolymorphism($data->get('elementType'));

        $element = $data->has('elementId')
            ? $element_type::findOrFail($data->get('elementId'))
            : app($element_type);

        if ($data->has('elementData')) {
            $element->onCreateBeforeSave(collect($data->get('elementData')));
        }

        if ($data->has('pivotData')) {
            $element->setPivotData(collect($data->get('pivotData')));
        }

        return $element;
    }

    /**
     * Retrieve the real fully qualified element type based on provided model param.
     *
     * @param string $param
     * @return string
     * @throws \RuntimeException
     */
    protected function resolveElementPolymorphism(string $param): string
    {
        $element_type = config(sprintf('rocXolid.main.polymorphism.%s', $param)) ?? $this->guessElementType($param);

        if (!class_exists($element_type)) {
            throw new \RuntimeException(sprintf('Invalid element type [%s] for param [%s], should be configured in [rocXolid.main.polymorphism.%s]', $element_type, $param, $param));
        }

        if (!(new \ReflectionClass($element_type))->implementsInterface(Element::class)) {
            throw new \RuntimeException(sprintf('Resolved element type [%s] for param [%s] is not [%s]', $element_type, $param, Element::class));
        }

        return $element_type;
    }

    /**
     * Naively guess the element type based on namespace and model param.
     *
     * @param string $param
     * @return string
     * @throws \RuntimeException
     */
    protected function guessElementType(string $param): string
    {
        /*
         * @todo: Laravel 7
        $element_namespace = Str::of((new \ReflectionClass($this->consumer))->getNamespaceName())
            ->replace('Http\Controllers', 'Elements\Models')
            ->beforeLast($element_namespace, '\\');
        */

        $element_namespace = str_replace('Http\Controllers', 'Elements\Models', (new \ReflectionClass($this->consumer))->getNamespaceName());
        $element_namespace = Str::beforeLast($element_namespace, '\\');
        $element_type = sprintf('%s\%s', $element_namespace, Str::studly($param));

        if (!class_exists($element_type)) {
            throw new \RuntimeException(sprintf('Service [%s] guessed unexisting element type [%s] for param [%s].', static::class, $element_type, $param));
        }

        if (!(new \ReflectionClass($element_type))->implementsInterface(Element::class)) {
            throw new \RuntimeException(sprintf('Service [%s] guessed element type [%s] that is not [%s].', static::class, $element_type, Element::class));
        }

        return $element_type;
    }

    /**
     * {@inheritDoc}
     */
    protected function validateServiceConsumer(ServiceConsumer $consumer): bool
    {
        return ($consumer instanceof AbstractDocumentController);
    }
}
