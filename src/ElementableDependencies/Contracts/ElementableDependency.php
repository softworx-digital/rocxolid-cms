<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Contracts;

use Illuminate\View\View;
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
     * Set properties to view.
     *
     * @param \Illuminate\View\View $view
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $data_provider
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency
     */
    public function setViewProperties(View &$view, ElementableDependencyDataProvider $data_provider): ElementableDependency;

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
