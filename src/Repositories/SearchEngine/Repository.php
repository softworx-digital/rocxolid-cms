<?php

namespace Softworx\RocXolid\CMS\Repositories\SearchEngine;

// columns
use Softworx\RocXolid\Repositories\Columns\Type\Text,
    Softworx\RocXolid\Repositories\Columns\Type\ModelRelation,
    Softworx\RocXolid\Repositories\Columns\Type\ImageRelation,
    Softworx\RocXolid\Repositories\Columns\Type\ButtonAnchor,
    Softworx\RocXolid\CMS\Repositories\Columns\Type\PageRelation;
// cms repository
use Softworx\RocXolid\CMS\Repositories\AbstractRepository;
/**
 *
 */
class Repository extends AbstractRepository
{
    protected static $translation_param = 'cms-search-engine';

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