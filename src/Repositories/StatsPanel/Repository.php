<?php

namespace Softworx\RocXolid\CMS\Repositories\StatsPanel;

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
    protected static $translation_param = 'cms-stats-panel';

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
        'percent_count' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'percent_count'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'percent_line_1' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'percent_line_1'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'percent_line_2' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'percent_line_2'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'counter_line_1' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'counter_line_1'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'counter_line_2' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'counter_line_2'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'years_count' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'years_count'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'years_line_1' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'years_line_1'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'years_line_2' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'years_line_2'
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