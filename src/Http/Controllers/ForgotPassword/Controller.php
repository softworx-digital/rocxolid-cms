<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ForgotPassword;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\ForgotPassword;
use Softworx\RocXolid\CMS\Repositories\ForgotPassword\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = ForgotPassword::class;

    protected static $repository_class = Repository::class;
}