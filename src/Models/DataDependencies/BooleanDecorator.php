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
 * Decorator for BOOLEAN typed custom data dependencies.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class BooleanDecorator extends AbstractDataDependencyDecorator
{
    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldsDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        return [
            $this->getAssignmentDefaultName() => [
                'type' => FieldType\CheckboxToggle::class,
                'options' => [
                    'label' => [
                        'title-translated' => $this->elementable_dependency->getTitle(),
                        'hint-translated' => $this->elementable_dependency->description,
                    ],
                    'value' => (int)$this->elementable_dependency->default_value_boolean,
                    'validation' => [
                        'rules' => [
                            'in:0,1'
                        ],
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
        return $data->get($field_name) ? $this->elementable_dependency->yes_title : $this->elementable_dependency->no_title;
    }
}