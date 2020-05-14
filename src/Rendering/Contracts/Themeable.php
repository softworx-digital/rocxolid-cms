<?php

namespace Softworx\RocXolid\CMS\Rendering\Contracts;

use Softworx\RocXolid\Rendering\Contracts\Renderable;

/**
 * Enables object to be theme-rendered at the front-end.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface Themeable extends Renderable
{
    const THEME_PACKAGE = 'themes';

    /**
     * Set a view theme of the themed view package to the component.
     *
     * @param string $directory Directory path to set.
     * @return \Softworx\RocXolid\CMS\Rendering\Contracts\Themeable
     */
    public function setViewTheme(string $theme): Themeable;

    /**
     * Get a view theme of the themed view package of the component.
     *
     * @return string
     */
    public function getViewTheme(): string;

    /**
     * Check if the component has a view theme defined.
     *
     * @return bool
     */
    public function hasViewTheme(): bool;
}
