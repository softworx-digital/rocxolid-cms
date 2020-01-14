<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\SearchEngine;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\SearchEngine;
use Softworx\RocXolid\CMS\Repositories\SearchEngine\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = SearchEngine::class;

    protected static $repository_class = Repository::class;
}
