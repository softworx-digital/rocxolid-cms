<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

// rocXolid cms models
use Softworx\RocXolid\CMS\Models\PageProxy;

/**
 *
 */
trait HasContaineeProxyPage
{
    /**
     * Identifies proxy page for containees.
     */
    public function containeePageProxy()
    {
        return $this->belongsTo(PageProxy::class);
    }
}
