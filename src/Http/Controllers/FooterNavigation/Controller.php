<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\FooterNavigation;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\FooterNavigation;
use Softworx\RocXolid\CMS\Repositories\FooterNavigation\Repository;

class Controller extends AbstractPageElementController
{


    protected static $repository_class = Repository::class;
}
