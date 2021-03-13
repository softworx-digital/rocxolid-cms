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
            // ElementableRouterService::create('page-template', \PageTemplate\Controller::class);

            // ElementableRouterService::create('page-proxy', \PageProxy\Controller::class);

            ElementableRouterService::create('article', \Article\Controller::class);

            $router->group([
                'namespace' => 'Article',
                'prefix' => 'article',
                'as' => 'article.'
            ], function (Router $router) {
                $router->get('/{article}/{tab?}', 'Controller@show')->name('show');
            });

            CrudRouterService::create('faq', \Faq\Controller::class);

            CrudRouterService::create('data-dependency', \DataDependency\Controller::class);

            CrudRouterService::create('document-type', \DocumentType\Controller::class);

            ElementableRouterService::create('document', \Document\Controller::class);
            ElementableRouterService::create('document-header', \DocumentHeader\Controller::class);
            ElementableRouterService::create('document-footer', \DocumentFooter\Controller::class);

            $router->group([
                'namespace' => 'Document',
                'prefix' => 'document',
                'as' => 'document.'
            ], function (Router $router) {
                $router->get('/{document}/{tab?}', 'Controller@show')->name('show');
            });

            $router->group([
                'namespace' => 'DocumentOrganizer',
                'prefix' => 'document-organizer',
                'as' => 'document-organizer.',
            ], function ($router) {
                $router->get('', 'Controller@index')->name('index');
                $router->post('/save/position', 'Controller@savePosition')->name('save.position');
            });

            ElementableRouterService::create('page', \Page\Controller::class);
            ElementableRouterService::create('page-header', \PageHeader\Controller::class);
            ElementableRouterService::create('page-footer', \PageFooter\Controller::class);

            $router->group([
                'namespace' => 'Page',
                'prefix' => 'page',
                'as' => 'page.'
            ], function (Router $router) {
                $router->get('/{page}/{tab?}', 'Controller@show')->name('show');
            });
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
        // $router->model('page_template', \Softworx\RocXolid\CMS\Models\PageTemplate::class);
        $router->model('page', \Softworx\RocXolid\CMS\Models\Page::class);
        $router->model('page_header', \Softworx\RocXolid\CMS\Models\PageHeader::class);
        $router->model('page_footer', \Softworx\RocXolid\CMS\Models\PageFooter::class);
        // $router->model('page_proxy', \Softworx\RocXolid\CMS\Models\PageProxy::class);
        //
        $router->model('article', \Softworx\RocXolid\CMS\Models\Article::class);
        $router->model('faq', \Softworx\RocXolid\CMS\Models\Faq::class);
        //
        $router->model('data_dependency', \Softworx\RocXolid\CMS\Models\DataDependency::class);
        //
        $router->model('document_type', \Softworx\RocXolid\CMS\Models\DocumentType::class);
        $router->model('document', \Softworx\RocXolid\CMS\Models\Document::class);
        $router->model('document_header', \Softworx\RocXolid\CMS\Models\DocumentHeader::class);
        $router->model('document_footer', \Softworx\RocXolid\CMS\Models\DocumentFooter::class);

        return $this;
    }
}
