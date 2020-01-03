<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
//
use Softworx\RocXolid\Models\AbstractCrudModel;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\HasLocalization;

/**
 *
 */
class Faq extends AbstractCrudModel
{
    use SoftDeletes;
    use HasWeb;
    use HasLocalization;

    protected $table = 'cms_faq';

    protected static $title_column = 'question';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'web_id',
        'localization_id',
        'question',
        'bookmark',
        'answer',
        'is_enabled',
    ];

    /**
     * Model system attributes - not to be shown in model viewer.
     *
     * @var array
     */
    protected $system = [
        'id',
        'model_type',
        'model_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $relationships = [
        'web',
        'localization',
    ];
}