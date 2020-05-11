<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Contracts;

use Illuminate\Support\Collection;
// rocXolid cms dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;

/**
 * Enables models to provide data to dependecies.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementableDependencyDataProvider
{
    /**
     * Set dependency values.
     *
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider $dependencies_provider
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider
     */
    public function setDependencyValues(ElementsDependenciesProvider $dependencies_provider, Collection $data): ElementableDependencyDataProvider;

    /**
     * Retrieve dependency value.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency $dependency
     * @return mixed
     */
    public function getDependencyValues(ElementableDependency $dependency);

    /**
     * Check if the data provider is ready to provide dependency values.
     *
     * @return boolean
     */
    public function isReady(): bool;
}