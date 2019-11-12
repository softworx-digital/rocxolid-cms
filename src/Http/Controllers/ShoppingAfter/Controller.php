<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ShoppingAfter;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\ShoppingAfter;
use Softworx\RocXolid\CMS\Repositories\ShoppingAfter\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = ShoppingAfter::class;

    protected static $repository_class = Repository::class;
}