<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Contracts;

use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Controllable;
use Softworx\RocXolid\Contracts\TranslationDiscoveryProvider;
use Softworx\RocXolid\Contracts\TranslationProvider;
// rocXolid cms dependencies contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

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
     * Add assignment this dependency handles to a assignments collection.
     *
     * @param \Illuminate\Support\Collection $assignments
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $data_provider
     * @param string|null $key
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency
     * @throws \RuntimeException If assignments key already set.
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $data_provider, ?string $key = null): ElementableDependency;

    /**
     * Obtain default property name this dependency sets to a view.
     *
     * @return string
     */
    public function getDefaultViewPropertyName(): string;

    /**
     * Provide dependency field definition.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $data_provider
     * @return array
     */
    public function provideDependencyFieldDefinition(ElementableDependencyDataProvider $data_provider): array;
}
