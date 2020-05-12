<?php

namespace Softworx\RocXolid\CMS\Components\ModelViewers;

// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\CrudModelViewer;
// rocXolid cms rendering contracts
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;
// rocXolid cms rendering traits
use Softworx\RocXolid\CMS\Rendering\Traits\CanBeThemed;

/**
 * Elementable model viewer.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ElementableModelViewer extends CrudModelViewer implements Themeable
{
    use CanBeThemed;
}
