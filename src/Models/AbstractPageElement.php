<?php

namespace Softworx\RocXolid\CMS\Models;

use App;
use File;
use Config;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid fundamentals
use Softworx\RocXolid\Contracts\Translatable;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Models\Contracts\Cloneable;
use Softworx\RocXolid\Models\Traits\CanClone;
// common models
use Softworx\RocXolid\Common\Models\Web;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
// cms contracts
use Softworx\RocXolid\CMS\Models\Contracts\PageElement,
    Softworx\RocXolid\CMS\Models\Contracts\PageElementable;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\PageElementViewer;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasFrontpageUrlAttribute;
// cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;
use Softworx\RocXolid\CMS\Models\PageTemplate;
use Softworx\RocXolid\CMS\Models\Article;

/**
 *
 */
abstract class AbstractPageElement extends AbstractCrudModel implements PageElement, Cloneable
{
    use SoftDeletes;
    use HasWeb;
    use HasFrontpageUrlAttribute;
    use CanClone;
    //use UserGroupAssociatedWeb;

    protected static $template_dir = 'page-element';

    protected $guarded = [
        'id'
    ];

    protected $relationships = [
        'web',
    ];

    protected $pivot_data = null;

    protected $parent_page_elementable = null;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model)
        {
            $model->pages->each(function ($page_elementable) use ($model)
            {
                $page_elementable->detachPageElement($model);
            });

            $model->pageProxies->each(function ($page_elementable) use ($model)
            {
                $page_elementable->detachPageElement($model);
            });

            $model->pageTemplates->each(function ($page_elementable) use ($model)
            {
                $page_elementable->detachPageElement($model);
            });
        });
    }

    public function handleFrontpageRequest($request, Web $web)
    {
        return $this;
    }

    public function getTemplateName($subdirectory = null, $use_template = null, $default_template = 'default')
    {
        if (!is_null($use_template))
        {
            $template = $use_template;
        }
        elseif (property_exists($this, 'template_name'))
        {
            $template = static::$template_name;
        }
        elseif (isset($this->template))
        {
            $template = $this->template;
        }
        elseif (isset($this->pivot_data) && isset($this->pivot_data->template))
        {
            $template = $this->pivot_data->template;
        }
        else
        {
            $template = $default_template;
        }

        if (!is_null($subdirectory))
        {
            return sprintf('%s.%s.%s.%s', static::$template_dir, $this->getModelName(), $subdirectory, $template);
        }

        return sprintf('%s.%s.%s', static::$template_dir, $this->getModelName(), $template);
    }

    public function getTemplateOptions(Web $web = null)
    {
        $templates = new Collection();

        if (is_null($web))
        {
            $web = $this->web()->exists() ? $this->web : null;
        }

        if ($web)
        {
            $views = Config::get('view.paths');
            $path = reset($views);
            $path = sprintf('%s/%s', dirname($path), 'template-sets');
            $path = sprintf('%s/%s/%s/%s/*.blade.php', $path, $web->frontpageSettings->template_set, static::$template_dir, $this->getModelName());

            (new Collection(File::glob($path)))->each(function ($file_path, $key) use ($templates)
            {
                $pathinfo = pathinfo($file_path);
                $template = str_replace('.blade', '', $pathinfo['filename']);

                $templates->put($template, $template);
            });
        }

        return $templates;
    }

    public function fillCustom($data, $action = null)
    {
        if (!isset($data['web_id']))
        {
            if (isset($data['_page_template_id']))
            {
                $page_elementable = PageTemplate::findOrFail($data['_page_template_id']);
            }
            elseif (isset($data['_page_proxy_id']))
            {
                $page_elementable = PageProxy::findOrFail($data['_page_proxy_id']);
            }
            elseif (isset($data['_page_id']))
            {
                $page_elementable = Page::findOrFail($data['_page_id']);
            }
            elseif (isset($data['_article_id']))
            {
                $page_elementable = Article::findOrFail($data['_article_id']);
            }

            if (!isset($page_elementable))
            {
                throw new \InvalidArgumentException(sprintf('Undefined _page_template_id or _page_proxy_id or _page_id or _article_id'));
            }

            $this->web_id = $page_elementable->web->id;
        }

        return $this;
    }

    public function cloneContaineeRelations($original_page_elementable, $page_elementable)
    {
        return $this;
    }

    // @todo: this is not nice
    public function getModelViewerComponentInside(Translatable $component)
    {
        $controller = App::make($this->getControllerClass());

        return PageElementViewer::build($controller, $controller)->setModel($this)->setController($controller);
    }

    public function setParentPageElementable(PageElementable $page_elementable)
    {
        $this->parent_page_elementable = $page_elementable;

        return $this;
    }

    public function getParentPageElementable()
    {
        return $this->parent_page_elementable;
    }

    public function setPivotData($pivot_data)
    {
        $this->pivot_data = $pivot_data;

        return $this;
    }

    public function getPivotData(): Collection
    {
        return new Collection($this->pivot_data);
    }

    public function pages()
    {
        return $this->morphToMany(Page::class, 'page_element', Page::make()->getPageElementsPivotTable())->withPivot(Page::make()->getPivotExtra());
    }

    public function pageProxies()
    {
        return $this->morphToMany(PageProxy::class, 'page_element', PageProxy::make()->getPageElementsPivotTable())->withPivot(PageProxy::make()->getPivotExtra());
    }

    public function pageTemplates()
    {
        return $this->morphToMany(PageTemplate::class, 'page_element', PageTemplate::make()->getPageElementsPivotTable())->withPivot(PageTemplate::make()->getPivotExtra());
    }
}