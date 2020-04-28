<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Contracts;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Controllable;
use Softworx\RocXolid\Contracts\TranslationDiscoveryProvider;
use Softworx\RocXolid\Contracts\TranslationProvider;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;

/**
 * Enables to provide dependency for elementables.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementableDependency extends Controllable, TranslationDiscoveryProvider, TranslationProvider
{
    /**
     * Provide dependent type declaration.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $elementable
     * @return string|null
     */
    public function provideTypeDependency(Elementable $elementable): ?string;

    /**
     * Provide dependency field definition.
     *
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $elementable
     * @return array
     */
    public function provideDependencyFieldDefinition(AbstractCrudForm $form, Elementable $elementable): array;
}
