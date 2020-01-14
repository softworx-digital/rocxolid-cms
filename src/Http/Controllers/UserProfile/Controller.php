<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\UserProfile;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\UserProfile;
use Softworx\RocXolid\CMS\Repositories\UserProfile\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = UserProfile::class;

    protected static $repository_class = Repository::class;
}
