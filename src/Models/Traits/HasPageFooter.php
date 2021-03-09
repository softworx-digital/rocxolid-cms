<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\PageFooter;

/**
 * Trait for elementable with footer.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasPageFooter
{
    /**
     * Relation to page footer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function footer(): BelongsTo
    {
        return $this->belongsTo(PageFooter::class, 'page_footer_id');
    }

    /**
     * Obtain footer with pre-set owner.
     *
     * @return \Softworx\RocXolid\CMS\Models\PageFooter|null
     */
    public function getFooter(): ?PageFooter
    {
        return optional($this->footer)->setOwner($this);
    }

    /**
     * Check if page has a footer.
     *
     * @return bool
     */
    public function hasFooter(): bool
    {
        return $this->footer()->exists();
    }
}
