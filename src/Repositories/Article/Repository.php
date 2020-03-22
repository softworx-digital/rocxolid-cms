<?php

namespace Softworx\RocXolid\CMS\Repositories\Article;

// columns
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Flag;
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
        'is_enabled' => [
            'type' => Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
            ],
        ],
        'web_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'web_id'
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
        'localization_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'localization_id'
                ],
                'relation' => [
                    'name' => 'localization',
                    'column' => 'title',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'image' => [
            'type' => ImageRelation::class,
            'options' => [
                'label' => [
                    'title' => 'image'
                ],
                'size' => 'small',
                'relation' => [
                    'name' => 'image',
                ],
                'width' => 64,
            ],
        ],
        'date' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'date'
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
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'perex' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'perex'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
    ];

    protected $buttons = [
        'compose' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-object-group',
                ],
                'attributes' => [
                    'class' => 'btn btn-success btn-sm margin-right-no',
                    'title-key' => 'compose',
                ],
                'policy-ability' => 'view',
                'action' => 'show',
            ],
        ],
        'edit' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-pencil',
                ],
                'attributes' => [
                    'class' => 'btn btn-primary btn-sm margin-right-no',
                    'title-key' => 'edit',
                ],
                'policy-ability' => 'update',
                'action' => 'edit',
            ],
        ],
        'delete-ajax' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'icon' => 'fa fa-trash',
                ],
                'attributes' => [
                    'class' => 'btn btn-danger btn-sm margin-right-no',
                    'title-key' => 'delete',
                ],
                'policy-ability' => 'delete',
                'action' => 'destroyConfirm',
            ],
        ],
    ];
}
