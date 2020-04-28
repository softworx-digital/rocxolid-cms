<?php

namespace Softworx\RocXolid\CMS\Rendering\Services;

use Softworx\RocXolid\Rendering\Services\RenderingService;
//
use Softworx\RocXolid\Rendering\Contracts\Renderable;

/**
 * Retrieves themed view for given object and view name.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class ThemeRenderingService extends RenderingService
{
    /**
     * {@inheritDoc}
     */
    protected function composePackageViewPath(Renderable $component, string $view_package, string $view_dir, string $view_name): string
    {
        return sprintf('%s::%s.%s.%s', $view_package, $component->getViewTheme(), $view_dir, $view_name);
    }
}
