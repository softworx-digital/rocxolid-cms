<?php

namespace Softworx\RocXolid\CMS\Models\Tables\Newsletter;

// rocXolid table columns
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;
use Softworx\RocXolid\Tables\Columns\Type\ImageRelation;
// rocXolid table buttons
use Softworx\RocXolid\Tables\Buttons\Type\ButtonAnchor;
use Softworx\RocXolid\CMS\Models\Tables\Columns\Type\PageRelation;
// rocXolid CMS tables
use Softworx\RocXolid\CMS\Models\Tables\AbstractCrudCMSTable;

/**
 *
 */
class Index extends AbstractCrudCMSTable
{
    protected $columns = [
        'web_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'web'
                ],
                'relation' => [
                    'name' => 'web',
                    'column' => 'title',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'text' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'text'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'text_mobile' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'text_mobile'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_email' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_email'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_button' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_button'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_error' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_error'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_success' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_success'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
    ];
}
