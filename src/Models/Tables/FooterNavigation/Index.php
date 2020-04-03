<?php

namespace Softworx\RocXolid\CMS\Models\Tables\FooterNavigation;

// columns
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;
use Softworx\RocXolid\Tables\Columns\Type\ImageRelation;
use Softworx\RocXolid\Tables\Columns\Type\ButtonAnchor;
use Softworx\RocXolid\CMS\Models\Tables\Columns\Type\Link;
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
        ],/*
        'delivery' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'delivery'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'delivery_link' => [
            'type' => Link::class,
            'options' => [
                'label' => [
                    'title' => 'delivery_link'
                ],
                'attribute_param' => 'delivery',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*/
        'gtc' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'gtc'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'gtc_link' => [
            'type' => Link::class,
            'options' => [
                'label' => [
                    'title' => 'delivery_link'
                ],
                'attribute_param' => 'gtc',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
    ];
}
