<?php

namespace Softworx\RocXolid\CMS\Mutators;

// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms mutators contracts
use Softworx\RocXolid\CMS\Mutators\AbstractMutator;

/**
 * Makes the content string reversed.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Reverse extends AbstractMutator
{
    /**
     * {@inheritDoc}
     */
    protected $translation_package = 'rocXolid:cms';

    /**
     * {@inheritDoc}
     */
    public function mutate(ElementableDependencyDataProvider $data_provider, string $value): string
    {
        return strrev($value);
    }
}
