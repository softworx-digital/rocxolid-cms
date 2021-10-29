<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Traits;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
// rocXolid models
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms controller
use Softworx\RocXolid\CMS\Http\Controllers\FrontPageController;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 *
 */
trait RouteDependency
{
    public function registerPageRoute(Router $router, FrontPageController $controller, Web $web, Localization $localization, Page $page): self
    {
        $router->get($page->frontpageRoute($web, $localization), function (Request $request, ?Crudable $model = null, string $slug = null) use ($controller, $web, $localization, $page) {
            if (is_null($model) || $this->isModelEnabled($model)) {
                if (!is_null($model)) {
                    $this->prepareModelPresentation($request, $web, $localization, $page, $model, $slug);
                }

                return ($controller)($request, $web, $localization, $page, $model, $slug);
            } else {
                return abort(404);
            }
        })->name($this->getAssignmentDefaultName());

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addRoutePathParameter(Elementable $elementable): Elementable
    {
        $elementable->route_path .= sprintf('/{%s}/{slug}', $this->getAssignmentDefaultName());

        return $elementable;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyViewValue(ElementableDependencyDataProvider $dependency_data_provider)
    {
        return __METHOD__;
    }

    /**
     * {@inheritDoc}
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $dependency_data_provider, ?string $key = null): ElementableDependency
    {
        if ($dependency_data_provider->isReady()) {
            $assignments = $assignments->merge($dependency_data_provider->getDependencyData());
        }

        return $this;
    }

    protected function prepareModelPresentation(Request $request, Web $web, Localization $localization, Page $page, Crudable $model, string $slug = null): ElementableDependency
    {
        return $this;
    }

    protected function isModelEnabled(Crudable $model): bool
    {
        return true;
    }
}
