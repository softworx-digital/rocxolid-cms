<?php

namespace Softworx\RocXolid\CMS\Models\Contracts;

use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;

/**
 * Enables to retrieve a mutators provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementsMutatorsProviderable
{
    /**
     * Retrieve mutators provider for elements.
     *
     * @return \Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider
     */
    public function getMutatorsProvider(): ElementsMutatorsProvider;
}
