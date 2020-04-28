<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\Cloneable;
// rocXolid traits
use Softworx\RocXolid\Traits\Modellable;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ProxyElementable;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractDocument;
use Softworx\RocXolid\CMS\Models\PageTemplate;

/**
 * Proxy page model.
 * Serves as a 'placeholder' for real page after setting the model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class PageProxy extends AbstractDocument implements ProxyElementable //, Cloneable
{
    use Modellable;

    protected $table = 'cms_page_proxies';

    protected $page_proxyable = [
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


    /*
    public function pageTemplate()
    {
        return $this->belongsTo(PageTemplate::class);
    }

    public function getModelType()
    {
        if (($class = $this->model_type) && class_exists($class)) {
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

        if (is_null($model)) {
            return '#404';
        }

        $pattern = empty($this->seo_url_slug) ? '//%s%s/%s/%s' : '//%s/%s/%s/%s';

        return sprintf('//%s/%s/%s/%s', $this->web->domain, $this->localization->seo_url_slug, $this->seo_url_slug, $model->seo_url_slug);
    }

    public function getPageProxyableModels(): Collection
    {
        $models = collect();

        $this->getPageProxyableModelClasses()->each(function ($class) use ($models) {
            $models->put($class, $class::make()->getModelViewerComponent()->translate('model.title.singular'));
        });

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

        foreach ($page->visiblePageElements() as $element) {
            if ($element instanceof Modellable) {
                $element->setModel($this->getModel());
                $modellable_elements++;
            }
        }

        if (!$modellable_elements) {
            throw new \RuntimeException(sprintf('No modellable elements for proxy page "%s" [%s]', $this->getTitle(), $this->getKey()));
        }

        return $page;
    }

    // @todo: revise, find nicer approach
    public function onBeforeSave(Collection $data): Crudable
    {
        // @todo: helper
        if ($this->seo_url_slug !== '/') { // homepage
            $this->seo_url_slug = collect(array_filter(explode('/', $this->seo_url_slug)))->map(function ($slug) {
                return Str::slug($slug);
            })->implode('/');
        }

        return parent::onBeforeSave($data);
    }

    public function onCreateAfterSave(Collection $data): Crudable
    {
        $this->assignTemplatePageElements();

        return parent::onCreateAfterSave($data);
    }

    protected function getPageProxyableModelClasses(): Collection
    {
        return collect(config('rocXolid.cms.general.page.proxyable', $this->page_proxyable));
    }

    protected function assignTemplatePageElements()
    {
        $clone_log = collect();

        if ($this->pageTemplate()->exists()) {
            foreach ($this->pageTemplate->pageElements() as $page_element) {
                if ($page_element->getPivotData()->get('is_clone_page_element_instance')) {
                    $clone = $page_element->clone($clone_log);

                    $this->addPageElement($clone);
                } else {
                    $this->addPageElement($page_element);
                }
            }
        }

        return $this;
    }
    */
}
