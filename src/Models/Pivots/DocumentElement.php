<?php

namespace Softworx\RocXolid\CMS\Models\Pivots;

use Softworx\RocXolid\CMS\Models\Pivots\AbstractDocumentElement;
use Softworx\RocXolid\CMS\Models\Document;

/**
 * Cross model to connect document model with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentElement extends AbstractDocumentElement
{
    public function parent()
    {
        return $this->belongsTo(Document::class);
    }
}