<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// contracts
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
// traits
use Softworx\RocXolid\Models\Traits\CanClone;
// cms contracts
use Softworx\RocXolid\CMS\Models\Contracts\PageElement;
use Softworx\RocXolid\CMS\Models\Contracts\PageProxyElement;
use Softworx\RocXolid\CMS\Models\Contracts\PageProxyElementable;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\PreviewController;
//
use Softworx\RocXolid\CMS\Models\PageTemplate;
// page elements
use Softworx\RocXolid\CMS\Models\Text;
use Softworx\RocXolid\CMS\Models\Link;
use Softworx\RocXolid\CMS\Models\Gallery;
use Softworx\RocXolid\CMS\Models\IframeVideo;
    // panels
use Softworx\RocXolid\CMS\Models\CookieConsent;
use Softworx\RocXolid\CMS\Models\FooterNavigation;
use Softworx\RocXolid\CMS\Models\FooterNote;
use Softworx\RocXolid\CMS\Models\StatsPanel;
use Softworx\RocXolid\CMS\Models\TopPanel;
    // specials - forms
use Softworx\RocXolid\CMS\Models\Newsletter;
use Softworx\RocXolid\CMS\Models\Contact;
use Softworx\RocXolid\CMS\Models\SearchEngine;
use Softworx\RocXolid\CMS\Models\LoginRegistration;
use Softworx\RocXolid\CMS\Models\ForgotPassword;
use Softworx\RocXolid\CMS\Models\ShoppingCart;
use Softworx\RocXolid\CMS\Models\ShoppingCheckout;
use Softworx\RocXolid\CMS\Models\ShoppingAfter;
use Softworx\RocXolid\CMS\Models\UserProfile;
    // containers
use Softworx\RocXolid\CMS\Models\HtmlWrapper;
use Softworx\RocXolid\CMS\Models\MainNavigation;
use Softworx\RocXolid\CMS\Models\RowNavigation;
use Softworx\RocXolid\CMS\Models\MainSlider;
    //  lists
use Softworx\RocXolid\CMS\Models\ProductList;
use Softworx\RocXolid\CMS\Models\ArticleList;
    // proxies
use Softworx\RocXolid\CMS\Models\ProxyProduct;
use Softworx\RocXolid\CMS\Models\ProxyArticle;
// @todo - na zaklade tohoto potom spravit vseobecnu relationship - cize nebude treba definovat vsetky vazby (https://laravel.io/forum/02-11-2015-eloquent-polymorphic-many-to-many-morphto)
// @todo - hodt do page, page template,... contract s tymto traitom
// alebo skor spravit abstract triedu <<< a static access k $page_elements_relationships
/**
 *
 */
trait HasPageElements
{
    use CanClone;

    private $_page_elements = null;

    private $_visible_page_elements = null;

    // @todo: quite ugly, consider some nicer solution
    protected $default_page_elements_relationships = [
        // general page elements - (usually) clone from template
        'texts',
        //'links',
        'galleries',
        'iframeVideos',
        // panels
        'cookieConsents',
        'footerNavigations',
        //'footerNotes',
        //'statsPanels',
        //'topPanels',
        // containers
        //'htmlWrappers',
        'mainNavigations',
        'rowNavigations',
        'mainSliders',
        // specials
        //'newsletters',
        //'searchEngines',
        //'loginRegistrations',
        //'forgotPasswords',
        //'shoppingCarts',
        //'shoppingCheckouts',
        //'shoppingAfters',
        //'userProfiles',
        //'contacts',
        // lists
        //'deliveryLists',
        //'productLists',
        // proxies
        //'proxyProducts',
        'articleLists',
        'proxyArticles',
    ];

    public static function bootHasPageElements()
    {
        static::deleting(function ($model)
        {
            $model->detachAll();
        });
    }

