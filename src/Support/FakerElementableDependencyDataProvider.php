<?php

namespace Softworx\RocXolid\CMS\Support;

use Illuminate\Support\Collection;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Fakes dependency data provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class FakerElementableDependencyDataProvider implements ElementableDependencyDataProvider
{
    /**
     * {@inheritDoc}
     */
    public function setDependencyData(ElementsDependenciesProvider $dependencies_provider, Collection $data): ElementableDependencyDataProvider
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyData(): Collection
    {
        return collect();
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies(array $except = []): Collection
    {
        return collect();
    }

    /**
     * Check if the data provider is ready (has set dependency values).
     *
     * @return bool
     */
    public function isReady(): bool
    {
        return false;
    }
}
