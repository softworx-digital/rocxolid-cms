<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\StatsPanel;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\StatsPanel;
use Softworx\RocXolid\CMS\Repositories\StatsPanel\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = StatsPanel::class;

    protected static $repository_class = Repository::class;
}