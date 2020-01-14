<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// commerce traits
use Softworx\RocXolid\Common\Http\Traits\DetectsWeb;
// user management traits
use Softworx\RocXolid\UserManagement\Models\Traits\DetectsUser as DetectsRocXolidUser;
// cms models
use Softworx\RocXolid\CMS\Models\PageTemplate;
use Softworx\RocXolid\CMS\Models\Page;

/**
 *
 */
class PreviewController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use DetectsWeb;
    use DetectsRocXolidUser;

    public function pageTemplate(Request $request, PageTemplate $page_template)
    {
        $web = $this->detectWeb($request);

        if ($page_template->web != $web) {
            throw new \RuntimeException(sprintf('Invalid page template [%s] for web [%s]', $page_template->id, $web->id));
        }

        return view('preview.page-template', [
            'rxUser' => $this->detectRxUser(),
            'web' => $web,
            'page_template' => $page_template,
            'user' => false,
        ]);
    }

    public function page(Request $request, Page $page)
    {
        $web = $this->detectWeb($request);

        if ($page->web != $web) {
            throw new \RuntimeException(sprintf('Invalid page template [%s] for web [%s]', $page_template->id, $web->id));
        }

        return view('preview.page', [
            'rxUser' => $this->detectRxUser(),
            'web' => $web,
            'page' => $page,
            'user' => false,
        ]);
    }
}
