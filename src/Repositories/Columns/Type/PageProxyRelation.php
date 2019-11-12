<?php

namespace Softworx\RocXolid\CMS\Repositories\Columns\Type;

use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;

class PageProxyRelation extends ModelRelation
{
    protected $default_options = [
        'type-template' => 'cms.page-proxy',
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