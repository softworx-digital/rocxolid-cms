<?php

namespace Softworx\RocXolid\CMS\Models\Forms\DocumentHeader;

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
        'document_id' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:cms_documents,id',
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
        'is_bound_to_document' => [
            'type' => FieldType\CheckboxToggle::class,
            'options' => [
                'label' => [
                    'title' => 'is_bound_to_document',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['document_id']['options']['value'] = $this->getInputFieldValue('document_id');

        return $fields;
    }
}
