<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Article;

// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ArticleViewer;

/**
 * Article controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Controller extends AbstractElementableController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = ArticleViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit.general-data' => 'update-general',
        'update.general-data' => 'update-general',
        'edit.meta-data' => 'update-meta',
        'update.meta-data' => 'update-meta',
        'edit.perex-data' => 'update-perex',
        'update.perex-data' => 'update-perex',
        'edit.content-data' => 'update-content',
        'update.content-data' => 'update-content',
    ];
}
