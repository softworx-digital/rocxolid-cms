<?php

namespace Softworx\RocXolid\CMS\Repositories\Link;

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
    protected static $translation_param = 'cms-link';

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
    ];
}