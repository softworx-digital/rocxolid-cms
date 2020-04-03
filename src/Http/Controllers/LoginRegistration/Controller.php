<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\LoginRegistration;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\LoginRegistration;
use Softworx\RocXolid\CMS\Repositories\LoginRegistration\Repository;

class Controller extends AbstractPageElementController
{


    protected static $repository_class = Repository::class;
}
