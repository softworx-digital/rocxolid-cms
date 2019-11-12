<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ProxyProduct;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementProxyController;
use Softworx\RocXolid\CMS\Models\ProxyProduct;
use Softworx\RocXolid\CMS\Repositories\ProxyProduct\Repository;

class Controller extends AbstractPageElementProxyController
{
    protected static $model_class = ProxyProduct::class;

    protected static $repository_class = Repository::class;
}