<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Article;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementableController;
use Softworx\RocXolid\CMS\Models\Article;
use Softworx\RocXolid\CMS\Repositories\Article\Repository;

class Controller extends AbstractPageElementableController
{
    protected static $model_class = Article::class;

    protected static $repository_class = Repository::class;
}