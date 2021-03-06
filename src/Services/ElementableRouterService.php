<?php

namespace Softworx\RocXolid\CMS\Services;

use Illuminate\Support\Facades\Route;
// rocXolid services
use Softworx\RocXolid\Services\CrudRouterService;

/**
 * rocXolid CMS elementable routes service provider.
 * Registers routes related to content composition.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ElementableRouterService extends CrudRouterService
{
    protected function registerPackageRoutes(string $param): CrudRouterService
    {
        Route::get($this->name . sprintf('/{%s}/snippets', $param), [
            'as' => 'crud.' . $this->name . '.element-snippets',
            'uses' => $this->controller . '@elementSnippets',
        ]);

        Route::get($this->name . sprintf('/{%s}/placeholders', $param), [
            'as' => 'crud.' . $this->name . '.content-placeholders',
            'uses' => $this->controller . '@contentPlaceholders',
        ]);

        Route::get($this->name . sprintf('/{%s}/mutators', $param), [
            'as' => 'crud.' . $this->name . '.content-mutators',
            'uses' => $this->controller . '@contentMutators',
        ]);

        Route::post($this->name . sprintf('/{%s}/composition', $param), [
            'as' => 'crud.' . $this->name . '.composition.update',
            'uses' => $this->controller . '@storeComposition',
        ]);

        Route::post($this->name . sprintf('/{%s}/composition/detach/element', $param), [
            'as' => 'crud.' . $this->name . '.composition.detach.element',
            'uses' => $this->controller . '@detachElement',
        ]);

        Route::delete($this->name . sprintf('/{%s}/composition/destroy/element', $param), [
            'as' => 'crud.' . $this->name . '.composition.destroy.element',
            'uses' => $this->controller . '@destroyElement',
        ]);

        Route::post($this->name . sprintf('/{%s}/preview/pdf', $param), [
            'as' => 'crud.' . $this->name . '.preview-pdf',
            'uses' => $this->controller . '@previewPdf',
        ]);

        /*
        Route::group([
            'namespace' => ,
            'prefix' => 'page-template',
        ], function () {
            $router->get('/{document}/snippets', 'Controller@elementSnippets');
            $router->post('/{document}/preview-pdf', 'Controller@previewPdf');


            $router->get('/{page_template}/select-page-element-class/{page_element_class_action}', 'Controller@selectPageElementClass');
            $router->get('/{page_template}/page-element-choice/{page_element_short_class}', 'Controller@listPageElement');
            $router->match(['PUT', 'PATCH'], '/{page_template}/page-element-choice/{page_element_short_class}', 'Controller@selectPageElement');
            $router->post('/{page_template}/update-page-elements-order', 'Controller@updatePageElementsOrder');
            $router->post('/{page}/update-pivot-data/{page_elementable_type}/{page_elementable_id}', 'Controller@setPivotData');
            $router->get('/{page_template}/preview', 'Controller@preview');
        });
        */

        return $this;
    }
}
