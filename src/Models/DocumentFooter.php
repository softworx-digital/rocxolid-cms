<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractDocumentPart;

/**
 * Document footer model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentFooter extends AbstractDocumentPart
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_document_footers';

    /**
     * {@inheritDoc}
     */
    public function getOwnerRelation(): BelongsTo
    {
        return $this->getOwner()->footer();
    }
}
