<?php

namespace Softworx\RocXolid\CMS\Models\Tables\UserProfile;

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
    ];
}
