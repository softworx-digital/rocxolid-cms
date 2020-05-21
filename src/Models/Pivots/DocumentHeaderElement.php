<?php

namespace Softworx\RocXolid\CMS\Models\Pivots;

use Softworx\RocXolid\CMS\Models\Pivots\AbstractDocumentElement;
use Softworx\RocXolid\CMS\Models\DocumentHeader;

/**
 * Cross model to connect document header model with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentHeaderElement extends AbstractDocumentElement
{
    public function parent()
    {
        return $this->belongsTo(DocumentHeader::class);
    }
}