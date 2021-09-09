<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// rocXolid models
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\AbstractPagePart;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\DocumentPartViewer;
// rocXolid cms dependency data providers
use Softworx\RocXolid\CMS\Support\RouteElementableDependencyDataProvider;

/**
 *
 */
class FrontPageController extends Controller
{
    public function __invoke(Request $request, Web $web, Localization $localization, Page $page, ?Crudable $model = null, ?string $slug = null)
    {
        // @todo as Localization's (service?) method
        app()->setLocale($localization->language->iso_639_1);
        Carbon::setlocale($localization->language->iso_639_1);

        // dd(__METHOD__, $request->route(), $web, $page, $localization, $model);
        return $page
            ->setPresenting()
            ->setDependenciesDataProvider(app(RouteElementableDependencyDataProvider::class, [ 'route' => $request->route() ]))
            ->getModelViewerComponent()
                ->setViewTheme($page->theme)
                ->render('default', $this->pageAssignments($web, $localization, $page));
    }

    private function pageAssignments(Web $web, Localization $localization, Page $page): array
    {
        return [
            'rxuser' => auth('rocXolid')->user(),
            'web' => $web,
            'localization' => $localization,
            'page' => $page,
            'header_component_viewer' => $this->pageHeaderComponent($page),
            'footer_component_viewer' => $this->pageFooterComponent($page),
        ];
    }

    private function pageHeaderComponent(Page $page): ?DocumentPartViewer
    {
        if (is_null($header = $page->getHeader())) {
            return null;
        }

        return $this->preparePartViewerComponent($page, $header);
    }

    private function pageFooterComponent(Page $page): ?DocumentPartViewer
    {
        if (is_null($footer = $page->getFooter())) {
            return null;
        }

        return $this->preparePartViewerComponent($page, $footer);
    }

    private function preparePartViewerComponent(Page $page, AbstractPagePart $part): DocumentPartViewer
    {
        return $part
            ->setPresenting($page->isPresenting())
            ->getModelViewerComponent()
            ->setViewTheme($page->provideViewTheme());
    }
}