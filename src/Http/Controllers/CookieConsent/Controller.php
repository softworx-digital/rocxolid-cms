<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\CookieConsent;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\CookieConsent;
use Softworx\RocXolid\CMS\Repositories\CookieConsent\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = CookieConsent::class;

    protected static $repository_class = Repository::class;
}