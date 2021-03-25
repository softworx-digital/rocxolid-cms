<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// rocXolid models
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\DocumentPartViewer;
// rocXolid cms dependency data providers
use Softworx\RocXolid\CMS\Support\RouteElementableDependencyDataProvider;

/**
 *
 */
class FrontPageController extends Controller
{
    public function __invoke(Request $request, Web $web, Page $page, ?Crudable $model = null, ?string $slug = null)
    {
        // dd(__METHOD__, $request->route(), $web, $page, $model);
        return $page->setPresenting()
            ->setDependenciesDataProvider(app(RouteElementableDependencyDataProvider::class, [ 'route' => $request->route() ]))
            ->getModelViewerComponent()
                ->setViewTheme($page->theme)
                ->render('default', $this->pageAssignments($web, $page));
    }

    private function pageAssignments(Web $web, Page $page): array
    {
        return [
            'rxUser' => auth('rocXolid')->user(),
            'web' => $web,
            'page' => $page,
            'header_component_viewer' => $this->pageHeaderComponent($page),
            'footer_component_viewer' => $this->pageFooterComponent($page),
        ];
    }

    private function pageHeaderComponent(Page $page): ?DocumentPartViewer
    {
        return optional(optional($page->getHeader())->getModelViewerComponent())->setViewTheme($page->provideViewTheme());
    }

    private function pageFooterComponent(Page $page): ?DocumentPartViewer
    {
        return optional(optional($page->getFooter())->getModelViewerComponent())->setViewTheme($page->provideViewTheme());
    }
}