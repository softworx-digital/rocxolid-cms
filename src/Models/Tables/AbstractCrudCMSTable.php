<?php

namespace Softworx\RocXolid\CMS\Models\Tables;

// rocXolid tables
use Softworx\RocXolid\Tables\AbstractCrudTable;
// rocXolid table filters
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
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
    ];

    protected function adjustFiltersDefinition($filters)
    {
        // @todo: hotfixed
        $filters['web_id']['options']['label']['title'] = $this->getController()->translate('field.web_id');
        $filters['localization_id']['options']['label']['title'] = $this->getController()->translate('field.localization_id');

        return $filters;
    }
}
