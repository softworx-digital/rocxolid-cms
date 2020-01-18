<?php

namespace Softworx\RocXolid\CMS\Repositories\WebFrontpageSettings;

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
                    'title' => 'web_id'
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
        'logo' => [
            'type' => ImageRelation::class,
            'options' => [
                'label' => [
                    'title' => 'logo'
                ],
                'size' => 'thumb',
                'relation' => [
                    'name' => 'logo',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'favicon' => [
            'type' => ImageRelation::class,
            'options' => [
                'label' => [
                    'title' => 'favicon'
                ],
                'size' => '32x32',
                'relation' => [
                    'name' => 'favicon',
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
        'google_analytics_tracking_code' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'google_analytics_tracking_code'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'livechatoo_account' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'livechatoo_account'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'dognet_account_id' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'dognet_account_id'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'cssFiles' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'cssFiles'
                ],
                'relation' => [
                    'name' => 'cssFiles',
                ],
            ],
        ],
        'jsFiles' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'jsFiles'
                ],
                'relation' => [
                    'name' => 'jsFiles',
                ],
            ],
        ],
    ];

    protected $buttons = [
        'show' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-window-maximize',
                ],
                'attributes' => [
                    'class' => 'btn btn-info btn-sm margin-right-no',
                    'title-key' => 'show',
                ],
                'controller-method' => 'show',
                'permissions-method-group' => 'read-only',
            ],
        ],
        'show-modal' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'icon' => 'fa fa-window-restore',
                ],
                'attributes' => [
                    'class' => 'btn btn-info btn-sm margin-right-no',
                    'title-key' => 'show-modal',
                ],
                'controller-method' => 'show',
                'permissions-method-group' => 'read-only',
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
        'clone-pages' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'icon' => 'fa fa-clone',
                ],
                'attributes' => [
                    'class' => 'btn btn-warning btn-sm margin-right-no',
                    'title-key' => 'clone-structure',
                ],
                'controller-method' => 'cloneStructure',
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
