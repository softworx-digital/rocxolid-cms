<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\PageTemplate;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementableController;
use Softworx\RocXolid\CMS\Models\PageTemplate;
use Softworx\RocXolid\CMS\Repositories\PageTemplate\Repository;

class Controller extends AbstractPageElementableController
{


    protected static $repository_class = Repository::class;
}
