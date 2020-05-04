<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies;

// rocXolid cms dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\AbstractElementDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Provide no dependency for elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class None extends AbstractElementDependency
{
    /**
     * {@inheritDoc}
     */
    public function setViewProperties(View &$view, ElementableDependencyDataProvider $data_provider): ElementableDependency
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldDefinition(ElementableDependencyDataProvider $data_provider): array
    {
        return [];
    }
}
