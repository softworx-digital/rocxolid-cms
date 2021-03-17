<?php

namespace Softworx\RocXolid\CMS\Services;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
// rocXolid models
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common traits
use Softworx\RocXolid\Common\Http\Traits as CommonTraits;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms controller
use Softworx\RocXolid\CMS\Http\Controllers\FrontPageController;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;

/**
 * rocXolid CMS frontpage routes service provider.
 * Registers routes related to public websites.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class FrontpageRouterService
{
    use CommonTraits\DetectsWeb;

    private $controller;

    private function __construct()
    {
        $this->controller = app(FrontPageController::class);
    }

    public static function register(Router $router)
    {
        return (new static())->registerPageRoutes($router);
    }

    // @todo kinda quick'n'dirty
    private function registerPageRoutes(Router $router)
    {
        try {
            $web = $this->detectOnlyWeb(request());
        } catch (\Exception $e) {

        }

        if (isset($web) && $web) {
            // $localization = ($slug === '/') ? $web->defaultLocalization : $this->detectLocalization($web, $slug);
            $localization = $web->defaultLocalization;

            app()->setLocale($localization->language->iso_639_1); // @todo as Localization's (service?) method

            $router->group([
                'middleware' => [ 'web' ],
                'as' => 'web.',
            ], function (Router $router) use ($web, $localization) {
                // $router->any('/{path?}', FrontPageController::class)->where('path', '([A-Za-z0-9_\-\/]+)');
                $this->pages($web, $localization)->each(function(Page $page) use ($router, $web) {
                    $this->registerPageRoute($router, $web, $page);
                });
            });
        }
    }

    private function registerPageRoute(Router $router, Web $web, Page $page): self
    {
        $router->get($page->route_path, function (Request $request, ?Crudable $model = null, string $slug = null) use ($web, $page) {
            return ($this->controller)($request, $web, $page, $model, $slug);
        });

        return $this;
    }

    private function pages(Web $web, Localization $localization): Collection
    {
        // @todo use scope
        return Page::where('is_enabled', true)
            ->where('web_id', $web->getKey())
            ->where('localization_id', $localization->getKey())
            ->get();
    }
}
