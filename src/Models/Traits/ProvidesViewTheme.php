<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

/**
 * Trait for themeable elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait ProvidesViewTheme
{
    /**
     * Provide view theme to underlying elements.
     *
     * @return string
     */
    public function provideViewTheme(): string
    {
        return $this->theme;
    }
}
