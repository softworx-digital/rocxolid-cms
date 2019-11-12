<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\HtmlWrapper;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\HtmlWrapper;
use Softworx\RocXolid\CMS\Repositories\HtmlWrapper\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = HtmlWrapper::class;

    protected static $repository_class = Repository::class;
}