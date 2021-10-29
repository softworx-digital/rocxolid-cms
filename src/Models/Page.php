<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\Cloneable;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\ViewThemeProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\RoutePathParamsProvider;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;
use Softworx\RocXolid\CMS\Models\PageTemplate;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;

/**
 * Page model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Page extends AbstractElementable implements
    ElementsDependenciesProvider,
    ElementsMutatorsProvider,
    ViewThemeProvider
{
    use Traits\HasPageHeader;
    use Traits\HasPageFooter;
    use Traits\HasDependencies;
    use Traits\HasMutators;
    use Traits\ProvidesViewTheme;

    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_pages';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'is_web_localization_homepage',
        'web_id',
        'localization_id',
        // 'page_template_id',
        'name',
        'path',
        'theme',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'open_graph_title',
        'open_graph_description',
        'open_graph_type',
        'open_graph_url',
        'open_graph_site_name',
        'description'
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
        // 'pageTemplate',
    ];

    /**
     * {@inheritDoc}
     */
    protected $image_sizes = [
        'openGraphImage' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 600, 'height' => 600, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'default' => [ 'width' => 1080, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        $this
            ->adjustPath($data)
            ->fillRoutePath($data)
            ->fillDependencies($data);

        $this->provideDependencies()->each(function (RoutePathParamsProvider $route_path_params_provider) {
            $route_path_params_provider->addRoutePathParameter($this);
        });

        return parent::fillCustom($data);
    }

    // @todo extremely hotfixed
    public function getMetaTitle()
    {
        if ($this->getDependenciesDataProvider()) {
            foreach ($this->getDependenciesDataProvider()->getDependencyData() as $dependency) {
                if ($dependency instanceof Crudable) {
                    return sprintf('%s | %s | %s', $dependency->getMetaTitle(), $this->meta_title, $this->web->getTitle());
                }
            }
        }

        return sprintf('%s | %s', $this->meta_title, $this->web->getTitle());
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorContentAreaClass(): string
    {
        return 'keditor-rx-page-content-area';
    }

    protected function adjustPath(Collection $data): Crudable
    {
        $this->path = $this->path ?? '';

        return $this;
    }

    protected function fillRoutePath(Collection $data): Crudable
    {
        $this->route_path = sprintf('/%s', $this->path);

        return $this;
    }

    /**
     * Check if given Page is a home page for it's Web and Localization.
     *
     * @return bool
     */
    public function isHomePage(): bool
    {
        return (bool)$this->is_web_localization_homepage;
    }

    /**
     * {@inheritDoc}
     */
    public function isReady(): bool
    {
dd(__METHOD__);
        return $this->isPresenting();
    }

    public function registerRoute()
    {
dd(__METHOD__);
        Route::get($this->path_regex, dd(__FILE__));
    }

    public function frontpageRoute(Web $web, Localization $localization): string
    {
        return (bool)$web->is_use_default_localization_url_path || !$localization->is($web->defaultLocalization)
            ? sprintf('/%s%s', $localization->seo_url_slug, $this->route_path)
            : $this->route_path;
    }
}
