<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Newsletter;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\Newsletter;
use Softworx\RocXolid\CMS\Repositories\Newsletter\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = Newsletter::class;

    protected static $repository_class = Repository::class;
}