<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Page;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
// rocXolid cms controller
use Softworx\RocXolid\CMS\Http\Controllers\FrontPageController;
// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\RoutePathParamsProvider;
// rocXolid cms elementable dependencies
use Softworx\RocXolid\CMS\ElementableDependencies\AbstractElementableDependency;

/**
 * Provide serach expression dependency for elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class SearchExpression extends AbstractElementableDependency implements RoutePathParamsProvider
{
    public function registerPageRoute(Router $router, FrontPageController $controller, Web $web, Page $page): self
    {
        $router->get($page->route_path, function (Request $request, string $expression = null) use ($controller, $web, $page) {
            return ($controller)($request, $web, $page);
        });

        return $this;
    }

    public function addRoutePathParameter(Elementable $elementable): Elementable
    {
        $elementable->route_path .= sprintf('/{%s}', $this->getAssignmentDefaultName());

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
            $assignments = $assignments->merge($dependency_data_provider->getDependencyData()->transform(function (string $expression) {
                return urldecode($expression);
            }));
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function validateAssignmentData(Collection $data, string $attribute): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function assignmentValidationErrorMessage(TranslationPackageProvider $controller, Collection $data): string
    {
        return '';
    }
}
