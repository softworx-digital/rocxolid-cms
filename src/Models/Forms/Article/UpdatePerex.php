<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Perex data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdatePerex extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'perex-data',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [
        'perex' => [
            'type' => FieldType\WysiwygTextarea::class,
            'options' => [
                'label' => [
                    'title' => 'perex',
                ],
                'validation' => [
                    'rules' => [
                        // 'maxplain:10000',
                    ],
                ],
                'attributes' => [
                    // 'maxlength' => '10000',
                ],
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        return $fields;
    }
}
