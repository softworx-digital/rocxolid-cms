<?php

namespace Softworx\RocXolid\CMS\Components\ModelViewers;

// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\AbstractTabbedCrudModelViewer;
// rocXolid cms rendering contracts
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;
// rocXolid cms rendering traits
use Softworx\RocXolid\CMS\Rendering\Traits\CanBeThemed;

/**
 * Elementable model viewer component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractElementableModelViewer extends AbstractTabbedCrudModelViewer implements Themeable
{
    use CanBeThemed;

    /**
     * @inheritDoc
     */
    protected $tabs = [
        'default',
        'composition',
    ];
}
