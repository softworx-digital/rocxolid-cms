<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies;

// rocXolid cms dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\AbstractElementableDependency;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Provide no dependency for elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class None extends AbstractElementableDependency
{
    public function getDependencyViewValue(ElementableDependencyDataProvider $dependency_data_provider)
    {
        return null;
    }
}