    public function pageElements()
    {
        if (is_null($this->_page_elements))
        {
            $this->_page_elements = new Collection();

            $this->getPivotElements()->each(function ($pivot_data, $key)
            {
                $page_element = $pivot_data->page_element_type::find($pivot_data->page_element_id);

                if (is_null($page_element))
                {
                    // self cleaning beacause foreign keys use is not available
                    DB::table($this->getPageElementsPivotTable())->where([
                        $this->getPageElementsPivotTableKey() => $this->id,
                        'page_element_id' => $pivot_data->page_element_id,
                        'page_element_type' => $pivot_data->page_element_type,
                    ])->delete();
                }
                else
                {
                    $page_element
                        ->setParentPageElementable($this)
                        ->setPivotData($pivot_data);

                    $this->_page_elements->push($page_element);
                }
            });
        }

        return $this->_page_elements;
    }

    public function visiblePageElements($except = null, $only = null)
    {
        if (is_null($this->_visible_page_elements))
        {
            $this->_visible_page_elements = new Collection();

            $this->getVisiblePivotElements()->each(function ($pivot_data, $key)
            {
                $page_element = $pivot_data->page_element_type::find($pivot_data->page_element_id);

                if (!is_null($page_element))
                {
                    $page_element
                        ->setParentPageElementable($this)
                        ->setPivotData($pivot_data);

                    $this->_visible_page_elements->push($page_element);
                }
            });
        }

        $filtered = $this->_visible_page_elements;

        if (!is_null($except))
        {
            $filtered = $filtered->filter(function ($element, $key) use ($except)
            {
                return !in_array(get_class($element), $except);
            });
        }

        if (!is_null($only))
        {
            $filtered = $filtered->filter(function ($element, $key) use ($only)
            {
                return in_array(get_class($element), $only);
            });
        }

        return $filtered;
    }

    public function setVisiblePageElements(Collection $visible_page_elements)
    {
        $this->_visible_page_elements = $visible_page_elements;

        return $this;
    }

    public function hasPageElement(PageElement $page_element)
    {
        return DB::table($this->getPageElementsPivotTable())
            ->where($this->getPageElementablePivotCondition($page_element))
            ->count() > 0;
    }

    public function addPageElement(PageElement $page_element)
    {
        $position = (int)DB::table($this->getPageElementsPivotTable())
            ->where($this->getPageElementsPivotTableKey(), $this->id)
            ->count();

        $pivot_data = [
            'position' => $position,
        ];

        if (isset($page_element->default_template))
        {
            $pivot_data += [
                'template' => $page_element->default_template,
            ];
        }

        DB::table($this->getPageElementsPivotTable())->insert($this->getPageElementablePivotCondition($page_element) + $pivot_data);

        return $this;
    }

    public function updatePivotData($request, $page_element_type, $page_element_id)
    {
        if (($input = $request->input('_data', false)) && is_array($input))
        {
            $page_element = $page_element_type::findOrFail($page_element_id);

            DB::table($this->getPageElementsPivotTable())
                ->where($this->getPageElementablePivotCondition($page_element))
                ->update($input);
        }

        return $this;
    }

    public function updatePageElementsOrder($request)
    {
        if (($input = $request->input('_data', false)) && is_array($input))
        {
            $page_elements = $this->pageElements();
            $page_elements_attached = new Collection();

            foreach ($input as $order_data)
            {
                foreach ($order_data as $position => $page_element_data)
                {
                    $page_element = $page_element_data['pageElementType']::findOrFail($page_element_data['pageElementId']);

                    if (!$this->hasPageElement($page_element))
                    {
                        $this->addPageElement($page_element);
                    }

                    $page_elements_attached->push($page_element);

                    DB::table($this->getPageElementsPivotTable())
                        ->where($this->getPageElementablePivotCondition($page_element))
                        ->update([
                            'position' => $position,
                        ]);

                    if ($page_element instanceof Container)
                    {
                        $page_element->detachContainee($this->getCCRelationParam());

                        if (isset($page_element_data['children']))
                        {
                            foreach ($page_element_data['children'] as $position => $children_order_data)
                            {
                                $page_element->reorderContainees($this->getCCRelationParam(), $children_order_data);
                            }
                        }
                    }
                }
            }

            $page_elements->diff($page_elements_attached)->each(function ($page_element_to_detach, $key)
            {
                $this->detachPageElement($page_element_to_detach);
            });
        }

        return $this;
    }

    public function detachPageElement(PageElement $page_element)
    {
        DB::table($this->getPageElementsPivotTable())->where($this->getPageElementablePivotCondition($page_element))->delete();

        return $this;
    }

