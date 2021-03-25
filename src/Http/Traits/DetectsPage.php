<?php

namespace Softworx\RocXolid\CMS\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;

/**
 *
 */
trait DetectsPage
{
    private $_page = null;

    public function detectPage(Web $web = null, Localization $localization = null, $path = null)
    {
        if (!is_null($this->_page)) {
            return $page;
        }

        if (is_null($web)) {
            throw new \InvalidArgumentException('Web is required for first-time page detection');
        }

        if (is_null($localization)) {
            throw new \InvalidArgumentException('Localization is required for first-time page detection');
        }

        if (!preg_match('/^(([a-z0-9\\/+\$_-]\.?)+)*\/?$/', $path)) {
            dd('path regcheck error');
        }

        $this->_page = Page::where('is_enabled', true)
            ->where('web_id', $web->getKey())
            ->where('localization_id', $localization->getKey())
            ->whereRaw(sprintf("'%s' REGEXP CONCAT('^', `path_regex`, '$')", (string)$path))
            ->first();

        return $this->_page;
    }
}
