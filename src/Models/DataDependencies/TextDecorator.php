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
 * Decorator for TEXT typed custom data dependencies.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class TextDecorator extends AbstractDataDependencyDecorator
{
    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        return [
            $this->getAssignmentDefaultName() => [
                'type' => FieldType\Textarea::class,
                'options' => [
                    'label' => [
                        'title-translated' => $this->elementable_dependency->getTitle(),
                        'hint-translated' => $this->elementable_dependency->description,
                    ],
                    'value' => $this->elementable_dependency->getAttributeViewValue('default_value_text'),
                    'validation' => [
                        'rules' => [
                            $this->elementable_dependency->is_required ? 'required' : 'nullable',
                            'maxplain:10000',
                        ],
                    ],
                    'attributes' => [
                        'maxlength' => '10000',
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getDataProviderFieldValue(ElementableDependencyDataProvider $dependency_data_provider, Collection $data, string $field_name): string
    {
        return $data->get($field_name) ?? '';
    }
}