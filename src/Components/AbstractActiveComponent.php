<?php

namespace Softworx\RocXolid\CMS\Components;

use Softworx\RocXolid\Components\AbstractActiveComponent as RocXolidAbstractActiveComponent;

abstract class AbstractActiveComponent extends RocXolidAbstractActiveComponent
{
    protected $view_package = 'rocXolid:cms';

    protected $view_directory = '';
}