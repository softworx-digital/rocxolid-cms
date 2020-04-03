<?php

namespace Softworx\RocXolid\CMS\Models\Tables\Columns\Type;

use Softworx\RocXolid\Tables\Columns\Type\Text;

class Link extends Text
{
    protected $default_options = [
        'type-template' => 'cms.link',
    ];

    private $_attribute_param;

    public function setAttributeParam($attribute_param)
    {
        //$this->_attribute_param = $attribute_param;
        return $this->setComponentOptions('attribute_param', $attribute_param);
    }

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
        return $this->_attribute_param ? sprintf('%s_url', $this->_attribute_param) : 'url';
    }

    protected function getPageAttribute()
    {
        return $this->_attribute_param ? sprintf('%s_page_id', $this->_attribute_param) : 'page_id';
    }

    protected function getPageProxyAttribute()
    {
        return $this->_attribute_param ? sprintf('%s_page_proxy_id', $this->_attribute_param) : 'page_proxy_id';
    }
}
