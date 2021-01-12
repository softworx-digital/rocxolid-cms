<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Controllable;
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
use Softworx\RocXolid\Contracts\TranslationDiscoveryProvider;
use Softworx\RocXolid\Contracts\TranslationProvider;
// rocXolid traits
use Softworx\RocXolid\Traits as Traits;
// rocXolid components
use Softworx\RocXolid\Components\General\Message;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms elementable dependency data
use Softworx\RocXolid\CMS\ElementableDependencies\Data\Placeholder;

/**
 * Abstract elementable dependency.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractElementableDependency implements ElementableDependency, Controllable, TranslationDiscoveryProvider, TranslationProvider
{
    use Traits\Controllable;
    use Traits\TranslationPackageProvider;
    use Traits\TranslationParamProvider;
    use Traits\TranslationKeyProvider;

    protected const SUBDEPENDENCIES = [];

    /**
     * {@inheritDoc}
     */
    // protected $translation_package = 'rocXolid:cms'; // will throw exception, cause this is defined in the trait

    /**
     * Definition of the fields the dependency provides to dependency data provider form.
     *
     * @var array
     */
    protected $dependency_fields_definition = [];

    /**
     * ???
     *
     * @var array
     */
    protected $dependency_fields_values_filter_definition = [];

    /**
     * {@inheritDoc}
     */
    abstract public function getDependencyViewValue(ElementableDependencyDataProvider $dependency_data_provider);

    /**
     * {@inheritDoc}
     */
    abstract public function validateAssignmentData(Collection $data, string $attribute): bool;

    /**
     * {@inheritDoc}
     */
    abstract public function assignmentValidationErrorMessage(TranslationPackageProvider $controller, Collection $data): string;

    /**
     * {@inheritDoc}
     */
    public function hasSubdependencies(): bool
    {
        return filled(static::SUBDEPENDENCIES);
    }

    /**
     * {@inheritDoc}
     */
    public function provideSubDependencies(): Collection
    {
        return collect(static::SUBDEPENDENCIES)->transform(function (string $dependency_type) {
            return app($dependency_type);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getAssignmentDefaultName(): string
    {
        return Str::snake((new \ReflectionClass($this))->getShortName());
    }

    /**
     * {@inheritDoc}
     */
    public function hasAssignment(ElementableDependencyDataProvider $dependency_data_provider): bool
    {
        return collect($dependency_data_provider->getDependencyData()->only($this->provideDependencyFieldsNames($dependency_data_provider, false)->toArray()))->filter()->isNotEmpty();
    }

    /**
     * {@inheritDoc}
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $dependency_data_provider, ?string $key = null): ElementableDependency
    {
        $this->getDependencyValues($dependency_data_provider)->each(function ($value, $dependency_key) use (&$assignments, $key) {
            $key = $key ?? $dependency_key;

            if ($assignments->has($key)) {
                throw new \RuntimeException(sprintf('Assignment key [%s] is already set to assignments [%s]', $key, print_r($assignments, true)));
            }

            $assignments->put($key, $value);
        });

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsNames(ElementableDependencyDataProvider $dependency_data_provider, bool $with_subdependencies = true): Collection
    {
        $field_names = collect($this->dependency_fields_definition)->keys();

        return $with_subdependencies
            ? $field_names
            : $field_names->filter(function (string $key) use ($dependency_data_provider) {
                $subdependencies_keys = $this->provideSubDependencies()->transform(function (ElementableDependency $subdepencency) use ($dependency_data_provider) {
                    return $subdepencency->provideDependencyFieldsNames($dependency_data_provider);
                })->flatten();

                return !$subdependencies_keys->contains($key);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        return $this->dependency_fields_definition;
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldValuesFilterFieldsDefinition(AbstractCrudForm $form): array
    {
        return $this->dependency_fields_values_filter_definition;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataProviderFieldValue(ElementableDependencyDataProvider $dependency_data_provider, Collection $data, string $field_name)
    {
        $value = $data->get($field_name);

        return is_scalar($value) ? $value : collect($value)->filter();
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyDataPlaceholders(): Collection
    {
        $config = static::getConfigFilePathKey();

        return collect(config(sprintf('%s.data-placeholders.%s', $config, static::class), config(sprintf('%s.data-placeholders.default', $config), [])))
            ->transform(function ($definition, $name) {
                return new Placeholder($this, $name, $definition);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslatedTitle(TranslationPackageProvider $controller): string
    {
        return $this->setController($controller)->translate(sprintf('element-dependency.%s.title', $this->provideTranslationKey()));
    }

    /**
     * {@inheritDoc}
     */
    public function translate(string $key, array $params = [], bool $use_raw_key = false): string
    {
        return Message::build($this, $this->getController())->translate($key, $params, $use_raw_key);
    }

    /**
     * {@inheritDoc}
     */
    protected function guessTranslationParam(): ?string
    {
        if ($this->hasController()) {
            throw new \RuntimeException(sprintf('No controller set for [%s]', get_class($this)));
        }

        return $this->getController()->provideTranslationParam();
    }

    /**
     * Retrieve the actual value(s) of the dependency extracting it from the dependency data provider's values.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @return \Illuminate\Support\Collection
     * @todo [RX-3]: !! this is being called suspiciously often (probably for each element) in document generation - subject to revise and optimize
     * add some "caching" to ContentCompiler and ThemeViewComposer
     */
    protected function getDependencyValues(ElementableDependencyDataProvider $dependency_data_provider): Collection
    {
        // extract relevant values from data provider
        $present = collect($dependency_data_provider->getDependencyData()->only($this->provideDependencyFieldsNames($dependency_data_provider, false)->toArray()));
        // offset dependency data that can be used by dependencies provider but is not present in provided data
        $offset = $this->provideDependencyFieldsNames($dependency_data_provider, false)->flip()->diffKeys(collect($dependency_data_provider->getDependencyData()));
        /*
        logger(sprintf('>>>>>>>>>>>>>> %s::%s', get_class($this), 'getDependencyValues'));
        logger('------------------------------');
        logger('PRESENT');
        logger($present);
        logger('------------------------------');
        logger('OFFSET');
        logger($offset);
        */
        if ($this->hasSubdependencies()) {
            $subdependencies_values = $this->provideSubDependencies()->transform(function (ElementableDependency $subdepencency) use ($dependency_data_provider) {
                return $subdepencency->getDependencyValues($dependency_data_provider);
            })->flatMap(function (Collection $values) {
                return $values;
            });
            ;
        /*
        logger('------------------------------');
        logger(sprintf('%s::%s RESOLVED SUBDEPENDENCIES', get_class($this), 'getDependencyValues'));
        logger($subdependencies_values);
        logger('------------------------------');
        */
        } else {
            $subdependencies_values = collect();
        }

        // @todo causes problems when there's dependency that doesn't provide constant number of fields
        // in a case when only one field is provided and has different name that getAssignmentDefaultName() returns
        $present = ($present->count() === 1) ? $present->keyBy(function ($item) {
            return $this->getAssignmentDefaultName();
        }) : $present;

        $values = $present
            ->transform(function ($value, string $key) use ($dependency_data_provider) {
                return $this->transformDependencyValue($dependency_data_provider, $key, $value);
            })
            ->merge($subdependencies_values)
            ->merge($offset->transform(function ($i, $key) use ($dependency_data_provider) {
                return $this->fillDependencyOffsetValue($dependency_data_provider, $key);
            }));
        /*
        logger('VALUES');
        logger($values->keys());
        logger('------------------------------');
        */
        return $values;
    }

    /**
     * Transform the dependency key/field value specifically for the dependency.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function transformDependencyValue(ElementableDependencyDataProvider $dependency_data_provider, string $key, $value)
    {
        return $value;
    }

    /**
     * Fill the dependency field value if not present in data provider.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @param string $key
     * @return mixed
     */
    protected function fillDependencyOffsetValue(ElementableDependencyDataProvider $dependency_data_provider, string $key)
    {
        return null;
    }

    /**
     * Obtain config file path key.
     *
     * @return string
     */
    protected static function getConfigFilePathKey(): string
    {
        return 'rocXolid.cms.dependency';
    }
}
