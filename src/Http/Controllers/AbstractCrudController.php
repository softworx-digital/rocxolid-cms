<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use Softworx\RocXolid\Http\Controllers\AbstractCrudController as RocXolidAbstractCrudController;
use Softworx\RocXolid\CMS\Components\Dashboard\Crud as CrudDashboard;

abstract class AbstractCrudController extends RocXolidAbstractCrudController
{
    protected static $dashboard_class = CrudDashboard::class;
}