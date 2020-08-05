<?php

namespace Softworx\RocXolid\CMS\Models\Tables\Document;

// rocXolid table columns
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
// rocXolid table buttons
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;
// rocXolid table filters
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
// rocXolid cms tables
use Softworx\RocXolid\CMS\Models\Tables\AbstractCrudCMSTable;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DocumentType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;

/**
 *
 */
class Index extends AbstractCrudCMSTable
{
    protected $columns = [
        'is_enabled' => [
            'type' => ColumnType\SwitchFlag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
            ],
        ],
        'title' => [
            'type' => ColumnType\Text::class,
            'options' => [
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
        'document_type_id' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'document_type_id'
                ],
                'relation' => [
                    'name' => 'documentType',
                    'column' => 'title',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'theme' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'theme'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'valid_from' => [
            'type' => ColumnType\Date::class,
            'options' => [
                'label' => [
                    'title' => 'valid_from'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'valid_to' => [
            'type' => ColumnType\Date::class,
            'options' => [
                'label' => [
                    'title' => 'valid_to'
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
            'type' => ButtonType\ButtonAnchor::class,
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
            'type' => ButtonType\ButtonAnchor::class,
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

    protected $filters = [
        'web_id' => [
            'type' => FilterType\ModelRelation::class,
            'options' => [
                'label' => [
                    'title' => 'web_id'
                ],
                'collection' => [
                    'model' => Web::class,
                    'column' => 'name',
                ],
            ],
        ],
        'localization_id' => [
            'type' => FilterType\ModelRelation::class,
            'options' => [
                'label' => [
                    'title' => 'localization_id'
                ],
                'collection' => [
                    'model' => Localization::class,
                    'column' => 'name',
                ],
            ],
        ],
        'document_type_id' => [
            'type' => FilterType\ModelRelation::class,
            'options' => [
                'label' => [
                    'title' => 'document_type_id'
                ],
                'collection' => [
                    'model' => DocumentType::class,
                    'column' => 'title',
                ],
            ],
        ],
    ];

    protected function adjustFiltersDefinition($filters)
    {
        // @todo: hotfixed
        $filters['web_id']['options']['label']['title'] = $this->getController()->translate('field.web_id');
        $filters['localization_id']['options']['label']['title'] = $this->getController()->translate('field.localization_id');
        $filters['document_type_id']['options']['label']['title'] = $this->getController()->translate('field.document_type_id');

        return $filters;
    }
}
