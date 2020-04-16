<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;

/**
 *
 */
class DocumentType extends AbstractCrudModel
{
    use SoftDeletes;

    protected $table = 'cms_document_type';

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
}