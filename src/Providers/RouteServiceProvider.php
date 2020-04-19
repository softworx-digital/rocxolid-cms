<?php

namespace Softworx\RocXolid\CMS\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid services
use Softworx\RocXolid\Services\CrudRouterService;
// rocXolid cms services
use Softworx\RocXolid\CMS\Services\ElementableRouterService;

/**
 * rocXolid routes service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class RouteServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid routing services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load($this->app->router)
            ->mapRouteModels($this->app->router);

        return $this;
    }

    /**
     * Define the routes for the package.
     *
     * @param \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(Router $router): IlluminateServiceProvider
    {
        $router->group([
            'module' => 'rocXolid-cms',
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\CMS\Http\Controllers',
            'prefix' => sprintf('%s/cms', config('rocXolid.admin.general.routes.root', 'rocXolid')),
            'as' => 'rocXolid.cms.',
        ], function ($router) {
            CrudRouterService::create('web-frontpage-settings', \WebFrontpageSettings\Controller::class, [
                'parameters' => [
                    'web-frontpage-settings' => 'web_frontpage_settings',
                ],
            ]);

            $router->group([
                'namespace' => 'WebFrontpageSettings',
                'prefix' => 'web-frontpage-settings',
            ], function ($router) {
                $router->get('/{web_frontpage_settings}/clone-structure', 'Controller@cloneStructure');
                $router->match(['PUT', 'PATCH'], '/{web_frontpage_settings}/clone-structure-submit', 'Controller@cloneStructureSubmit');
            });

            ElementableRouterService::create('page-template', \PageTemplate\Controller::class);
            ElementableRouterService::create('page', \Page\Controller::class);
            ElementableRouterService::create('page-proxy', \PageProxy\Controller::class);

            ElementableRouterService::create('article', \Article\Controller::class);

            CrudRouterService::create('faq', \Faq\Controller::class);

            CrudRouterService::create('document-type', \DocumentType\Controller::class);
            ElementableRouterService::create('document', \Document\Controller::class);
        });

        return $this;
    }

    /**
     * Define the route bindings for URL params.
     *
     * @param \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function mapRouteModels(Router $router): IlluminateServiceProvider
    {
        $router->model('web_frontpage_settings', \Softworx\RocXolid\CMS\Models\WebFrontpageSettings::class);
        //
        $router->model('page_template', \Softworx\RocXolid\CMS\Models\PageTemplate::class);
        $router->model('page', \Softworx\RocXolid\CMS\Models\Page::class);
        $router->model('page_proxy', \Softworx\RocXolid\CMS\Models\PageProxy::class);
        //
        $router->model('article', \Softworx\RocXolid\CMS\Models\Article::class);
        $router->model('faq', \Softworx\RocXolid\CMS\Models\Faq::class);
        //
        $router->model('document_type', \Softworx\RocXolid\CMS\Models\DocumentType::class);
        $router->model('document', \Softworx\RocXolid\CMS\Models\Document::class);

        return $this;
    }
}
