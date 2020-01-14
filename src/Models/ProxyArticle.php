<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractProxyPageElement;
use Softworx\RocXolid\CMS\Models\Article;
use Softworx\RocXolid\CMS\Models\Page;

/**
 *
 */
class ProxyArticle extends AbstractProxyPageElement
{
    protected $table = 'cms_page_element_proxy_article';

    public static $model_type = Article::class;

    protected $fillable = [
        'web_id',
        'name',
        'back_button',
        'back_page_id',
    ];

    protected $relationships = [
        'web',
        'backPage',
    ];

    public function backPage()
    {
        return $this->belongsTo(Page::class);
    }
}
