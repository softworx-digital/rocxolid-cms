<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractDocumentPart;

/**
 * Document header model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentHeader extends AbstractDocumentPart
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_document_headers';

    /**
     * {@inheritDoc}
     */
    public function getOwnerRelationName(): string
    {
        return 'header';
    }
}
