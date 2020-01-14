<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Link;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\Link;
use Softworx\RocXolid\CMS\Repositories\Link\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = Link::class;

    protected static $repository_class = Repository::class;
}
