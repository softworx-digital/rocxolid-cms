<?php

namespace Softworx\RocXolid\CMS\Models\Forms\DataDependency\Traits;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DataDependency;

/**
 *
 */
trait DataDependencyForm
{
    protected function adjustFieldsDefinition($fields)
    {
        collect([ 'is_enabled', 'web_id', 'localization_id', 'localization_id', 'type', 'title' ])->each(function ($field_name) use (&$fields) {
            $fields[$field_name]['options']['group'] = 'base';
        });

        collect([ 'description', 'note' ])->each(function ($field_name) use (&$fields) {
            $fields[$field_name]['options']['group'] = 'additional';
        });

        // $fields['web_id']['options']['show-null-option'] = true;
        $fields['web_id']['options']['validation']['rules'][] = 'required';
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        // $fields['localization_id']['options']['show-null-option'] = true;
        $fields['localization_id']['options']['validation']['rules'][] = 'required';
        $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');
        $fields['localization_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        // $column = $this->getConnection()->getDoctrineColumn($this->getModel()->getTable(), 'type');
        $fields['type']['type'] = FieldType\CollectionRadioList::class;
        $fields['type']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        $fields['type']['options']['collection'] = collect(DataDependency::getTypeOptions())->mapWithKeys(function ($type) {
            return [
                $type => $this->getController()->translate(sprintf('type.%s', $type))
            ];
        });

        $type = $this->getInputFieldValue('type') ?? $this->getModel()->type;

        $this
            ->adjustRequiredFieldDefinition($type, $fields)
            ->adjustDefaultValueFieldDefinition($type, $fields)
            ->adjustValuesFieldDefinition($type, $fields)
            ->adjustConjunctionFieldDefinition($type, $fields)
            ->adjustMinMaxFieldDefinition($type, $fields)
            ->adjustYesNoTitleFieldDefinition($type, $fields);

        return $fields;
    }

    protected function adjustRequiredFieldDefinition(?string $type, array &$fields): RocXolidAbstractCrudForm
    {
        if (collect([ 'string', 'text', 'date' ])->contains($type)) {
            $fields['is_required'] = [
                'type' => FieldType\CheckboxToggle::class,
                'options' => [
                    'group' => 'base',
                    'label' => [
                        'title' => 'is_required',
                    ],
                    'validation' => [
                        'rules' => [
                            'required',
                        ],
                    ],
                ],
            ];
        } elseif (isset($fields['is_required'])) {
            unset($fields['is_required']);
        }

        return $this;
    }

    protected function adjustDefaultValueFieldDefinition(?string $type, array &$fields): RocXolidAbstractCrudForm
    {
        collect(DataDependency::getTypeOptions())->each(function ($type) use (&$fields) {
            if (isset($fields[sprintf('default_value_%s', $type)])) {
                unset($fields[sprintf('default_value_%s', $type)]);
            }
        });

        $field_name = sprintf('default_value_%s', $type);

        $fields[$field_name] = [
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => $field_name,
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
                    ],
                ],
            ],
        ];

        switch ($type) {
            case 'boolean':
                $fields[$field_name]['type'] = FieldType\CollectionRadioList::class;
                $fields[$field_name]['options']['justified'] = false;
                $fields[$field_name]['options']['validation']['rules'][] = 'in:0,1';
                $fields[$field_name]['options']['collection'] = collect([ 1 => 'yes', 0 => 'no' ])->mapWithKeys(function ($option, $index) {
                    return [
                        $index => $this->getController()->translate(sprintf('boolean.%s', $option))
                    ];
                });
                break;
            case 'integer':
                $fields[$field_name]['type'] = FieldType\Input::class;
                $fields[$field_name]['options']['validation']['rules'][] = 'integer';
                break;
            case 'decimal':
                $fields[$field_name]['type'] = FieldType\Input::class;
                $fields[$field_name]['options']['validation']['rules'][] = 'decimal';
                break;
            case 'string':
                $fields[$field_name]['type'] = FieldType\Input::class;
                $fields[$field_name]['options']['validation']['rules'][] = 'max:255';
                break;
            case 'text':
                $fields[$field_name]['type'] = FieldType\Textarea::class;
                $fields[$field_name]['options']['validation']['rules'][] = 'maxplain:10000';
                $fields[$field_name]['options']['attributes']['maxlength'] = '10000';
                break;
            case 'date':
                $fields[$field_name]['type'] = FieldType\CollectionRadioList::class;
                $fields[$field_name]['options']['justified'] = false;
                $fields[$field_name]['options']['validation']['rules'][] = 'in:,today';
                $fields[$field_name]['options']['collection'] = collect([ null => 'null', 'today' => 'today' ])->mapWithKeys(function ($option, $index) {
                    return [
                        $index => $this->getController()->translate(sprintf('date.%s', $option))
                    ];
                });
                break;
            default:
                unset($fields[$field_name]);
                break;
        }

        return $this;
    }

    protected function adjustConjunctionFieldDefinition(?string $type, array &$fields): RocXolidAbstractCrudForm
    {
        if (collect([ 'set' ])->contains($type)) {
            $fields['conjunction'] = [
                'type' => FieldType\Input::class,
                'options' => [
                    'group' => 'base',
                    'label' => [
                        'title' => 'conjunction',
                    ],
                    'validation' => [
                        'rules' => [
                            'required',
                        ],
                    ],
                ],
            ];
        } elseif (isset($fields['conjunction'])) {
            unset($fields['conjunction']);
        }

        return $this;
    }

    protected function adjustMinMaxFieldDefinition(?string $type, array &$fields): RocXolidAbstractCrudForm
    {
        if (collect([ 'integer', 'decimal' ])->contains($type)) {
            $fields['min'] = [
                'type' => FieldType\Input::class,
                'options' => [
                    'group' => 'base',
                    'label' => [
                        'title' => 'min',
                    ],
                    'validation' => [
                        'rules' => [
                            'nullable',
                            $type,
                        ],
                    ],
                ],
            ];

            $fields['max'] = [
                'type' => FieldType\Input::class,
                'options' => [
                    'group' => 'base',
                    'label' => [
                        'title' => 'max',
                    ],
                    'validation' => [
                        'rules' => [
                            'nullable',
                            $type,
                        ],
                    ],
                ],
            ];
        } else {
            if (isset($fields['min'])) {
                unset($fields['min']);
            }

            if (isset($fields['max'])) {
                unset($fields['max']);
            }
        }

        return $this;
    }

    protected function adjustYesNoTitleFieldDefinition(?string $type, array &$fields): RocXolidAbstractCrudForm
    {
        if (collect([ 'boolean' ])->contains($type)) {
            $fields['yes_title'] = [
                'type' => FieldType\Input::class,
                'options' => [
                    'group' => 'base',
                    'label' => [
                        'title' => 'yes_title',
                    ],
                    'validation' => [
                        'rules' => [
                            // 'required',
                        ],
                    ],
                ],
            ];

            $fields['no_title'] = [
                'type' => FieldType\Input::class,
                'options' => [
                    'group' => 'base',
                    'label' => [
                        'title' => 'no_title',
                    ],
                    'validation' => [
                        'rules' => [
                            // 'required',
                        ],
                    ],
                ],
            ];
        } else {
            if (isset($fields['yes_title'])) {
                unset($fields['yes_title']);
            }

            if (isset($fields['no_title'])) {
                unset($fields['no_title']);
            }
        }

        return $this;
    }

    protected function adjustValuesFieldDefinition(?string $type, array &$fields): RocXolidAbstractCrudForm
    {
        if (collect([ 'enum', 'set' ])->contains($type)) {
            $fields['values'] = [
                'type' => FieldType\Input::class,
                'options' => [
                    'array' => true,
                    'group' => FieldType\FormFieldGroupAddable::DEFAULT_NAME,
                    'label' => [
                        'title' => '_values.value',
                    ],
                    'attributes' => [
                        'col' => 'col-xs-11',
                        'class' => 'form-control width-100',
                    ],
                    'validation' => [
                        'rules' => [
                            'required',
                            'distinct',
                        ],
                    ],
                ],
            ];

            $fields['is_default_value'] = [
                'type' =>  FieldType\CheckboxToggle::class,
                'options' => [
                    'array' => true,
                    'group' => FieldType\FormFieldGroupAddable::DEFAULT_NAME,
                    'pivot-for' => 'values',
                    'label' => [
                        'after' => false,
                        'title' => '_values.is_default_value',
                        'attributes' => [
                            'class' => null,
                        ],
                    ],
                    'attributes' => [
                        'col' => 'col-xs-1',
                        'class' => 'form-control width-100',
                    ],
                    'value' => $this->getModel()->is_default_value,
                ],
            ];

            if ($type === 'enum') {
                $fields['is_default_value']['options']['attributes']['data-uncheck-group'] = 'is_default_value';
            }
        } elseif (isset($fields['values'])) {
            unset($fields['values']);
        }

        return $this;
    }
}
