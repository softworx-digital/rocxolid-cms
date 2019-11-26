<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// base contracts
use Softworx\RocXolid\Contracts\Modellable;
use Softworx\RocXolid\Models\Contracts\Cloneable;
// base traits
use Softworx\RocXolid\Traits\Modellable as ModellableTrait;
// base models
use Softworx\RocXolid\Models\AbstractCrudModel;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\HasLocalization;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
// cms contracts
use Softworx\RocXolid\CMS\Models\Contracts\PageProxyElementable;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasPageElements;
// cms models
use Softworx\RocXolid\CMS\Models\PageTemplate;
use Softworx\RocXolid\CMS\Models\Article;

/**
 *
 */
class PageProxy extends AbstractCrudModel implements PageProxyElementable, Modellable, Cloneable
{
    use SoftDeletes;
    use HasWeb;
    use HasLocalization;
    use HasPageElements;
    use ModellableTrait;
    use UserGroupAssociatedWeb;

    protected $table = 'cms_page_proxy';

    protected $page_proxyable = [
        //Product::class,
        Article::class,
    ];

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'web_id',
        'localization_id',
        'page_template_id',
        'model_type',
        'name',
        //'css_class',
        'seo_url_slug',
        //'is_enabled',
        'description'
    ];

    protected $relationships = [
        'web',
        'localization',
        'pageTemplate',
    ];

    protected $pivot_extra = [
        'position',
        'is_visible',
    ];

    public function pageTemplate()
    {
        return $this->belongsTo(PageTemplate::class);
    }

    public function getModelType()
    {
        if (($class = $this->model_type) && class_exists($class))
        {
            return $class::make()->getModelViewerComponent()->translate('model.title.singular');
        }

        return null;
    }

    public function makeModel($model_id)
    {
        $class = $this->model_type;

        return $class::find($model_id);
    }

    public function getFrontpageUrl($model_id, $params = [])
    {
        $model = $this->makeModel($model_id);

        if (is_null($model))
        {
            return '#404';
        }

        $pattern = empty($this->seo_url_slug) ? '//%s%s/%s/%s' : '//%s/%s/%s/%s';

        return sprintf('//%s/%s/%s/%s', $this->web->domain, $this->localization->seo_url_slug, $this->seo_url_slug, $model->seo_url_slug);
    }

    public function getPageProxyableModels()
    {
        $models = new Collection();

        foreach ($this->page_proxyable as $class)
        {
            // $models->put(Str::kebab((new \ReflectionClass($class))->getShortName()), $class);
            // $short_name = (new \ReflectionClass($class))->getShortName();
            $models->put($class, $class::make()->getModelViewerComponent()->translate('model.title.singular'));
        }

        return $models;
    }

    public function castToPage()
    {
        $modellable_elements = 0;
        $page = Page::make();
        $page->proxy = $this;
        $page->web = $this->web;
        $page->localization = $this->localization;
        $page->setVisiblePageElements($this->visiblePageElements());

        $this->getModel()->setPageAttributes($page, $this);

        foreach ($page->visiblePageElements() as $element)
        {
            if ($element instanceof Modellable)
            {
                $element->setModel($this->getModel());
                $modellable_elements++;
            }
        }

        if (!$modellable_elements)
        {
            throw new \RuntimeException(sprintf('No modellable elements for proxy page "%s" [%s]', $this->getTitle(), $this->id));
        }

        return $page;
    }

    public function beforeSave($data, $action = null)
    {
        if ($this->seo_url_slug !== '/') // homepage
        {
            $this->seo_url_slug = collect(array_filter(explode('/', $this->seo_url_slug)))->map(function ($slug)
            {
                return Str::slug($slug);
            })->implode('/');
        }

        return $this;
    }

    public function afterSave($data, $action = null)
    {
        if ($action == 'create')
        {
            $this->assignTemplatePageElements();
        }

        return $this;
    }

    protected function assignTemplatePageElements()
    {
        $clone_log = new Collection();

        if ($this->pageTemplate()->exists())
        {
            foreach ($this->pageTemplate->pageElements() as $page_element)
            {
                if ($page_element->getPivotData()->get('is_clone_page_element_instance'))
                {
                    $clone = $page_element->clone($clone_log);

                    $this->addPageElement($clone);
                }
                else
                {
                    $this->addPageElement($page_element);
                }
            }
        }

        return $this;
    }
}