<?php

namespace Softworx\RocXolid\CMS\Models\Contracts;

use Illuminate\Support\Collection;
// rocXolid cms mutators contracts
use Softworx\RocXolid\CMS\Mutators\Contracts\Mutator;

/**
 * Enables mutators to be provided.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementsMutatorsProvider
{
    /**
     * Retrieve mutators for elements' content.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideMutators(): Collection;

    /**
     * Retrieve mutator for elements' content by given key.
     *
     * @param string $key
     * @return \Softworx\RocXolid\CMS\Mutators\Contracts\Mutator|null
     */
    public function getMutator(string $key): ?Mutator;
}