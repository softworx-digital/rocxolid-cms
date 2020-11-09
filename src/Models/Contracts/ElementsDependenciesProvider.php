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
     * Obtain available dependencies that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableDependencies(): Collection;

    /**
     * Obtain all dependencies assigned to the model.
     *
     * @param bool $sub
     * @return \Illuminate\Support\Collection
     */
    public function provideDependencies(bool $sub = false): Collection;
}