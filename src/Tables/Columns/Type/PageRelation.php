<?php

namespace Softworx\RocXolid\CMS\Tables\Columns\Type;

use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;

class PageRelation extends ModelRelation
{
    protected $default_options = [
        'type-template' => 'cms.page',
    ];

    public function hasModelUrl($model)
    {
        return !empty($model->{$this->getUrlAttribute()});
    }

    public function getModelUrl($model)
    {
        return $model->{$this->getUrlAttribute()};
    }

    protected function getUrlAttribute()
    {
        return sprintf('%s_url', $this->getName());
    }

    protected function getPageAttribute()
    {
        return sprintf('%s_id', $this->getName());
    }
}
