<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Contracts;

// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;

/**
 * @todo
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface RoutePathParamsProvider
{
    /**
     * @todo
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $elementable
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function addRoutePathParameter(Elementable $elementable): Elementable;
}
