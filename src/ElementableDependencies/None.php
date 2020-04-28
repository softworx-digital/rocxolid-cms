<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\AbstractElementDependency;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;

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
    protected $translation_key = 'none';

    /**
     * {@inheritDoc}
     */
    public function provideTypeDependency(Elementable $elementable): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldDefinition(AbstractCrudForm $form, Elementable $elementable): array
    {
        return [];
    }
}
