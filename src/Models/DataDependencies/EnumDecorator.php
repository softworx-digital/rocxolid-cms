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
 * Decorator for ENUM typed custom data dependencies.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class EnumDecorator extends AbstractDataDependencyDecorator
{
    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        $index = $form->getInputFieldValue($this->getAssignmentDefaultName()) ?? $this->elementable_dependency->is_default_value->search(1);

        $custom_values = collect($form->getInputFieldValue($this->getAssignmentDefaultName()) ?? [])->filter(function ($value) {
            return !is_numeric($value) || !$this->elementable_dependency->values->keys()->contains($value);
        })->mapWithKeys(function ($value) {
            return [
                $value => $value
            ];
        });

        return [
            $this->getAssignmentDefaultName() => [
                'type' => FieldType\CollectionRadioList::class,
                'options' => [
                    'type-template' => 'collection-radio-list-buttons',
                    'collection' => $this->elementable_dependency->values->merge($custom_values),
                    'label' => [
                        'title-translated' => $this->elementable_dependency->getTitle(),
                        'hint-translated' => $this->elementable_dependency->description,
                    ],
                    'value' => ($index === false) ? null : $index,
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
        $value = $data->get($field_name);

        // @todo: this is not quite reliable
        return is_numeric($value)
            ? $this->elementable_dependency->values->get($value)
            : $value;
    }
}