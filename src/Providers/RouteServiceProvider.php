<?php

namespace Softworx\Rocxolid\CMS\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Softworx\RocXolid\Services\CrudRouterService;

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
            ->load($this->app->router);

        return $this;
    }

    /**
     * Define the routes for the package.
     *
     * @param  \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(Router $router): IlluminateServiceProvider
    {
        // previews
        $router->group([
            'module' => 'rocXolid-cms',
            'middleware' => [ 'web' ],
            'namespace' => 'Softworx\RocXolid\CMS\Http\Controllers',
            'prefix' => sprintf('%s/cms/preview', config('rocXolid.main.admin-path', 'rocXolid')),
            'as' => 'rocxolid.cms.frontpage.preview.'
        ], function ($router) {
            $router->group([
                'prefix' => '/page-template',
            ], function ($router) {
                $router->get('/{page_template}', 'PreviewController@pageTemplate')->name('page-template');
            });
            $router->group([
                'prefix' => '/page',
            ], function ($router) {
                $router->get('{page}', 'PreviewController@page')->name('page');
            });
        });

        $router->group([
            'module' => 'rocXolid-cms',
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\CMS\Http\Controllers',
            'prefix' => sprintf('%s/cms', config('rocXolid.main.admin-path', 'rocXolid')),
            'as' => 'rocxolid.cms.',
        ], function ($router) {
            CrudRouterService::create('web-frontpage-settings', \WebFrontpageSettings\Controller::class);

            $router->group([
                'namespace' => 'WebFrontpageSettings',
                'prefix' => 'web-frontpage-settings',
            ], function ($router) {
                $router->get('/{web_frontpage_settings}/clone-structure', 'Controller@cloneStructure');
                $router->match(['PUT', 'PATCH'], '/{web_frontpage_settings}/clone-structure-submit', 'Controller@cloneStructureSubmit');
            });

            CrudRouterService::create('page-template', \PageTemplate\Controller::class);
            CrudRouterService::create('page', \Page\Controller::class);
            CrudRouterService::create('page-proxy', \PageProxy\Controller::class);

            // @todo: create router helper (such as CrudRouterService)
            $router->group([
                'namespace' => 'PageTemplate',
                'prefix' => 'page-template',
            ], function ($router) {
                $router->get('/{page_template}/select-page-element-class/{page_element_class_action}', 'Controller@selectPageElementClass');
                $router->get('/{page_template}/page-element-choice/{page_element_short_class}', 'Controller@listPageElement');
                $router->match(['PUT', 'PATCH'], '/{page_template}/page-element-choice/{page_element_short_class}', 'Controller@selectPageElement');
                $router->post('/{page_template}/update-page-elements-order', 'Controller@updatePageElementsOrder');
                $router->post('/{page}/update-pivot-data/{page_elementable_type}/{page_elementable_id}', 'Controller@setPivotData');
                $router->get('/{page_template}/preview', 'Controller@preview');
            });

            $router->group([
                'namespace' => 'Page',
                'prefix' => 'page',
            ], function ($router) {
                $router->get('/{page}/select-page-element-class/{page_element_class_action}', 'Controller@selectPageElementClass');
                $router->get('/{page}/page-element-choice/{page_element_short_class}', 'Controller@listPageElement');
                $router->match(['PUT', 'PATCH'], '/{page}/page-element-choice/{page_element_short_class}', 'Controller@selectPageElement');
                $router->post('/{page}/update-page-elements-order', 'Controller@updatePageElementsOrder');
                $router->post('/{page}/update-pivot-data/{page_elementable_type}/{page_elementable_id}', 'Controller@setPivotData');
                $router->get('/{page}/preview', 'Controller@preview');
            });

            $router->group([
                'namespace' => 'PageProxy',
                'prefix' => 'page-proxy',
            ], function ($router) {
                $router->get('/{page_proxy}/select-page-element-class/{page_element_class_action}', 'Controller@selectPageElementClass');
                $router->get('/{page_proxy}/page-element-choice/{page_element_short_class}', 'Controller@listPageElement');
                $router->match(['PUT', 'PATCH'], '/{page_proxy}/page-element-choice/{page_element_short_class}', 'Controller@selectPageElement');
                $router->post('/{page_proxy}/update-page-elements-order', 'Controller@updatePageElementsOrder');
                $router->post('/{page_proxy}/update-pivot-data/{page_elementable_type}/{page_elementable_id}', 'Controller@setPivotData');
                $router->get('/{page_proxy}/preview', 'Controller@preview');
            });

            $router->group([
                'as' => 'page-element.',
                'prefix' => 'page-element',
            ], function ($router) {
                // general page elements - (usually) cloned from template
                CrudRouterService::create('text', \Text\Controller::class);
                CrudRouterService::create('link', \Link\Controller::class);
                CrudRouterService::create('gallery', \Gallery\Controller::class);
                CrudRouterService::create('iframe-video', \IframeVideo\Controller::class);
                // panels
                CrudRouterService::create('html-wrapper', \HtmlWrapper\Controller::class);
                CrudRouterService::create('cookie-consent', \CookieConsent\Controller::class);
                CrudRouterService::create('footer-navigation', \FooterNavigation\Controller::class);
                CrudRouterService::create('footer-note', \FooterNote\Controller::class);
                CrudRouterService::create('stats-panel', \StatsPanel\Controller::class);
                CrudRouterService::create('top-panel', \TopPanel\Controller::class);
                // specials (forms)
                CrudRouterService::create('newsletter', \Newsletter\Controller::class);
                CrudRouterService::create('search-engine', \SearchEngine\Controller::class);
                CrudRouterService::create('login-registration', \LoginRegistration\Controller::class);
                CrudRouterService::create('forgot-password', \ForgotPassword\Controller::class);
                CrudRouterService::create('user-profile', \UserProfile\Controller::class);
                CrudRouterService::create('contact', \Contact\Controller::class);
                // containers (for page elements)
                CrudRouterService::create('main-navigation', \MainNavigation\Controller::class);
                CrudRouterService::create('row-navigation', \RowNavigation\Controller::class);
                CrudRouterService::create('main-slider', \MainSlider\Controller::class);
                // containers (for other models)
                CrudRouterService::create('article-list', \ArticleList\Controller::class);
                // containees
                CrudRouterService::create('navigation-item', \NavigationItem\Controller::class);
                CrudRouterService::create('slider-item', \SliderItem\Controller::class);
            });

            CrudRouterService::create('article', \Article\Controller::class);

            $router->group([
                'namespace' => 'Article',
                'prefix' => 'article',
            ], function ($router) {
                $router->get('/{article}/select-page-element-class/{page_element_class_action}', 'Controller@selectPageElementClass');
                $router->get('/{article}/page-element-choice/{page_element_short_class}', 'Controller@listPageElement');
                $router->match(['PUT', 'PATCH'], '/{article}/page-element-choice/{page_element_short_class}', 'Controller@selectPageElement');
                $router->post('/{article}/update-page-elements-order', 'Controller@updatePageElementsOrder');
                $router->post('/{article}/update-pivot-data/{page_elementable_type}/{page_elementable_id}', 'Controller@setPivotData');
                $router->get('/{article}/preview', 'Controller@preview');
            });

            $router->group([
                'namespace' => 'Gallery',
                'prefix' => 'gallery',
            ], function ($router) {
                $router->get('/{gallery}/regenerate', 'Controller@regenerateConfirmation');
                $router->post('/{gallery}/regenerate', 'Controller@regenerate');
                $router->get('/{gallery}/clear', 'Controller@clearConfirmation');
                $router->post('/{gallery}/clear', 'Controller@clear');
            });

            $router->group([
                'as' => 'page-proxy-element.',
                'prefix' => 'page-proxy-element',
            ], function ($router) {
                CrudRouterService::create('article', \ProxyArticle\Controller::class);
                CrudRouterService::create('product', \ProxyProduct\Controller::class);
            });
        });

        return $this;
    }
}
