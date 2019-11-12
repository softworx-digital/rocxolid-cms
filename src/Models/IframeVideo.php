<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;

class IframeVideo extends AbstractPageElement
{
    protected $table = 'cms_page_element_iframe_video';

    protected $fillable = [
        'web_id',
        'name',
        'iframe',
    ];
}