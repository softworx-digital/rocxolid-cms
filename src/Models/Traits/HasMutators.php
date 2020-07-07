<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
// rocXolid cms mutators contracts
use Softworx\RocXolid\CMS\Mutators\Contracts\Mutator;

/**
 * Trait for mutable elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasMutators
{
    /**
     * {@inheritDoc}
     */
    public function provideMutators(): Collection
    {
        return $this->getAvailableMutatorTypes()->transform(function ($type, $key) {
            return app($type)->setParam($key);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getMutator(string $key): ?Mutator
    {
        return app($this->getAvailableMutatorTypes()->get($key));
    }

    /**
     * {@inheritDoc}
     */
    public function getMutatorsProvider(): ElementsMutatorsProvider
    {
        return $this;
    }

    /**
     * Obtain dependency types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableMutatorTypes(): Collection
    {
        return static::getConfigData('available-mutators');
    }
}
