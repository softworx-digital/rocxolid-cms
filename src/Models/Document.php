<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
class Document extends AbstractElementable
{
    protected $is_page_element_template_choice_enabled = false;

    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        'document_type_id',
        'valid_from',
        'valid_to',
        'name',
    ];

    protected $relationships = [
        'web',
        'localization',
        'documentType'
    ];

    protected $pivot_extra = [
        'position',
        'is_visible',
    ];

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
