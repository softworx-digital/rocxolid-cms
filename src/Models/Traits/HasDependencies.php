<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;

/**
 * Trait for dependable elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasDependencies
{
    /**
     * Fill dependencies configuration from request.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     */
    public function fillDependencies(Collection $data): Crudable
    {
        if ($data->has('dependencies')) {
            $this->dependencies = json_encode($data->get('dependencies'));
        }

        return $this;
    }
    /**
     * Fill dependencies filters configuration from request.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     */
    public function fillDependenciesFilters(Collection $data): Crudable
    {
        $dependencies_filters = [];

        // @todo: "hotfixed"
        if (collect(request()->input('_data'))->each(function ($value, $key) use (&$dependencies_filters) {
            if (Str::startsWith($key, 'filter:')) {
                list($p, $dependency_field, $filter_field) = explode(':', $key);

                $dependencies_filters[$dependency_field][$filter_field] = $value;
            }
        }));

        if (filled($dependencies_filters)) {
            $this->dependencies_filters = json_encode($dependencies_filters);
        } else {
            $this->dependencies_filters = null;
        }

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
     * Dependencies filters attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getDependenciesFiltersAttribute($value): Collection
    {
        return collect($value ? json_decode($value, true) : [])->filter();
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableDependencies(): Collection
    {
        return $this->getAvailableDependencyTypes()->transform(function (string $type) {
            return app($type);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(): Collection
    {
        return $this
            ->getImplicitDependencyTypes()
            ->merge($this->dependencies)
            ->transform(function (string $dependency_type_id) {
                list($dependency_type, $dependency_id) = explode(':', sprintf('%s:', $dependency_type_id));

                return filled($dependency_id) ? $dependency_type::findOrFail($dependency_id) : app($dependency_type);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function getDependenciesProvider(): ElementsDependenciesProvider
    {
        return $this;
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
     * Obtain dependency types that are implicitly assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getImplicitDependencyTypes(): Collection
    {
        return static::getConfigData('implicit-dependencies');
    }
}
