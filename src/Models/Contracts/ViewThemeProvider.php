<?php

namespace Softworx\RocXolid\CMS\Models\Contracts;

use Illuminate\Support\Collection;

/**
 * Enables model to provide a view theme.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ViewThemeProvider
{
    /**
     * Retrieve view theme for elements.
     *
     * @return string
     */
    public function provideViewTheme(): string;
}