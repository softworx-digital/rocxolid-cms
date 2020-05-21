<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
// rocXolid cms support
use Softworx\RocXolid\CMS\Support\PlaceholderElementableDependencyProvider;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Elementable dependencies provider getter and setter.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasElementsDependenciesProvider
{
    /**
     * Dependencies provider reference.
     *
     * @var \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider
     */
    protected $dependencies_provider;

    /**
     * Set dependencies provider.
     *
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function setDependenciesProvider(ElementsDependenciesProvider $dependencies_provider): Element
    {
        $this->dependencies_provider = $dependencies_provider;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependenciesProvider(): ElementsDependenciesProvider
    {
        return $this->dependencies_provider ?? $this->getDefaultDependenciesProvider();
    }

    /**
     * Obtain default dependencies provider.
     *
     * @return \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider
     */
    public function getDefaultDependenciesProvider(): ElementsDependenciesProvider
    {
        return app(PlaceholderElementableDependencyProvider::class);
    }
}
