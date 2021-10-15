<?php

namespace Softworx\RocXolid\CMS\Models\Forms\PageFooter;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 *
 */
class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'page_id' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:cms_pages,id',
                    ],
                ],
            ],
        ],
        'title' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'title',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:100',
                    ],
                ],
            ],
        ],
        'is_bound' => [
            'type' => FieldType\CheckboxToggle::class,
            'options' => [
                'label' => [
                    'title' => 'is_bound',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['page_id']['options']['value'] = $this->getInputFieldValue('page_id');

        return $fields;
    }
}
