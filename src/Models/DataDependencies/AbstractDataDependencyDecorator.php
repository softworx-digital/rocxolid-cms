<?php

namespace Softworx\RocXolid\CMS\Models\DataDependencies;

use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid cms dependencies contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 *
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractDataDependencyDecorator implements ElementableDependency
{
    /**
     * Wrapped dependency reference.
     *
     * @var \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency
     */
    protected $elementable_dependency;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency $elementable_dependency
     */
    public function __construct(ElementableDependency $elementable_dependency)
    {
        $this->elementable_dependency = $elementable_dependency;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function provideDependencyFieldDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array;

    /**
     * {@inheritDoc}
     */
    abstract public function getDataProviderFieldValue(ElementableDependencyDataProvider $dependency_data_provider, Collection $data, string $field_name);

    /**
     * {@inheritDoc}
     */
    public function getAssignmentDefaultName(): string
    {
        return $this->elementable_dependency->getAssignmentDefaultName();
    }

    /**
     * {@inheritDoc}
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $data_provider, ?string $key = null): ElementableDependency
    {
        return $this->elementable_dependency->addAssignment($assignments, $data_provider, $key);
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldNames(ElementableDependencyDataProvider $dependency_data_provider): Collection
    {
        return $this->elementable_dependency->provideDependencyFieldNames($dependency_data_provider);
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyDataPlaceholders(): Collection
    {
        return $this->elementable_dependency->provideDependencyDataPlaceholders();
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslatedTitle(TranslationPackageProvider $controller): string
    {
        return $this->elementable_dependency->getTranslatedTitle($controller);
    }
}