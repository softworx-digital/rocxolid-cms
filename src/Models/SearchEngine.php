<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
// common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Image;
use Softworx\RocXolid\Commerce\Models\Product;
use Softworx\RocXolid\CMS\Models\Advice;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
/**
 *
 */
class SearchEngine extends AbstractPageElement
{
    protected $table = 'cms_page_element_search_engine';

    protected $fillable = [
        'web_id',
        'name',
        'title',
        'subtitle',
        'form_field_phrase',
        'form_field_button',
        'results',
        'results_button',
        'results_empty',
    ];

    protected $relationships = [
        'web',
    ];

    protected $results = null;

    public function handleFrontpageRequest($request, Web $web)
    {
        if ($request->isMethod('post'))
        {
            foreach ($request->get('search-type', []) as $type)
            {
                $method = sprintf('search%s', studly_case($type));

                if (method_exists($this, $method))
                {
                    $this->$method($web, $request->get('q'));
                }
            }
        }

        return $this;
    }

    public function getResults()
    {
        if (is_null($this->results))
        {
            $this->results = new Collection();
        }

        return $this->results;
    }

    protected function searchProduct($web, $query)
    {
        $page_proxy = PageProxy::where('model_type', Product::class)->where('web_id', $web->id)->first();

        Product::where(function($q) use ($query)
        {
            $q->orWhere('title', 'like', sprintf('%%%s%%', $query));
            $q->orWhere('short_description', 'like', sprintf('%%%s%%', $query));
            $q->orWhere('description', 'like', sprintf('%%%s%%', $query));
        })
        ->where('web_id', $web->id)
        ->where('is_visible', 1)
        ->each(function ($item) use ($page_proxy)
        {
            $this->getResults()->push([
                'template' => 'product',
                'item' => $item,
                'page_proxy' => $page_proxy,
            ]);
        });

        return $this;
    }

    protected function searchAdvice($web, $query)
    {
        $page_proxy = PageProxy::where('model_type', Advice::class)->where('web_id', $web->id)->first();

        Advice::where(function($q) use ($query)
        {
            $q->orWhere('name', 'like', sprintf('%%%s%%', $query));
            $q->orWhere('perex', 'like', sprintf('%%%s%%', $query));
            $q->orWhere('content', 'like', sprintf('%%%s%%', $query));
        })
        ->where('web_id', $web->id)
        ->each(function ($item) use ($page_proxy)
        {
            $this->getResults()->push([
                'template' => 'advice',
                'item' => $item,
                'page_proxy' => $page_proxy,
            ]);
        });

        return $this;
    }
}