<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\FooterNote;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\FooterNote;
use Softworx\RocXolid\CMS\Repositories\FooterNote\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = FooterNote::class;

    protected static $repository_class = Repository::class;
}
