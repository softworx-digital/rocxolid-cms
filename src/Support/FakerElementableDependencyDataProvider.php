<?php

namespace Softworx\RocXolid\CMS\Support;

use Illuminate\Support\Collection;
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
    public function setDependencyValues(ElementsDependenciesProvider $document, Collection $data): ElementableDependencyDataProvider
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyValues(ElementableDependency $dependency)
    {
        return collect();
    }
}