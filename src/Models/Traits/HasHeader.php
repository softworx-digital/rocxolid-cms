<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DocumentHeader;

/**
 * Trait for elementable with header.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasHeader
{
    /**
     * Relation to document header.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function header(): BelongsTo
    {
        return $this->belongsTo(DocumentHeader::class, 'document_header_id');
    }

    /**
     * Obtain header with pre-set owner.
     *
     * @return \Softworx\RocXolid\CMS\Models\DocumentHeader|null
     */
    public function getHeader(): ?DocumentHeader
    {
        return optional($this->header)->setOwner($this);
    }

    /**
     * Check if document has a header.
     *
     * @return bool
     */
    public function hasHeader(): bool
    {
        return $this->header()->exists();
    }
}
