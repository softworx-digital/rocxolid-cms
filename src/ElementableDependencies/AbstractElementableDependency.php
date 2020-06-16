<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider as TranslationPackageProviderContract;
// rocXolid traits
use Softworx\RocXolid\Traits\Controllable;
use Softworx\RocXolid\Traits\TranslationPackageProvider;
use Softworx\RocXolid\Traits\TranslationParamProvider;
use Softworx\RocXolid\Traits\TranslationKeyProvider;
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
abstract class AbstractElementableDependency implements ElementableDependency
{
    use Controllable;
    use TranslationPackageProvider;
    use TranslationParamProvider;
    use TranslationKeyProvider;

    /**
     * Dependency field names.
     *
     * @var array
     */
    protected $dependency_fields_definition = [];

    /**
     * {@inheritDoc}
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $dependency_data_provider, ?string $key = null): ElementableDependency
    {
        if ($assignments->has($key)) {
            throw new \RuntimeException(sprintf('Assignment key [%s] is already set to assignments [%s]', $key, print_r($assignments, true)));
        }

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
    public function getTitle(TranslationPackageProviderContract $controller): string
    {
        return $this->setController($controller)->translate(sprintf('element-dependency.%s.title', $this->provideTranslationKey()));
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
    public function provideDependencyFieldNames(ElementableDependencyDataProvider $dependency_data_provider): Collection
    {
        return collect($this->dependency_fields_definition)->keys();
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        return $this->dependency_fields_definition;
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyDataPlaceholders(): Collection
    {
        $config = static::getConfigFilePathKey();
        $key = 'data-placeholders';

        return collect(config(sprintf('%s.%s.%s', $config, $key, static::class), config(sprintf('%s.%s.default', $config, $key), [])))
            ->transform(function ($definition, $name) {
                return new Placeholder($this, $name, $definition);
            });
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
     */
    protected function getDependencyValues(ElementableDependencyDataProvider $dependency_data_provider): Collection
    {
        $raw = collect($dependency_data_provider->getDependencyData($this)->only($this->provideDependencyFieldNames($dependency_data_provider)->toArray()));

        $keyed = ($raw->count() === 1) ? $raw->keyBy(function ($item) {
            return $this->getAssignmentDefaultName();
        }) : $raw;

        $a = $keyed->transform(function ($value, $key) {
            return $this->tranformDependencyValue($key, $value);
        });

        return $a;
    }

    /**
     * Transform the dependency value specifically for the dependency.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function tranformDependencyValue(string $key, $value)
    {
        return $value;
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
