<?php

namespace Softworx\RocXolid\CMS\Models\Tables;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Tables\Filters\Type\Select as SelectFilter;
use Softworx\RocXolid\Tables\Filters\Type\ModelRelation as ModelRelationFilter;
// models
use Softworx\RocXolid\Common\Models\Web;

/**
 *
 */
class AbstractCrudCMSTable extends AbstractCrudTable
{
    protected $filters = [
        'web_id' => [
            'type' => ModelRelationFilter::class,
            'options' => [
                'label' => [
                    'title' => 'web'
                ],
                'collection' => [
                    'model' => Web::class,
                    'column' => 'name',
                ],
            ],
        ],
    ];
}
