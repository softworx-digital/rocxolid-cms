<?php

namespace Softworx\RocXolid\CMS\Repositories;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// filters
use Softworx\RocXolid\Repositories\Filters\Type\Text as TextFilter,
    Softworx\RocXolid\Repositories\Filters\Type\Select as SelectFilter,
    Softworx\RocXolid\Repositories\Filters\Type\ModelRelation as ModelRelationFilter;
// models
use Softworx\RocXolid\Common\Models\Web;
/**
 *
 */
class AbstractRepository extends AbstractCrudRepository
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