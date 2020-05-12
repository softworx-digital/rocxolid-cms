<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms elements models traits
use Softworx\RocXolid\CMS\Elements\Models\Traits\HasElements;
// rocXolid cms elements builders
use Softworx\RocXolid\CMS\Elements\Builders\ElementBuilder;

/**
 * Elementable model abstraction.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractDocument extends AbstractCrudModel implements ElementsDependenciesProvider, Elementable
{
    use SoftDeletes;
    use HasElements;
    use CommonTraits\HasWeb;
    // use CommonTraits\UserGroupAssociatedWeb;
    use CommonTraits\HasLocalization;
    use Traits\HasElementableDependencyDataProvider;

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
    ];

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        $this->dependencies = json_encode($data->get('dependencies'));

        return parent::fillCustom($data);
    }

    /**
     * {@inheritDoc}
     */
    public function elementsPivots(): HasOneOrMany
    {
        return $this->hasMany($this->getElementsPivotType(), 'parent_id');
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(): Collection
    {
        return $this->dependencies->map(function ($dependency_type) {
            return app($dependency_type);
        });
    }

    /**
     * Return self as dependencies provider for elements.
     *
     * @return Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider
     */
    public function getDependenciesProvider(): ElementsDependenciesProvider
    {
        return $this;
    }

    /**
     * Dependencies attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getDependenciesAttribute($value): Collection
    {
        return collect($value ? json_decode($value) : [])->filter();
    }

    /**
     * Provide view theme to underlying elements.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideViewTheme(): string
    {
        return $this->theme;
    }

    /**
     * Obtain container for quick-add-component for document editor.
     *
     * @return string
     */
    public function getDocumentEditorContainerForQuickAddComponent(): string
    {
        return $this->getQuickAddComponentElementTypes()->transform(function ($options, $type) {
            return ElementBuilder::buildSnippetElement($type, $this->getDependenciesProvider(), $this->getDependenciesDataProvider(), collect($options))
                ->getModelViewerComponent()
                ->fetch();
        })->join("\n");
    }

    /**
     * Obtain available element models that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     * @todo: more elegant code please
     */
    public function getAvailableElements(): Collection
    {
        $elements = collect();

        $this->getAvailableElementTypes()->each(function ($options, $type) use (&$elements) {
            // passed options for only one instance
            if ($options->isEmpty() || Arr::isAssoc($options->all())) {
                $elements->push(ElementBuilder::buildSnippetElement($type, $this->getDependenciesProvider(), $this->getDependenciesDataProvider(), $options));
            } else {
                // multiple instance options
                $elements = $elements->merge($options->transform(function ($options) use ($type) {
                    return ElementBuilder::buildSnippetElement($type, $this->getDependenciesProvider(), $this->getDependenciesDataProvider(), collect($options));
                }));
            }
        });

        return $elements;
    }

    /**
     * Obtain available dependencies that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableDependencies(): Collection
    {
        return $this->getAvailableDependencyTypes()->transform(function ($type) {
            return app($type);
        });
    }

    /**
     * Obtain styles to apply to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getStyles(): Collection
    {
        return static::getConfigData('styles');
    }

    /**
     * Obtain container type to be used for 'quick-add-component' with options.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getQuickAddComponentElementTypes(): Collection
    {
        return static::getConfigData('quick-add-element');
    }

    /**
     * Obtain element types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableElementTypes(): Collection
    {
        return static::getConfigData('available-elements')->mapWithKeys(function ($value, $index) {
            return is_string($index) ? [
                $index => collect($value)
            ] : [
                $value => collect()
            ];
        });
    }

    /**
     * Obtain dependency types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableDependencyTypes(): Collection
    {
        return static::getConfigData('available-dependencies');
    }

    /**
     * Obtain model specific (fallbacks to 'default') configuration.
     *
     * @param string $key
     * @return \Illuminate\Support\Collection
     */
    protected static function getConfigData(string $key): Collection
    {
        $config = static::getConfigFilePathKey();

        return collect(config(sprintf('%s.%s.%s', $config, $key, static::class), config(sprintf('%s.%s.default', $config, $key), [])));
    }

    /**
     * Obtain config file path key.
     *
     * @return string
     */
    protected static function getConfigFilePathKey(): string
    {
        return 'rocXolid.cms.elementable';
    }
}
