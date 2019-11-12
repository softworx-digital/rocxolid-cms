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
use Softworx\RocXolid\CMS\Models\Contracts\PageElementable;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasPageElements;
use Softworx\RocXolid\CMS\Models\Traits\IsProxyPaged;
// cms models
use Softworx\RocXolid\CMS\Models\PageProxy;
/**
 *
 */
class Article extends AbstractCrudModel implements PageElementable
{
    use SoftDeletes;
    use HasImage;
    use HasWeb;
    use HasLocalization;
    use HasPageElements;
    use UserGroupAssociatedWeb;
    use IsProxyPaged;

    protected $table = 'cms_article';

    protected $is_page_element_template_choice_enabled = false;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'web_id',
        'localization_id',
        'date',
        'name',
        //'seo_url_slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'perex',
        //'css_class',
        'is_enabled'
    ];

    protected $relationships = [
        'web',
        'localization',
    ];

    protected $pivot_extra = [
        'position',
        'is_visible',
    ];

    protected $image_dimensions = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'fb' => [ 'width' => 828, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            '828x' => [ 'width' => 828, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            '1920x' => [ 'width' => 1920, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
        ],
        'openGraphImage' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'default' => [ 'width' => 1080, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
    ];

    protected $page_elements_relationships = [
        'texts',
        //'links',
        'galleries',
        'iframeVideos',
    ];

    public static $list_sortable_attributes = [
        'date',
        'id',
        'title',
    ];

    public function getFrontpageUrl($params = [])
    {
        $pattern = (substr($this->seo_url_slug, 0, 1) === '/') ? '//%s%s' : '//%s/%s';

        return sprintf($pattern, $this->web->domain, $this->seo_url_slug);
    }

    public function beforeSave($data, $action = null)
    {
        //$this->seo_url_slug = sprintf('%s/%s', $this->id, Str::slug($this->name));
        $this->seo_url_slug = Str::slug($this->name);

        return $this;
    }

    public function openGraphImage()
    {
        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'openGraphImage')->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }
}