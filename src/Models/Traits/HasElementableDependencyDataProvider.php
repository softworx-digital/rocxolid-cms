<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms support
use Softworx\RocXolid\CMS\Support\FakerElementableDependencyDataProvider;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Elementable dependencies data provider getter and setter.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasElementableDependencyDataProvider
{
    /**
     * Dependencies data provider reference.
     *
     * @var \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider
     */
    protected $dependencies_data_provider;

    /**
     * Set dependencies data provider.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider
     * @return mixed
     */
    public function setDependenciesDataProvider(ElementableDependencyDataProvider $dependencies_data_provider)
    {
        $this->dependencies_data_provider = $dependencies_data_provider;

        return $this;
    }

    /**
     * Get dependencies data provider.
     *
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider
     */
    public function getDependenciesDataProvider(): ElementableDependencyDataProvider
    {
        return $this->dependencies_data_provider ?? $this->getDefaultDependenciesDataProvider();
    }

    /**
     * Obtain default dependencies data provider.
     *
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider
     */
    protected function getDefaultDependenciesDataProvider(): ElementableDependencyDataProvider
    {
        return app(FakerElementableDependencyDataProvider::class);
    }
}
