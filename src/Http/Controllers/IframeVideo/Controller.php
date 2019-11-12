<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\IframeVideo;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
use Softworx\RocXolid\CMS\Models\IframeVideo;
use Softworx\RocXolid\CMS\Repositories\IframeVideo\Repository;

class Controller extends AbstractPageElementController
{
    protected static $model_class = IframeVideo::class;

    protected static $repository_class = Repository::class;
}