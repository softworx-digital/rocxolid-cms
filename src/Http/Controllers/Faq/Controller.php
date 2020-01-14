<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Faq;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\CMS\Models\Faq;
use Softworx\RocXolid\CMS\Repositories\Faq\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Faq::class;

    protected static $repository_class = Repository::class;
}
