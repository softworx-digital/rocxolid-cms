<?php

namespace Softworx\RocXolid\CMS\Models\Tables\Document;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;
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
    protected $filters = [
        'web_id' => [
            'type' => FilterType\ModelRelation::class,
            'options' => [
                'collection' => [
                    'model' => Web::class,
                    'column' => 'name',
                ],
                'placeholder' => [
                    'title' => 'web_id'
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
                    'title' => 'localization_id'
                ],
            ],
        ],
        'document_type_id' => [
            'type' => FilterType\ModelRelation::class,
            'options' => [
                'collection' => [
                    'model' => DocumentType::class,
                    'column' => 'title',
                ],
                'placeholder' => [
                    'title' => 'document_type_id'
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
        'compose' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-columns',
                ],
                'attributes' => [
                    'class' => 'btn btn-info btn-sm margin-right-no',
                    'title-key' => 'compose',
                ],
                'policy-ability' => 'update',
                'action' => 'show',
                'route-params' => [
                    'tab' => 'composition',
                ],
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

    protected function adjustFiltersDefinition($filters)
    {
        // @todo hotfixed
        $filters['web_id']['options']['label']['title'] = $this->getController()->translate('field.web_id');
        $filters['localization_id']['options']['label']['title'] = $this->getController()->translate('field.localization_id');
        $filters['document_type_id']['options']['label']['title'] = $this->getController()->translate('field.document_type_id');

        return $filters;
    }
}
