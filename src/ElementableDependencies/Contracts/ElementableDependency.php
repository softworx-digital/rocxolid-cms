<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Contracts;

use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Enables to provide dependency for elementables.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementableDependency
{
    /**
     * Check if the dependency has some subdependencies.
     *
     * @return boolean
     */
    public function hasSubdependencies(): bool;

    /**
     * Obtain subdependencies.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideSubDependencies(): Collection;

    /**
     * Obtain default property name this dependency sets (to a view).
     *
     * @return string
     */
    public function getAssignmentDefaultName(): string;

    /**
     * Decide if there is an assignment for the dependency in data provider dependency values.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $data_provider
     * @return boolean
     */
    public function hasAssignment(ElementableDependencyDataProvider $data_provider): bool;

    /**
     * Add the assignment this dependency handles to an (view) assignments collection.
     *
     * @param \Illuminate\Support\Collection $assignments
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $data_provider
     * @param string|null $key
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency
     * @throws \RuntimeException If assignments key already set.
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $data_provider, ?string $key = null): ElementableDependency;

    /**
     * Provide dependency fields names.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @param bool $with_subdependencies
     * @return \Illuminate\Support\Collection
     */
    public function provideDependencyFieldsNames(ElementableDependencyDataProvider $dependency_data_provider, bool $with_subdependencies = true): Collection;

    /**
     * Provide dependency fields definition.
     *
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @return array
     */
    public function provideDependencyFieldsDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array;

    /**
     * Provide fields definition for dependency value filters.
     *
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @return array
     */
    public function provideDependencyFieldValuesFilterFieldsDefinition(AbstractCrudForm $form): array;

    /**
     * Provide dependency field value.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @param \Illuminate\Support\Collection $data
     * @param string $field_name
     * @return mixed
     */
    public function getDataProviderFieldValue(ElementableDependencyDataProvider $dependency_data_provider, Collection $data, string $field_name);

    /**
     * Retrieve the value of the dependency extracting it from the dependency data provider's values to be presented.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @return mixed
     */
    public function getDependencyViewValue(ElementableDependencyDataProvider $dependency_data_provider);

    /**
     * Provide set of dependency data placeholders with their options that can be used in content composition.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideDependencyDataPlaceholders(): Collection;

    /**
     * Retrieve translated dependency title.
     *
     * @param \Softworx\RocXolid\Contracts\TranslationPackageProvider\TranslationPackageProvider $controller
     * @return string
     */
    public function getTranslatedTitle(TranslationPackageProvider $controller): string;

    /**
     * Validate form data in dependency assignment rules.
     *
     * @param \Illuminate\Support\Collection $data
     * @param string $attribute
     * @return bool
     */
    public function validateAssignmentData(Collection $data, string $attribute): bool;

    /**
     * Obtain error message for validation process.
     *
     * @param \Softworx\RocXolid\Contracts\TranslationPackageProvider $controller
     * @param \Illuminate\Support\Collection $data
     * @return string
     */
    public function assignmentValidationErrorMessage(TranslationPackageProvider $controller, Collection $data): string;
}
