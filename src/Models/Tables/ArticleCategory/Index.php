<?php

namespace Softworx\RocXolid\CMS\Models\Tables\ArticleCategory;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $columns = [
        'is_enabled' => [
            'type' => ColumnType\SwitchFlag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
            ],
        ],
        'position' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'position'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'title' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'title'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'subtitle' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'subtitle'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'description' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'description'
                ],
            ],
        ],
    ];
}
