<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Page;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementableController;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Repositories\Page\Repository;

class Controller extends AbstractPageElementableController
{
    protected static $model_class = Page::class;

    protected static $repository_class = Repository::class;
}
