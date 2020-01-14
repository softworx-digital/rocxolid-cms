<?php

namespace Softworx\RocXolid\CMS\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
// common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;

/**
 *
 */
trait DetectsPage
{
    private $_page = null;

    public function detectPage(Web $web = null, Localization $localization = null, $slug = null)
    {
        if (is_null($this->_page)) {
            if (is_null($web)) {
                throw new \InvalidArgumentException('Web is required for first-time page detection');
            }

            if (is_null($localization)) {
                throw new \InvalidArgumentException('Localization is required for first-time page detection');
            }

            if (is_null($slug)) {
                throw new \InvalidArgumentException('Slug is required for first-time page detection');
            }

            try {
                $this->_page = Page::where('web_id', $web->id)->where('localization_id', $localization->id)->where('seo_url_slug', $slug)->first();

                if (is_null($this->_page)) { // trying proxy page
                    $model = null;
                    $found_page_proxy = null;
                    $page_proxies = PageProxy::where('web_id', $web->id)->where('localization_id', $localization->id)->get(); // ProxyPage::where('is_enabled', 1)

                    $path = explode('/', $slug);

                    while (!empty($path)) {
                        $prefix = array_shift($path);

                        if (!empty($path)) {
                            $rest = implode('/', $path);
                        } else {
                            $rest = $prefix;
                            $prefix = '';
                        }

                        $page_proxies->each(function ($page_proxy) use ($prefix, $rest, &$model, &$found_page_proxy, $web) {
                            if (is_null($model) && $page_proxy->seo_url_slug == $prefix) {
                                $class = $page_proxy->model_type;

                                if (method_exists($class, 'web')) {
                                    if ($model = $class::where('seo_url_slug', $rest)->where('web_id', $web->id)->first()) {
                                        $found_page_proxy = $page_proxy;

                                        return false;
                                    }
                                } else {
                                    if ($model = $class::where('seo_url_slug', $rest)->first()) {
                                        $found_page_proxy = $page_proxy;

                                        return false;
                                    }
                                }
                            }
                        });
                    }

                    if (is_null($found_page_proxy)) {
                        throw (new ModelNotFoundException())->setModel(Page::make());
                    } else {
                        $this->_page = $found_page_proxy->setModel($model)->castToPage();
                    }
                }
            } catch (ModelNotFoundException $e) {
                //dd(sprintf('--page pre web [%s] a slug [%s] nie je definovany--> 404', $web->id, $slug));
                return false;
            }
        }

        return $this->_page;
    }
}
