<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;

/**
 * The trait is used in models to access their (proxy page) frontpage URL and to generate appropriate final page.
 */
trait IsProxyPaged
{
    public function getFrontpageUrl(array $params = [])
    {
        return PageProxy::where('model_type', static::class)->first()->getFrontpageUrl($this->getKey(), $params);
    }

    public function setPageAttributes(Page $page, PageProxy $page_proxy)
    {
        $page->meta_title = $this->meta_title ?: $this->name;
        $page->meta_keywords = $this->meta_keywords;
        $page->meta_description = $this->meta_description;

        $page->open_graph_title = $this->getTitle();
        $page->open_graph_description = $this->meta_description;
        $page->open_graph_type = 'article';
        $page->open_graph_site_name = $this->meta_title ?: $this->name;

        if (isset($this->openGraphImage)) {
            $page->openGraphImage = $this->openGraphImage;
        }

        /*
        meta_title
        meta_description
        meta_keywords
        open_graph_title
        open_graph_description
        open_graph_image
        open_graph_type
        open_graph_url
        open_graph_site_name
        */

        return $this;
    }
}
