<?php

namespace Softworx\RocXolid\CMS\Components;

use Softworx\RocXolid\Components\AbstractComponent as RocXolidAbstractComponent;

abstract class AbstractComponent extends RocXolidAbstractComponent
{
    protected $view_package = 'rocXolid:cms';

    protected $view_directory = '';
}
