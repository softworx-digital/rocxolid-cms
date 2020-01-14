<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ShoppingCart;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\ShoppingCart;
use Softworx\RocXolid\CMS\Repositories\ShoppingCart\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = ShoppingCart::class;

    protected static $repository_class = Repository::class;
}
