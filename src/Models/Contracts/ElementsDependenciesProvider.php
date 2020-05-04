<?php

namespace Softworx\RocXolid\CMS\Models\Contracts;

use Illuminate\Support\Collection;

/**
 * Enables dependecies to be provided to elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementsDependenciesProvider
{
    /**
     * Retrieve dependency definitions for elements.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideDependencies(): Collection;

    /**
     * Retrieve view theme for elements.
     *
     * @return string
     */
    public function provideViewTheme(): string;
}