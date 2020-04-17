<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// base models
use Softworx\RocXolid\Models\AbstractCrudModel;
// common models
use Softworx\RocXolid\Common\Models\Image;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\HasLocalization;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
use Softworx\RocXolid\Common\Models\Traits\HasImage;
// cms contracts
use Softworx\RocXolid\CMS\Models\Contracts\Elementable;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasPageElements;
use Softworx\RocXolid\CMS\Models\Traits\IsProxyPaged;
// cms models
use Softworx\RocXolid\CMS\Models\PageProxy;

/**
 *
 */
class Document extends AbstractCrudModel implements Elementable
{
    use SoftDeletes;
    use HasWeb;
    use HasLocalization;
    use HasPageElements;
    use UserGroupAssociatedWeb;
    // use IsProxyPaged;

    protected $table = 'cms_document';

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

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
