<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Contact;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\Contact;
use Softworx\RocXolid\CMS\Repositories\Contact\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = Contact::class;

    protected static $repository_class = Repository::class;
}