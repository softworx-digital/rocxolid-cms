<?php

namespace Softworx\RocXolid\CMS\Components\ModelViewers;

// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\TabbedCrudModelViewer as RocXolidTabbedCrudModelViewer;

/**
 * Model viewer component with integrated tab support for CMS package.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractTabbedCrudModelViewer extends RocXolidTabbedCrudModelViewer
{
    /**
     * @inheritDoc
     */
    protected $view_package = 'rocXolid:cms';
}
