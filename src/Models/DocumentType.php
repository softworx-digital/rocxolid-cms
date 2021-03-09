<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Sortable;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Document;

/**
 * Document type model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentType extends AbstractCrudModel implements Sortable
{
    use SoftDeletes;
    use rxTraits\Sortable;

    protected $table = 'cms_document_types';

    protected static $title_column = 'title';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'is_enabled',
        'icon',
        'title',
        'description',
    ];

    protected $relationships = [
    ];

    /**
     * Relation to suitable documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        $user = auth('rocXolid')->user();
        $query = $this->hasMany(Document::class);

        if (!$user->can('viewAnyAll', Document::make())) {
            $query->where('is_enabled', 1);
        }

        return $query
            ->where(function ($query) {
                $query
                    ->whereDate('valid_from', '<=', now())
                    ->orWhereNull('valid_from');
            })
            ->where(function ($query) {
                $query
                    ->whereDate('valid_to', '>=', now())
                    ->orWhereNull('valid_to');
            })->orderBy('position');
    }

    /**
     * Relation to all assigned documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allDocuments()
    {
        return $this->hasMany(Document::class)->orderBy('position');
    }
}
