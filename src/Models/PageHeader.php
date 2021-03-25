<?php

namespace Softworx\RocXolid\CMS\Models;

// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractPagePart;

/**
 * Page header model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class PageHeader extends AbstractPagePart
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_page_headers';

    /**
     * {@inheritDoc}
     */
    public function getOwnerRelationName(): string
    {
        return 'header';
    }
}
