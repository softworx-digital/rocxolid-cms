<?php

namespace Softworx\RocXolid\CMS\Models\DataDependencies;

use Illuminate\Support\Collection;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid cms contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DataDependencies\AbstractDataDependencyDecorator;

/**
 * Decorator for SET typed custom data dependencies.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class SetDecorator extends AbstractDataDependencyDecorator
{
    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        $custom_values = collect($form->getInputFieldValue($this->getAssignmentDefaultName()) ?? [])->filter(function ($value) {
            return !is_numeric($value) || !$this->elementable_dependency->values->keys()->contains($value);
        })->mapWithKeys(function ($value) {
            return [
                $value => $value
            ];
        });

        return [
            $this->getAssignmentDefaultName() => [
                'type' => FieldType\CollectionCheckbox::class,
                'options' => [
                    'type-template' => 'collection-checkbox-buttons',
                    'collection' => $this->elementable_dependency->values->merge($custom_values),
                    'label' => [
                        'title-translated' => $this->elementable_dependency->getTitle(),
                        'hint-translated' => $this->elementable_dependency->description,
                    ],
                    'value' => $this->elementable_dependency->is_default_value->filter()->keys(),
                    'validation' => [
                        'rules' => [
                            'required',
                        ],
                    ],
                    'enable-custom-values' => true,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getDataProviderFieldValue(ElementableDependencyDataProvider $dependency_data_provider, Collection $data, string $field_name): string
    {
        return $data->get($field_name)->filter(function ($value) {
            return !is_null($value);
        })->transform(function ($value) {
            // @todo: this is not quite reliable
            return is_numeric($value)
                ? $this->elementable_dependency->values->get($value)
                : $value;
        })->join(sprintf(' %s ', $this->elementable_dependency->conjunction));
    }
}