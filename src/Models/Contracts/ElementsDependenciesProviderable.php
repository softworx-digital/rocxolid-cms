<?php

namespace Softworx\RocXolid\CMS\Models\Contracts;

use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;

/**
 * Enables to retrieve a dependencies provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementsDependenciesProviderable
{
    /**
     * Retrieve dependencies provider for elements.
     *
     * @return \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider
     */
    public function getDependenciesProvider(): ElementsDependenciesProvider;
}