<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProviderable;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProviderable;
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
abstract class AbstractElementable extends AbstractCrudModel implements
    ElementsDependenciesProvider,
    ElementsDependenciesProviderable,
    ElementsMutatorsProvider,
    ElementsMutatorsProviderable,
    Elementable
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
    public function elementsPivots(): HasOneOrMany
    {
        return $this->hasMany($this->getElementsPivotType(), 'parent_id');
    }

    /**
     * Obtain container for quick-add-component for document editor.
     *
     * @return string
     */
    public function getDocumentEditorContainerForQuickAddComponent(): string
    {
        return $this->getQuickAddComponentElementTypes()->transform(function ($options, $type) {
            return ElementBuilder::buildSnippetElement(
                $type,
                $this->getDependenciesProvider(),
                $this->getMutatorsProvider(),
                $this->getDependenciesDataProvider(),
                collect($options)
            )->getModelViewerComponent()->fetch();
        })->join("\n");
    }

    /**
     * Obtain available element models that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     * @todo: ugly, find nicer approach
     */
    public function getAvailableElements(string $group = null): Collection
    {
        $elements = collect();

        $this->getAvailableElementTypes()->each(function ($options, $type) use ($group, &$elements) {
            $type::getAvailableTemplates($this->provideViewTheme())->each(function ($template) use ($options, $type, $group, &$elements) {
                // options passed for only one instance
                if ($options->isEmpty() || Arr::isAssoc($options->all())) {
                    $options->put('template', $template);

                    $element = ElementBuilder::buildSnippetElement(
                        $type,
                        $this->getDependenciesProvider(),
                        $this->getMutatorsProvider(),
                        $this->getDependenciesDataProvider(),
                        $options
                    );

                    if (is_null($group) || $element->belongsToGroup($group)) {
                        $elements->push($element);
                    }
                    // multiple instance options
                } else {
                    $elements = $elements->merge($options->transform(function ($options) use ($group, $type, $template) {
                        $options = collect($options)->put('template', $template);

                        $element = ElementBuilder::buildSnippetElement(
                            $type,
                            $this->getDependenciesProvider(),
                            $this->getMutatorsProvider(),
                            $this->getDependenciesDataProvider(),
                            $options
                        );

                        if (is_null($group) || $element->belongsToGroup($group)) {
                            return $element;
                        }
                    })->filter());
                }
            });
        });

        return $elements;
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
