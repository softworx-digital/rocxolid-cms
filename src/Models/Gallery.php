<?php

namespace Softworx\RocXolid\CMS\Models;

// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\HasImages;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractPageElement;

/**
 * Gallery page element model definition.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Gallery extends AbstractPageElement
{
    use HasImages;

    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_page_element_gallery';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'web_id',
        'name',
    ];
}
