<?php

namespace Softworx\RocXolid\CMS\Models;

// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementablePart;
use Softworx\RocXolid\CMS\Models\Page;

/**
 * Page part abstraction.
 * Can be assigned to several pages.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractPagePart extends AbstractElementablePart
{
    /**
     * {@inheritDoc}
     */
    protected static $elementable_type = Page::class;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        'is_bound_to_page',
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    public function isBoundToElementable(): bool
    {
        return $this->is_bound_to_page;
    }
}
