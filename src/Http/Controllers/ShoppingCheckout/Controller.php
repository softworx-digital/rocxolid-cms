<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ShoppingCheckout;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\ShoppingCheckout;
use Softworx\RocXolid\CMS\Repositories\ShoppingCheckout\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = ShoppingCheckout::class;

    protected static $repository_class = Repository::class;
}