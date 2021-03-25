<?php

namespace Softworx\RocXolid\CMS\Models\Tables;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;

/**
 *
 */
class AbstractCrudCMSTable extends AbstractCrudTable
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
    ];

    protected function adjustFiltersDefinition($filters)
    {
        // @todo hotfixed
        $filters['web_id']['options']['label']['title'] = $this->getController()->translate('field.web_id');
        $filters['localization_id']['options']['label']['title'] = $this->getController()->translate('field.localization_id');

        return $filters;
    }
}
