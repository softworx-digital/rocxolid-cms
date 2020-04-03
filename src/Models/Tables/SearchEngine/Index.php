<?php

namespace Softworx\RocXolid\CMS\Models\Tables\SearchEngine;

// columns
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;
use Softworx\RocXolid\Tables\Columns\Type\ImageRelation;
use Softworx\RocXolid\Tables\Columns\Type\ButtonAnchor;
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
        'title' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'title'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'subtitle' => [
            'type' => Text::class,
            'options' => [
                'shorten' => 150,
                'label' => [
                    'title' => 'subtitle'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_option_products' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_option_products'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_option_advice' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_option_advice'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_phrase' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_phrase'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_button' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_button'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'results' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'results'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'results_button' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'results_button'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'results_empty' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'results_empty'
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
