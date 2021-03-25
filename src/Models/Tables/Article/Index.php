<?php

namespace Softworx\RocXolid\CMS\Models\Tables\Article;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;
// rocXolid cms tables
use Softworx\RocXolid\CMS\Models\Tables\AbstractCrudCMSTable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;

/**
 *
 */
class Index extends AbstractCrudCMSTable
{
    protected $filters = [
        'web_id' => [
            'type' => FilterType\ModelRelation::class,
            'options' => [
                'collection' => [
                    'model' => Web::class,
                    'column' => 'name',
                ],
                'placeholder' => [
                    'title' => 'web_id',
                ],
            ],
        ],
        'localization_id' => [
            'type' => FilterType\ModelRelation::class,
            'options' => [
                'collection' => [
                    'model' => Localization::class,
                    'column' => 'name',
                ],
                'placeholder' => [
                    'title' => 'localization_id',
                ],
            ],
        ],
        'title' => [
            'type' => FilterType\Text::class,
            'options' => [
                'placeholder' => [
                    'title' => 'title',
                ],
            ],
        ],
    ];

    protected $columns = [
        'is_enabled' => [
            'type' => ColumnType\SwitchFlag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
            ],
        ],
        'image' => [
            'type' => ColumnType\ImageRelation::class,
            'options' => [
                'label' => [
                    'title' => 'image'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
                'size' => 'thumb',
                'relation' => [
                    'name' => 'image',
                ],
                'width' => 64,
            ],
        ],
        'title' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'orderable' => true,
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
        'date' => [
            'type' => ColumnType\Date::class,
            'options' => [
                'orderable' => true,
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
        'author_id' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'author_id'
                ],
                'relation' => [
                    'name' => 'author',
                    'column' => 'title',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'web_id' => [
            'type' => ColumnType\ModelRelation::class,
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
            'type' => ColumnType\ModelRelation::class,
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
    ];

    /**
     * {@inheritDoc}
     */
    protected $buttons = [
        'show' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-eye',
                ],
                'attributes' => [
                    'class' => 'btn btn-info btn-sm margin-right-no',
                    'title-key' => 'show',
                ],
                'policy-ability' => 'view',
                'action' => 'show',
            ],
        ],
        'delete-ajax' => [
            'type' => ButtonType\ButtonAnchor::class,
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