    protected function detachAll()
    {
        DB::table($this->getPageElementsPivotTable())->where($this->getPageElementablePivotCondition())->delete();

        return $this;
    }

    public function getPageElementModels($categorize = false)
    {
        $models = [
            'panels' => new Collection(),
            'containers' => new Collection(),
            'proxy' => new Collection(),
        ];

        foreach ($this->getPageElementsRelationships() as $method)
        {
            $related = $this->$method()->getRelated();

            if ($related instanceof PageElement)
            {
                if ($related instanceof Container)
                {
                    $models['containers']->put(Str::kebab((new \ReflectionClass($related))->getShortName()), $related);
                }
                elseif ($related instanceof PageProxyElement)
                {
                    if (($this instanceof PageProxyElementable) && ($this->model_type == $related::$model_type))
                    {
                        $models['proxy']->put(Str::kebab((new \ReflectionClass($related))->getShortName()), $related);
                    }
                }
                else
                {
                    $models['panels']->put(Str::kebab((new \ReflectionClass($related))->getShortName()), $related);
                }
            }
        }

        if (!($this instanceof PageProxyElementable))
        {
            unset($models['proxy']);
        }

        if ($categorize)
        {
            return $models;
        }
        else
        {
            $all = new Collection();

            foreach ($models as $collection)
            {
                $all = $all->merge($collection);
            }

            return $all;
        }

        return ($categorize) ? $models : $models;
    }

    // special use for cloning
    public function getAllPageElementModels()
    {
        $models = new Collection();

        foreach ($this->getPageElementsRelationships() as $method)
        {
            $related = $this->$method()->getRelated();

            if ($related instanceof PageElement)
            {
                $models->put(Str::kebab((new \ReflectionClass($related))->getShortName()), $related);
            }
        }

        return $models;
    }

    public function getPreviewRoute()
    {
        $action = action(sprintf('\%s@%s', PreviewController::class, Str::camel((new \ReflectionClass($this))->getShortName())), $this);
        $parsed = parse_url($action);

        return sprintf('%s://%s/%s', $parsed['scheme'], $this->web->domain, $parsed['path']);
    }

    public function getPageElementIframeRoute()
    {
        return '';
    }

    public function getCCRelationParam()
    {
        return sprintf('page-element-[%s:%s]-items', Str::kebab((new \ReflectionClass($this))->getShortName()), $this->id);
    }

    public function getPageElementsPivotTable()
    {
        return sprintf('cms_%s_has_page_elements', Str::snake((new \ReflectionClass($this))->getShortName()));
    }

    public function getPageElementsPivotTableKey()
    {
        return sprintf('%s_id', Str::snake((new \ReflectionClass($this))->getShortName()));
    }

    public function getRequestFieldParam()
    {
        return sprintf('_%s', $this->getPageElementsPivotTableKey());
    }

    public function getRequestFieldName()
    {
        return sprintf('_data[%s]', $this->getRequestFieldParam());
    }

    protected function getPivotElements($order_by = 'position', $order_by_direction = 'asc')
    {
        return DB::table($this->getPageElementsPivotTable())
            ->where($this->getPageElementsPivotTableKey(), $this->id)
            ->orderBy($order_by, $order_by_direction)
            ->get();
    }

    protected function getVisiblePivotElements($except = null, $only = null, $order_by = 'position', $order_by_direction = 'asc')
    {
        if ($this instanceof PageTemplate)
        {
            $q = DB::table($this->getPageElementsPivotTable())
                ->where($this->getPageElementsPivotTableKey(), $this->id);

            if (!is_null($except))
            {
                $q->whereNotIn('page_element_type', $except);
            }

            if (!is_null($only))
            {
                $q->whereIn('page_element_type', $only);
            }

            return $q
                ->orderBy($order_by, $order_by_direction)
                ->get();
        }
        else
        {
            $q = DB::table($this->getPageElementsPivotTable())
                ->where($this->getPageElementsPivotTableKey(), $this->id)
                ->where('is_visible', 1);

            if (!is_null($except))
            {
                $q->whereNotIn('page_element_type', $except);
            }

            if (!is_null($only))
            {
                $q->whereIn('page_element_type', $only);
            }

            return $q
                ->orderBy($order_by, $order_by_direction)
                ->get();
        }
    }

