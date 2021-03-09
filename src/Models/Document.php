<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\TriggersProvider;
use Softworx\RocXolid\Models\Contracts\Sortable;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid pdf generator contracts
use Softworx\RocXolid\Generators\Pdf\Contracts\PdfDataProvider;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\ViewThemeProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
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
class Document extends AbstractElementable implements
    Sortable,
    PdfDataProvider,
    TriggersProvider,
    ElementsDependenciesProvider,
    ElementsMutatorsProvider,
    ViewThemeProvider
{
    use rxTraits\Sortable;
    use rxTraits\Attributes\HasGeneralDataAttributes;
    use Traits\HasDocumentHeader;
    use Traits\HasDocumentFooter;
    use Traits\HasTriggers;
    use Traits\HasDependencies;
    use Traits\HasMutators;
    use Traits\ProvidesViewTheme;

    const GENERAL_DATA_ATTRIBUTES = [
        'is_enabled',
        'web_id',
        'localization_id',
        'document_type_id',
        'title',
        'theme',
        'valid_from',
        'valid_to',
    ];

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
        'dependencies_filters',
        'triggers',
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
    protected $dates = [
        'valid_from',
        'valid_to',
    ];

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        $this
            ->fillDependencies($data)
            ->fillDependenciesFilters($data)
            ->fillTriggers($data);

        return parent::fillCustom($data);
    }

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
