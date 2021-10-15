<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Article;

// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\Article as ArticleModelViewer;

/**
 * Article model CRUD controller.
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
    protected static $model_viewer_type = ArticleModelViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        //
        'edit.panel.data.general' => 'update-general-data',
        'update.panel.data.general' => 'update-general-data',
        //
        'edit.panel.data.meta' => 'update-meta-data',
        'update.panel.data.meta' => 'update-meta-data',
        //
        'edit.panel:related.data.related' => 'update-related-data',
        'update.panel:related.data.related' => 'update-related-data',
        //
        'edit.panel:single.data.perex' => 'update-perex-data',
        'update.panel:single.data.perex' => 'update-perex-data',
    ];
}
