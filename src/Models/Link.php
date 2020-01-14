<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasProxyPageLink;

/**
 *
 */
class Link extends AbstractPageElement
{
    use HasProxyPageLink;

    protected $table = 'cms_page_element_link';

    protected $fillable = [
        'web_id',
        'name',
        'url',
        'page_id',
        'page_proxy_id',
        'page_proxy_model_id',
    ];

    protected $relationships = [
        'web',
        'page',
        'pageProxy',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
