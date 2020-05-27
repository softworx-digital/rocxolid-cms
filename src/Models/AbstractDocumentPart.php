<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;
use Softworx\RocXolid\CMS\Models\Document;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;

/**
 * Document part abstraction.
 * Can be assigned to several documents.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractDocumentPart extends AbstractElementable
{
    /**
     * Owning document reference.
     *
     * @var \Softworx\RocXolid\CMS\Models\Document
     */
    protected $document;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        'is_bound_to_document',
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
        'documents'
    ];

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    /**
     * {@inheritDoc}
     */
    protected function getDefaultControllerRouteParams(string $method): array
    {
        return isset($this->document) ? [
            'document_id' => $this->document->getKey()
        ] : [];
    }

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->setOwner(Document::find($data->get('document_id')));

        $this->web()->associate($this->document->web);
        $this->localization()->associate($this->document->localization);

        return $this;
    }

    /**
    * {@inheritDoc}
    */
   public function provideDependencies(): Collection
   {
       return $this->document->provideDependencies();
   }

    /**
    * {@inheritDoc}
    */
   public function provideViewTheme(): string
   {
       return $this->document->provideViewTheme();
   }

    /**
     * Set owning document to be able to provide dependencies for underlying elements.
     *
     * @param \Softworx\RocXolid\CMS\Models\Document $document
     * @return \Softworx\RocXolid\CMS\Models\AbstractDocumentPart
     */
    public function setOwner(Document $document): AbstractDocumentPart
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Set owning document to be able to provide dependencies for underlying elements.
     *
     * @return \Softworx\RocXolid\CMS\Models\Document
     * @throws \RuntimeException
     */
    public function getOwner(): Document
    {
        // @todo: hotfixed as fuck
        if (request()->has('document_id') && ($document = Document::find(request()->get('document_id')))) {
            $this->setOwner($document);
        }

        if (!isset($this->document)) {
            throw new \RuntimeException(sprintf('Owner not yet set to [%s]', get_class($this)));
        }

        return $this->document;
    }

    /**
     * Relation name that document has to its part.
     *
     * @return string
     */
    abstract public function getOwnerRelationName(): string;

    /**
     * Relation that document has to its part.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getOwnerRelation(): BelongsTo
    {
        return $this->getOwner()->{$this->getOwnerRelationName()}();
    }

    /**
     * Relation to documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getDependenciesProvider(): ElementsDependenciesProvider
    {
        return $this->getOwner();
    }

    /**
     * Check if elementable part is bound to document.
     *
     * @return bool
     */
    public function isBoundToDocument(): bool
    {
        return $this->is_bound_to_document;
    }
}
