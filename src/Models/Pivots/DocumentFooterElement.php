<?php

namespace Softworx\RocXolid\CMS\Models\Pivots;

use Softworx\RocXolid\CMS\Models\Pivots\AbstractDocumentElement;
use Softworx\RocXolid\CMS\Models\DocumentFooter;

/**
 * Cross model to connect document footer model with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentFooterElement extends AbstractDocumentElement
{
    public function parent()
    {
        return $this->belongsTo(DocumentFooter::class);
    }
}