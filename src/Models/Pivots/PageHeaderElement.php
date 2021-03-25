<?php

namespace Softworx\RocXolid\CMS\Models\Pivots;

// rocXolid cms model pivots
use Softworx\RocXolid\CMS\Models\Pivots\AbstractElementableElement;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\PageHeader;

/**
 * Cross model to connect page header model with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class PageHeaderElement extends AbstractElementableElement
{
    public function parent()
    {
        return $this->belongsTo(PageHeader::class);
    }
}
