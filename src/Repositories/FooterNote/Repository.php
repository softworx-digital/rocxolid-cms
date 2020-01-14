<?php

namespace Softworx\RocXolid\CMS\Repositories\FooterNote;

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
        'first_line' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'first_line'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'copyright' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'copyright'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
    ];
}
