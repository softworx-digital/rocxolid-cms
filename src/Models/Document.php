<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid pdf generator contracts
use Softworx\RocXolid\Generators\Pdf\Contracts\PdfDataProvider;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;
use Softworx\RocXolid\CMS\Models\DocumentType;

/**
 * Document model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Document extends AbstractElementable implements PdfDataProvider
{
    use Traits\HasHeader;
    use Traits\HasFooter;
    use Traits\HasDependencies;
    use Traits\HasMutators;
    use Traits\ProvidesViewTheme;

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
     * Relation to document type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * {@inheritDoc}
     */
    public function provideFilename(): string
    {
        return 'document.pdf';
    }
}
