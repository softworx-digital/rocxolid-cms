<?php

namespace Softworx\RocXolid\CMS\Support;

use Illuminate\Support\Collection;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;

/**
 * Fakes dependency provider.
 * Serves as default dependencies provider if none yet set durng processing / dsplaying for an element.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class PlaceholderElementableDependencyProvider implements ElementsDependenciesProvider
{
    /**
     * {@inheritDoc}
     */
    public function getAvailableDependencies(): Collection
    {
        return collect();
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(): Collection
    {
        return collect();
    }

    /**
     * {@inheritDoc}
     */
    public function provideViewTheme(): string
    {
        return '';
    }
}