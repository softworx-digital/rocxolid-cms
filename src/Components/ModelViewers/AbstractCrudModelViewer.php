<?php

namespace Softworx\RocXolid\CMS\Components\ModelViewers;

// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;

/**
 * Base component to be used for viewing CRUDable models for CMS package.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractCrudModelViewer extends RocXolidCrudModelViewer
{
    /**
     * @inheritDoc
     */
    protected $view_package = 'rocXolid:cms';
}
