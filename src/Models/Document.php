<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractDocument;
use Softworx\RocXolid\CMS\Models\DocumentType;

/**
 * Document model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Document extends AbstractDocument
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_documents';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        'document_type_id',
        'title',
        'theme',
        'valid_from',
        'valid_to',
        'dependencies',
        'description',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
        'documentType'
    ];

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    /**
     * Theme definition for this elementable.
     *
     * @var string
     * @todo: make this not hardcoded
     */
    protected static $theme = 'pdf';

    /**
     * Relation to document type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
