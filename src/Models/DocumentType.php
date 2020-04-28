<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Document;

/**
 * Document type model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DocumentType extends AbstractCrudModel
{
    use SoftDeletes;

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
     * Releation to suitable documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class)
            ->where('is_enabled', 1)
            ->where(function ($query) {
                $query
                    ->whereDate('valid_from', '<=', now())
                    ->orWhereNull('valid_from');
            })
            ->where(function ($query) {
                $query
                    ->whereDate('valid_to', '>=', now())
                    ->orWhereNull('valid_to');
            });
    }
}