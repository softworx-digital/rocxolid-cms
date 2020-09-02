<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\DataDependency;

use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\DataDependencyViewer;

class Controller extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = DataDependencyViewer::class;
}
