<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
// base contracts
use Softworx\RocXolid\Models\Contracts\Cloneable;
// base models
use Softworx\RocXolid\Models\AbstractCrudModel;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\HasLocalization;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
// cms contracts
use Softworx\RocXolid\CMS\Models\Contracts\PageElementable;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasPageElements;

/**
 *
 */
class PageTemplate extends AbstractCrudModel implements PageElementable, Cloneable
{
    use SoftDeletes;
    use HasWeb;
    use HasLocalization;
    use HasPageElements;
    use UserGroupAssociatedWeb;

    protected $table = 'cms_page_template';

    protected $fillable = [
        'web_id',
        'localization_id',
        //'type',
        'name',
        //'css_class',
        'seo_url_slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'open_graph_title',
        'open_graph_description',
        'open_graph_image',
        'open_graph_type',
        'open_graph_url',
        'open_graph_site_name',
        'description'
    ];

    protected $relationships = [
        'web',
        'localization',
    ];

    protected $pivot_extra = [
        'position',
        'is_clone_page_element_instance',
        //'is_visible',
    ];

    public function beforeSave($data, $action = null)
    {
        $this->seo_url_slug = Str::slug($this->seo_url_slug);

        return $this;
    }
}