    protected function getPageElementablePivotCondition(PageElement $page_element = null): array
    {
        $condition = [
            $this->getPageElementsPivotTableKey() => $this->id,
        ];

        if (!is_null($page_element))
        {
            $condition += [
                'page_element_id' => $page_element->id,
                'page_element_type' => (new \ReflectionClass($page_element))->getName(),
            ];
        }

        return $condition;
    }

    public function getPivotExtra()
    {
        return $this->pivot_extra;
    }

    protected function buildRelationsAfter(Collection $clone_log)
    {
        $class = (new \ReflectionClass($this))->getName();

        if ($original_id = array_search($this->id, $clone_log->get($class, [])))
        {
            static::findOrFail($original_id)->pageElements()->each(function($original_page_element, $key) use ($clone_log)
            {
                $class = (new \ReflectionClass($original_page_element))->getName();

                if ($clone_log->has($class) && array_key_exists($original_page_element->id, $clone_log->get($class)))
                {
                    $clone = $original_page_element::findOrFail($clone_log->get($class)[$original_page_element->id]);

                    $this->addPageElement($clone);
                }
            });
        }

        return $this;
    }

    // page elements relations
    public function getPageElementsRelationships()
    {
        if (property_exists($this, 'page_elements_relationships'))
        {
            $page_elements_relationships = $this->page_elements_relationships;
        }
        elseif (property_exists($this, 'default_page_elements_relationships'))
        {
            $page_elements_relationships = $this->default_page_elements_relationships;
        }
        else
        {
            throw new \InvalidArgumentException(sprintf('Model [%s] has no page elements relationships definition', (new \ReflectionClass($this))->getName()));
        }

        return $page_elements_relationships;
    }

    public function isPageElementTemplateChoiceEnabled()
    {
        if (property_exists($this, 'is_page_element_template_choice_enabled'))
        {
            return $this->is_page_element_template_choice_enabled;
        }

        return true;
    }

    public function texts()
    {
        return $this->morphedByMany(Text::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function links()
    {
        return $this->morphedByMany(Link::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function galleries()
    {
        return $this->morphedByMany(Gallery::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function iframeVideos()
    {
        return $this->morphedByMany(IframeVideo::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function htmlWrappers()
    {
        return $this->morphedByMany(HtmlWrapper::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function cookieConsents()
    {
        return $this->morphedByMany(CookieConsent::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function topPanels()
    {
        return $this->morphedByMany(TopPanel::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function mainNavigations()
    {
        return $this->morphedByMany(MainNavigation::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function rowNavigations()
    {
        return $this->morphedByMany(RowNavigation::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function mainSliders()
    {
        return $this->morphedByMany(MainSlider::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function socialFooters()
    {
        return $this->morphedByMany(SocialFooter::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function footerNavigations()
    {
        return $this->morphedByMany(FooterNavigation::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function footerNotes()
    {
        return $this->morphedByMany(FooterNote::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function statsPanels()
    {
        return $this->morphedByMany(StatsPanel::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    // specials

    public function newsletters()
    {
        return $this->morphedByMany(Newsletter::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function searchEngines()
    {
        return $this->morphedByMany(SearchEngine::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function loginRegistrations()
    {
        return $this->morphedByMany(LoginRegistration::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function forgotPasswords()
    {
        return $this->morphedByMany(ForgotPassword::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function shoppingCarts()
    {
        return $this->morphedByMany(ShoppingCart::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function shoppingCheckouts()
    {
        return $this->morphedByMany(ShoppingCheckout::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function shoppingAfters()
    {
        return $this->morphedByMany(ShoppingAfter::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function userProfiles()
    {
        return $this->morphedByMany(UserProfile::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function contacts()
    {
        return $this->morphedByMany(Contact::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    // lists

    public function deliveryLists()
    {
        return $this->morphedByMany(DeliveryList::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function productLists()
    {
        return $this->morphedByMany(ProductList::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function articleLists()
    {
        return $this->morphedByMany(ArticleList::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    // proxies

    public function proxyProducts()
    {
        return $this->morphedByMany(ProxyProduct::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function proxyArticles()
    {
        return $this->morphedByMany(ProxyArticle::class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }
}