<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid pdf generator contracts
use Softworx\RocXolid\Generators\Pdf\Contracts\PdfDataProvider;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractDocument;
use Softworx\RocXolid\CMS\Models\Document;

/**
 * Document model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentHeader extends AbstractDocument implements PdfDataProvider
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_document_headers';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
        'document'
    ];

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    /**
     * Relation to document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
