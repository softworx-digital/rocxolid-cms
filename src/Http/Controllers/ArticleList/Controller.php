<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ArticleList;

// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementListController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ArticleListViewer;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Article;

/**
 * @todo: docblock
 */
class Controller extends AbstractPageElementListController
{
    protected static $model_viewer_type = ArticleListViewer::class;

    protected static $containee_class = Article::class;
}
