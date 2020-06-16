<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Contracts;

use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Controllable;
use Softworx\RocXolid\Contracts\TranslationDiscoveryProvider;
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
use Softworx\RocXolid\Contracts\TranslationProvider;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
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
     * Retrieve translated dependency title.
     *
     * @param \Softworx\RocXolid\Contracts\TranslationPackageProvider\TranslationPackageProvider $controller
     * @return string
     */
    public function getTitle(TranslationPackageProvider $controller): string;

    /**
     * Obtain default property name this dependency sets to a view.
     *
     * @return string
     */
    public function getAssignmentDefaultName(): string;

    /**
     * Provide dependency field names.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @return \Illuminate\Support\Collection
     */
    public function provideDependencyFieldNames(ElementableDependencyDataProvider $dependency_data_provider): Collection;

    /**
     * Provide dependency field definition.
     *
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @return array
     */
    public function provideDependencyFieldDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array;

    /**
     * Provide set of dependency data placeholders with their options that can be used in content composition.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideDependencyDataPlaceholders(): Collection;
}
