<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\PageProxy;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementableController;
use Softworx\RocXolid\CMS\Models\PageProxy;
use Softworx\RocXolid\CMS\Repositories\PageProxy\Repository;

class Controller extends AbstractPageElementableController
{


    protected static $repository_class = Repository::class;
}
