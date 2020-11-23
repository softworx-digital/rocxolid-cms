<?php

namespace Softworx\RocXolid\CMS\Support;

use Illuminate\Support\Collection;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
// rocXolid cms mutators contracts
use Softworx\RocXolid\CMS\Mutators\Contracts\Mutator;

/**
 * Fakes mutator provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class PlaceholderMutatorProvider implements ElementsMutatorsProvider
{
    /**
     * {@inheritDoc}
     */
    public function provideMutators(): Collection
    {
        return collect();
    }

    /**
     * {@inheritDoc}
     */
    public function getMutator(string $key): ?Mutator
    {
        return null;
    }
}
