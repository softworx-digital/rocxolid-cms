<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Page;

// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\PageViewer;

/**
 * CMS Page controller.
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
    protected static $model_viewer_type = PageViewer::class;

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
        'edit.description-data' => 'update-description',
        'update.description-data' => 'update-description',
        'edit.header' => 'update-header',
        'edit.update' => 'update-header',
        'edit.footer' => 'update-footer',
        'edit.footer' => 'update-footer',
    ];
}
