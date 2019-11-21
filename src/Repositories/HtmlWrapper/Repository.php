<?php

namespace Softworx\RocXolid\CMS\Repositories\HtmlWrapper;

// columns
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;
use Softworx\RocXolid\Repositories\Columns\Type\ImageRelation;
use Softworx\RocXolid\Repositories\Columns\Type\ButtonAnchor;
use Softworx\RocXolid\CMS\Repositories\Columns\Type\PageRelation;
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
                    'column' => 'title',
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
        'html_wrap_open' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'html_wrap_open'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'html_wrap_close' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'html_wrap_close'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-right',
                    ],
                ],
            ],
        ],
    ];
}