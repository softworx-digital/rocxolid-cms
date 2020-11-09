<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies;

use Carbon\Carbon;
use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms elementable dependencies
use Softworx\RocXolid\CMS\ElementableDependencies\AbstractElementableDependency;

/**
 * Provide no dependency for elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class General extends AbstractElementableDependency
{
    /**
     * {@inheritDoc}
     */
    protected $translation_package = 'app';

    /**
     * Return localized current date.
     *
     * @return string
     */
    public function getCurrentDate(): string
    {
        return Carbon::now()->locale(app()->getLocale())->isoFormat('l');
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsNames(ElementableDependencyDataProvider $dependency_data_provider): Collection
    {
        return collect('general');
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyViewValue(ElementableDependencyDataProvider $dependency_data_provider)
    {
        return $dependency_data_provider->getDependencyData()->get($this->getAssignmentDefaultName());
    }

    /**
     * {@inheritDoc}
     */
    protected function transformDependencyValue(ElementableDependencyDataProvider $dependency_data_provider, string $key, $value)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function validateAssignmentData(Collection $data, string $attribute): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function assignmentValidationErrorMessage(TranslationPackageProvider $controller, Collection $data): string
    {
        return '';
    }
}
