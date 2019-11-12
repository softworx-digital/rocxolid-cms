<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\TopPanel;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\TopPanel;
use Softworx\RocXolid\CMS\Repositories\TopPanel\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = TopPanel::class;

    protected static $repository_class = Repository::class;
}