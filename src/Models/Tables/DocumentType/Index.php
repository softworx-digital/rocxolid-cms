<?php

namespace Softworx\RocXolid\CMS\Models\Tables\DocumentType;

use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\Icon;
use Softworx\RocXolid\Tables\Columns\Type\SwitchFlag;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $columns = [
        'is_enabled' => [
            'type' => SwitchFlag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
            ],
        ],
        'icon' => [
            'type' => Icon::class,
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
            'type' => Text::class,
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
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'description'
                ],
            ],
        ],
    ];
}