<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// contracts
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
// traits
use Softworx\RocXolid\Models\Traits\Cloneable;
// cms contracts
use Softworx\RocXolid\CMS\Models\Contracts\PageElement;
use Softworx\RocXolid\CMS\Models\Contracts\PageProxyElement;
use Softworx\RocXolid\CMS\Models\Contracts\ProxyElementable;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\PreviewController;
//
use Softworx\RocXolid\CMS\Models\PageTemplate;

/**
 *
 */
trait _obsolete_HasPageElements
{
    use Cloneable;

    private $_page_elements = null;

    private $_visible_page_elements = null;

    public static function bootHasPageElements()
    {
        static::deleting(function ($model) {
            $model->detachAll();
        });
    }

    public function pageElements()
    {
        if (is_null($this->_page_elements)) {
            $this->_page_elements = collect();

            $this->getPivotElements()->each(function ($pivot_data, $key) {
                $page_element = $pivot_data->page_element_type::find($pivot_data->page_element_id);

                if (is_null($page_element)) {
                    // self cleaning beacause foreign keys use is not available
                    DB::table($this->getPageElementsPivotTable())->where([
                        $this->getPageElementsPivotTableKey() => $this->getKey(),
                        'page_element_id' => $pivot_data->page_element_id,
                        'page_element_type' => $pivot_data->page_element_type,
                    ])->delete();
                } else {
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
        if (is_null($this->_visible_page_elements)) {
            $this->_visible_page_elements = collect();

            $this->getVisiblePivotElements()->each(function ($pivot_data, $key) {
                $page_element = $pivot_data->page_element_type::find($pivot_data->page_element_id);

                if (!is_null($page_element)) {
                    $page_element
                        ->setParentPageElementable($this)
                        ->setPivotData($pivot_data);

                    $this->_visible_page_elements->push($page_element);
                }
            });
        }

        $filtered = $this->_visible_page_elements;

        if (!is_null($except)) {
            $filtered = $filtered->filter(function ($element, $key) use ($except) {
                return !in_array(get_class($element), $except);
            });
        }

        if (!is_null($only)) {
            $filtered = $filtered->filter(function ($element, $key) use ($only) {
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
            ->where($this->getPageElementsPivotTableKey(), $this->getKey())
            ->count();

        $pivot_data = [
            'position' => $position,
        ];

        if (isset($page_element->default_template)) {
            $pivot_data += [
                'template' => $page_element->default_template,
            ];
        }

        DB::table($this->getPageElementsPivotTable())->insert($this->getPageElementablePivotCondition($page_element) + $pivot_data);

        return $this;
    }

    public function updatePivotData($request, $page_element_type, $page_element_id)
    {
        if (($input = $request->input('_data', false)) && is_array($input)) {
            $page_element = $page_element_type::findOrFail($page_element_id);

            DB::table($this->getPageElementsPivotTable())
                ->where($this->getPageElementablePivotCondition($page_element))
                ->update($input);
        }

        return $this;
    }

    public function updatePageElementsOrder($request)
    {
        if (($input = $request->input('_data', false)) && is_array($input)) {
            $page_elements = $this->pageElements();
            $page_elements_attached = collect();

            foreach ($input as $order_data) {
                foreach ($order_data as $position => $page_element_data) {
                    $page_element = $page_element_data['pageElementType']::findOrFail($page_element_data['pageElementId']);

                    if (!$this->hasPageElement($page_element)) {
                        $this->addPageElement($page_element);
                    }

                    $page_elements_attached->push($page_element);

                    DB::table($this->getPageElementsPivotTable())
                        ->where($this->getPageElementablePivotCondition($page_element))
                        ->update([
                            'position' => $position,
                        ]);

                    if ($page_element instanceof Container) {
                        $page_element->detachContainee($this->getCCRelationParam());

                        if (isset($page_element_data['children'])) {
                            foreach ($page_element_data['children'] as $position => $children_order_data) {
                                $page_element->reorderContainees($this->getCCRelationParam(), $children_order_data);
                            }
                        }
                    }
                }
            }

            $page_elements->diff($page_elements_attached)->each(function ($page_element_to_detach, $key) {
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
            'panels' => collect(),
            'containers' => collect(),
            'proxy' => collect(),
        ];

        foreach ($this->getAvailablePageElements() as $page_element_class) {
            $related = $this->getPageElementsRelationship($page_element_class)->getRelated();

            if ($related instanceof PageElement) {
                if ($related instanceof Container) {
                    $models['containers']->put(Str::kebab((new \ReflectionClass($related))->getShortName()), $related);
                } elseif ($related instanceof PageProxyElement) {
                    if (($this instanceof ProxyElementable) && ($this->model_type == $related::$model_type)) {
                        $models['proxy']->put(Str::kebab((new \ReflectionClass($related))->getShortName()), $related);
                    }
                } else {
                    $models['panels']->put(Str::kebab((new \ReflectionClass($related))->getShortName()), $related);
                }
            }
        }

        if (!($this instanceof ProxyElementable)) {
            unset($models['proxy']);
        }

        if ($categorize) {
            return $models;
        } else {
            $all = collect();

            foreach ($models as $collection) {
                $all = $all->merge($collection);
            }

            return $all;
        }

        return ($categorize) ? $models : $models;
    }

    // special use for cloning
    public function getAllPageElementModels()
    {
        $models = collect();

        foreach ($this->getAvailablePageElements() as $page_element_class) {
            $related = $this->getPageElementsRelationship($page_element_class)->getRelated();

            if ($related instanceof PageElement) {
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

    // @todo: reason for this?
    public function getPageElementIframeRoute()
    {
        return '';
    }

    public function getCCRelationParam()
    {
        return sprintf('page-element-[%s:%s]-items', Str::kebab((new \ReflectionClass($this))->getShortName()), $this->getKey());
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
            ->where($this->getPageElementsPivotTableKey(), $this->getKey())
            ->orderBy($order_by, $order_by_direction)
            ->get();
    }

    protected function getVisiblePivotElements($except = null, $only = null, $order_by = 'position', $order_by_direction = 'asc')
    {
        if ($this instanceof PageTemplate) {
            $q = DB::table($this->getPageElementsPivotTable())
                ->where($this->getPageElementsPivotTableKey(), $this->getKey());

            if (!is_null($except)) {
                $q->whereNotIn('page_element_type', $except);
            }

            if (!is_null($only)) {
                $q->whereIn('page_element_type', $only);
            }

            return $q
                ->orderBy($order_by, $order_by_direction)
                ->get();
        } else {
            $q = DB::table($this->getPageElementsPivotTable())
                ->where($this->getPageElementsPivotTableKey(), $this->getKey())
                ->where('is_visible', 1);

            if (!is_null($except)) {
                $q->whereNotIn('page_element_type', $except);
            }

            if (!is_null($only)) {
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
            $this->getPageElementsPivotTableKey() => $this->getKey(),
        ];

        if (!is_null($page_element)) {
            $condition += [
                'page_element_id' => $page_element->getKey(),
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

        if ($original_id = array_search($this->getKey(), $clone_log->get($class, []))) {
            static::findOrFail($original_id)->pageElements()->each(function ($original_page_element, $key) use ($clone_log) {
                $class = (new \ReflectionClass($original_page_element))->getName();

                if ($clone_log->has($class) && array_key_exists($original_page_element->getKey(), $clone_log->get($class))) {
                    $clone = $original_page_element::findOrFail($clone_log->get($class)[$original_page_element->getKey()]);

                    $this->addPageElement($clone);
                }
            });
        }

        return $this;
    }

    public function getAvailablePageElements()
    {
        return collect(config(sprintf('rocXolid.cms.elementable.%s', static::class), config('rocXolid.cms.elementable.default')));
    }

    public function getPageElementsRelationship($class)
    {
        if (!(new \ReflectionClass($class))->implementsInterface(PageElement::class)) {
            throw new \InvalidArgumentException(sprintf('Class [%s] has to implement [%s] interface to be used', $class, PageElement::class));
        }

        return $this->morphedByMany($class, 'page_element', $this->getPageElementsPivotTable())->withPivot($this->getPivotExtra());
    }

    public function isPageElementTemplateChoiceEnabled()
    {
        if (property_exists($this, 'is_page_element_template_choice_enabled')) {
            return $this->is_page_element_template_choice_enabled;
        }

        return true;
    }
}
