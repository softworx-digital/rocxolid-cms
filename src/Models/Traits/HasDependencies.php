<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

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
     * @todo: this doesn't belong here / find some other way
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        if ($data->has('dependencies')) {
            $this->dependencies = json_encode($data->get('dependencies'));
        }

        return parent::fillCustom($data);
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
     * {@inheritDoc}
     */
    public function provideDependencies(): Collection
    {
        return $this->dependencies->map(function ($dependency_type) {
            return app($dependency_type);
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
     * Obtain dependency types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableDependencyTypes(): Collection
    {
        return static::getConfigData('available-dependencies');
    }
}
