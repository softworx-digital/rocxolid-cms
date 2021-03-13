<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// rocXolid common traits
use Softworx\RocXolid\Common\Http\Traits as CommonTraits;
// rocXolid cms traits
use Softworx\RocXolid\CMS\Http\Traits as CMSTraits;
// rocXolid user management traits
use Softworx\RocXolid\UserManagement\Models\Traits\DetectsUser as DetectsRocXolidUser;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\PageTemplate;
use Softworx\RocXolid\CMS\Models\Page;
// rocXolid cms dependency data providers
use Softworx\RocXolid\CMS\Support\RequestElementableDependencyDataProvider;

/**
 *
 */
class FrontPageController extends Controller
{
    use CommonTraits\DetectsWeb;
    use CMSTraits\DetectsPage;

    // @todo kinda quick'n'dirty
    // @todo make custom request class for identifying web,...
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
}