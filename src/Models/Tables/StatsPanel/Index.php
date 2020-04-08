<?php

namespace Softworx\RocXolid\CMS\Models\Tables\StatsPanel;

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
