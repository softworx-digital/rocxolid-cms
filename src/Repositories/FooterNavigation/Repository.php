<?php

namespace Softworx\RocXolid\CMS\Repositories\FooterNavigation;

// columns
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;
use Softworx\RocXolid\Repositories\Columns\Type\ImageRelation;
use Softworx\RocXolid\Repositories\Columns\Type\ButtonAnchor;
use Softworx\RocXolid\CMS\Repositories\Columns\Type\Link;
// cms repository
use Softworx\RocXolid\CMS\Repositories\AbstractRepository;

/**
 *
 */
class Repository extends AbstractRepository
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