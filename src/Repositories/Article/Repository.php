<?php

namespace Softworx\RocXolid\CMS\Repositories\Article;

// columns
use Softworx\RocXolid\Repositories\Columns\Type\Text,
    Softworx\RocXolid\Repositories\Columns\Type\Flag,
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
        'localization_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'localization'
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
                'dimension' => 'small',
                'relation' => [
                    'name' => 'image',
                ],
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
                'controller-method' => 'show',
                'permissions-method-group' => 'write',
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
                'controller-method' => 'edit',
                'permissions-method-group' => 'write',
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
                'controller-method' => 'destroyConfirm',
                'permissions-method-group' => 'write',
            ],
        ],
    ];
}