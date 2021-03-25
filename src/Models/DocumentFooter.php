<?php

namespace Softworx\RocXolid\CMS\Models;

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
    public function getOwnerRelationName(): string
    {
        return 'footer';
    }
}
