<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms elementable dependency data
use Softworx\RocXolid\CMS\ElementableDependencies\Data\Placeholder;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;

/**
 * Elementable data dependency model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DataDependency extends AbstractCrudModel implements ElementableDependency
{
    use SoftDeletes;
    use CommonTraits\HasWeb;
    // use CommonTraits\UserGroupAssociatedWeb;
    use CommonTraits\HasLocalization;

    const TYPE_OPTIONS = [
        'boolean',
        'integer',
        'decimal',
        'string',
        'text',
        'date',
        'enum',
        'set',
    ];

    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_data_dependencies';

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        'type',
        'title',
        'is_required',
        'default_value_boolean',
        'default_value_integer',
        'default_value_decimal',
        'default_value_string',
        'default_value_text',
        'default_value_date',
        'min',
        'max',
        'yes_title',
        'no_title',
        'values',
        'conjunction',
        'description',
        'note',
    ];

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
    protected $decimals = [
        'default_value_decimal',
        'min',
        'max',
    ];

    public static function getTypeOptions()
    {
        return collect(static::TYPE_OPTIONS);
    }

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {

        if ($data->has('values')) {
            $values = $data->get('values')->transform(function ($value, $index) use ($data) {
                return [
                    'title' => $value,
                    'is_default_value' => collect($data->get('is_default_value'))->get($index, 0),
                ];
            });

            $this->values = json_encode($values);
        }

        // @todo: ugly, use custom casts with Laravel 7
        if ($data->has('min') && !is_null($this->min)) {
            $this->min = str_replace(',', '.', $this->min);
            $this->min = str_replace(' ', '', $this->min);
        }

        // @todo: ugly, use custom casts with Laravel 7
        if ($data->has('max') && !is_null($this->max)) {
            $this->max = str_replace(',', '.', $this->max);
            $this->max = str_replace(' ', '', $this->max);
        }

        // @todo: ugly, use custom casts with Laravel 7
        if ($data->has('default_value_decimal') && !is_null($this->default_value_decimal)) {
            $this->default_value_decimal = str_replace(',', '.', $this->default_value_decimal);
            $this->default_value_decimal = str_replace(' ', '', $this->default_value_decimal);
        }

        return parent::fillCustom($data);
    }

    /**
     * Dependencies (set|enum) values attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getValuesAttribute($value): Collection
    {
        return collect($value ? collect(json_decode($value))->pluck('title') : [])->filter();
    }

    /**
     * Dependencies (integer|decimal) min attribute getter mutator.
     *
     * @param mixed $value
     * @return mixed
     */
    public function getMinAttribute($value)
    {
        return ($this->type === 'integer') ? (int)$value : $value;
    }

    /**
     * Dependencies (integer|decimal) max attribute getter mutator.
     *
     * @param mixed $value
     * @return mixed
     */
    public function getMaxAttribute($value)
    {
        return ($this->type === 'integer') ? (int)$value : $value;
    }

    /**
     * Dependencies (set|enum) is-default-value attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getIsDefaultValueAttribute($value): Collection
    {
        return collect($this->getOriginal('values') ? collect(json_decode($this->getOriginal('values')))->pluck('is_default_value') : []);
    }

    /**
     * Check if the dependency is assigned to any document.
     *
     * @param string $provider_type
     * @return bool
     */
    public function isAssignedToProvider(string $provider_type): bool
    {
        return $this->getAssignedProviders($provider_type)->isNotEmpty();
    }

    /**
     * Obtain providers that have the dependency assigned.
     *
     * @param string $provider_type
     * @return \Illuminate\Support\Collection
     */
    public function getAssignedProviders(string $provider_type): Collection
    {
         return $provider_type::all()->filter(function (ElementsDependenciesProvider $provider) {
             return $provider->provideDependencies()->filter(function (ElementableDependency $dependency) {
                return ($dependency instanceof $this) && ($dependency->getKey() === $this->getKey());
             })->isNotEmpty();
         });
    }

    /**
     * {@inheritDoc}
     */
    public function hasSubdependencies(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function provideSubDependencies(): Collection
    {
        return collect();
    }

    /**
     * {@inheritDoc}
     */
    public function getAssignmentDefaultName(): string
    {
        return sprintf('%s_%s', Str::snake((new \ReflectionClass($this))->getShortName()), $this->getKey());
    }

    /**
     * {@inheritDoc}
     */
    public function hasAssignment(ElementableDependencyDataProvider $dependency_data_provider): bool
    {
        return $dependency_data_provider->getDependencyData()->get($this->getAssignmentDefaultName());
    }

    /**
     * {@inheritDoc}
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $dependency_data_provider, ?string $key = null): ElementableDependency
    {
        $key = $key ?? $this->getAssignmentDefaultName();

        if ($assignments->has($key)) {
            throw new \RuntimeException(sprintf('Assignment key [%s] is already set to assignments [%s]', $key, print_r($assignments, true)));
        }

        $assignments->put($key, $dependency_data_provider->getDependencyData()->get($key));

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsNames(ElementableDependencyDataProvider $dependency_data_provider): Collection
    {
        return collect($this->getAssignmentDefaultName());
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        return $this->getTypeDecorator()->provideDependencyFieldsDefinition($form, $dependency_data_provider);
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldValuesFilterFieldsDefinition(AbstractCrudForm $form): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getDataProviderFieldValue(ElementableDependencyDataProvider $dependency_data_provider, Collection $data, string $field_name)
    {
        return $this->getTypeDecorator()->getDataProviderFieldValue($dependency_data_provider, $data, $field_name);
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyViewValue(ElementableDependencyDataProvider $dependency_data_provider)
    {
        return $this->getTypeDecorator()->getDependencyViewValue($dependency_data_provider);;
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyDataPlaceholders(): Collection
    {
        return collect([ new Placeholder($this, $this->getTitle(), [ 'token' => $this->getAssignmentDefaultName() ]) ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslatedTitle(TranslationPackageProvider $controller): string
    {
        return $this->getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function validateAssignmentData(Collection $data, string $attribute): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function assignmentValidationErrorMessage(TranslationPackageProvider $controller, Collection $data): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    protected function isDecimalAttribute(string $attribute): bool
    {
        return collect($this->decimals)->contains($attribute) && ($this->type === 'decimal');
    }

    /**
     * Obtain decorator to be responsible for handling specific type.
     *
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency
     */
    private function getTypeDecorator(): ElementableDependency
    {
        $decorator_type = sprintf('\%s\DataDependencies\%sDecorator', __NAMESPACE__, ucfirst($this->type));

        return app($decorator_type, [ 'elementable_dependency' => $this ]);
    }
}
