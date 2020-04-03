<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ProxyArticle;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementProxyController;
use Softworx\RocXolid\CMS\Models\ProxyArticle;
use Softworx\RocXolid\CMS\Repositories\ProxyArticle\Repository;

class Controller extends AbstractPageElementProxyController
{


    protected static $repository_class = Repository::class;
}
