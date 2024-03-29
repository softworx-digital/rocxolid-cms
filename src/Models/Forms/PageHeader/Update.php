<?php

namespace Softworx\RocXolid\CMS\Models\Forms\PageHeader;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 *
 */
class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
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
}
