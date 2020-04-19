<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Illuminate\Support\Collection;

/**
 * Enables models to have elements assigned.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasElements
{
    public function getAvailableElements()
    {
        return $this->getAvailableElementTypes()->map(function ($type) {
            return app($type);
        });
    }

    protected static function getAvailableElementTypes(): Collection
    {
        return collect(config(sprintf('rocXolid.cms.elementable.%s', static::class), config('rocXolid.cms.elementable.default', [])));
    }
}
