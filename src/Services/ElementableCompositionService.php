<?php

namespace Softworx\RocXolid\CMS\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ServiceConsumer;
// rocXolid service traits
use Softworx\RocXolid\Services\Traits\HasServiceConsumer;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms service contracts
use Softworx\RocXolid\CMS\Services\Contracts\ElementableCompositionService as ElementableCompositionServiceContract;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
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
 */
class ElementableCompositionService implements ElementableCompositionServiceContract
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


    protected function saveStructure(Elementable $model)
    {
        return $this
            ->saveNodes($model)
            ->saveEdges($model);
    }

    protected function saveNodes(Elementable &$parent)
    {
        $parent->elementsBag()->each(function (&$element, $index) use (&$parent) {
            if ($element instanceof Elementable) {
                $this->saveNodes($element);
            }

            $parent->saveElement($element);
        });

        // $parent = tap($parent)->push();
        $parent = tap($parent)->save();

        return $this;
    }

    protected function saveEdges(Elementable &$parent)
    {
        $parent->elementsBag()->each(function (&$element, $index) use (&$parent) {
            if ($element instanceof Elementable) {
                $this->saveEdges($element);
            }

            $parent->savePivot($element);
        });

        return $this;
    }

    protected function createElementStructure(Elementable &$parent, Collection $structure)
    {
        $structure->each(function ($element_data, $position) use (&$parent) {
            $element_data = collect($element_data);

            $element = $this->createElement($element_data);
            $element->web()->associate($parent->web);

            $parent->addElement($element);

            if ($element_data->has('children')) {
                $this->createElementStructure($element, collect($element_data->get('children')));
            }
        });

        return $this;
    }

    protected function createElement(Collection $data)
    {
        if (!$data->has('elementType')) {
            throw new \InvalidArgumentException('Missing [elementType] in node data');
        }

        $element_type = $this->resolveElementPolymorphism($data->get('elementType'));

        $element = $data->has('elementId')
            ? $element_type::findOrFail($data->get('elementId'))
            : app($element_type);

        if ($data->has('elementData')) {
            $element->setDataOnCreate(collect($data->get('elementData')));
        }

        if ($data->has('pivotData')) {
            $element->setPivotData(collect($data->get('pivotData')));
        }

        return $element;
    }

    protected function resolveElementPolymorphism(string $param)
    {
        $element_type = config(sprintf('rocXolid.main.polymorphism.%s', $param), $this->guessElementType($param));

        if (!class_exists($element_type)) {
            throw new \RuntimeException(sprintf('Invalid element type [%s] for param [%s], should be configured in [rocXolid.main.polymorphism.%s]', $element_type, $param, $param));
        }

        if (!(new \ReflectionClass($element_type))->implementsInterface(Element::class)) {
            throw new \RuntimeException(sprintf('Resolved element type [%s] for param [%s] is not [%s]', $element_type, $param, Element::class));
        }

        return $element_type;
    }

    protected function guessElementType(string $param)
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
            throw new \RuntimeException(sprintf('Service [%s] guessed unexisting element type [%s].', static::class, $element_type));
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
        return ($consumer instanceof AbstractElementableController);
    }
}
