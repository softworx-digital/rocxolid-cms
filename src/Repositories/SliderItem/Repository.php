<?php

namespace Softworx\RocXolid\CMS\Repositories\SliderItem;

// columns
use Softworx\RocXolid\Repositories\Columns\Type\Text,
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
    protected static $translation_param = 'cms-slider-item';

    protected $columns = [];
}