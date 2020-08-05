<?php

namespace Softworx\RocXolid\CMS\Models\Tables\DocumentType;

use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;

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
        'icon' => [
            'type' => ColumnType\Icon::class,
            'options' => [
                'label' => [
                    'title' => 'icon'
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