<?php

namespace Softworx\RocXolid\CMS\Components\ModelViewers;

use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;

/**
 *
 */
class CrudModelViewer extends RocXolidCrudModelViewer
{
    protected $view_package = 'rocXolid:cms';

    protected $view_directory = '';

    protected $translation_package = 'rocXolid:cms';
}
