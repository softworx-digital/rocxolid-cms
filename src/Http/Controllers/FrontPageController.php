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

    // @todo kinda quick'n'dirty
    // @todo make custom request class for identifying web,...
    /*
    public function __invoke(Request $request, $path = null)
    {
        $web = $this->detectOnlyWeb($request);
        // $localization = ($slug === '/') ? $web->defaultLocalization : $this->detectLocalization($web, $slug);
        $localization = $web->defaultLocalization;
        $page = $this->detectPage($web, $localization, $path);

        app()->setLocale($localization->language->iso_639_1); // @todo as Localization's (service?) method

        if ($page) {
            return $page
                ->setPresenting()
                ->setDependenciesDataProvider(app(RequestElementableDependencyDataProvider::class, [ 'request' => $request ]))
                ->getModelViewerComponent()
                    ->setViewTheme($page->theme)
                    ->render('default', [
                        'rxUser' => auth('rocXolid')->user(),
                        'web' => $web,
                        'page' => $page,
                        'header_component_viewer' => $page->hasHeader()
                            ? $page->getHeader()
                                // ->setDependenciesDataProvider($estate_document)
                                ->getModelViewerComponent()
                                    ->setViewTheme($page->provideViewTheme())
                            : null,
                        'footer_component_viewer' => $page->hasFooter()
                            ? $page->getFooter()
                                // ->setDependenciesDataProvider($estate_document)
                                ->getModelViewerComponent()
                                    ->setViewTheme($page->provideViewTheme())
                            : null,
                    ]);
        } else {
            abort(404);
        }
    }
    */
}