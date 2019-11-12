<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Text;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\Text;
use Softworx\RocXolid\CMS\Repositories\Text\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = Text::class;

    protected static $repository_class = Repository::class;
}