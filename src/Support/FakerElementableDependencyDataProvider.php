<?php

namespace Softworx\RocXolid\CMS\Support;

use Illuminate\Support\Collection;
use OCI_Collection;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
// rocXolid cms dependencies contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
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
    public function setDependencyData(ElementsDependenciesProvider $document, Collection $data): ElementableDependencyDataProvider
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyData(ElementableDependency $dependency): Collection
    {
        return collect();
    }

    /**
     * Check if the data provider is ready (has set dependency values).
     *
     * @return boolean
     */
    public function isReady(): bool
    {
        return false;
    }
}