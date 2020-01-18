<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// base contracts
use Softworx\RocXolid\Models\Contracts\Cloneable;
// base models
use Softworx\RocXolid\Models\AbstractCrudModel;
// common models
use Softworx\RocXolid\Common\Models\Image;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\HasLocalization;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
// cms contracts
use Softworx\RocXolid\CMS\Models\Contracts\PageElementable;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasPageElements;
// cms models
use Softworx\RocXolid\CMS\Models\PageTemplate;

/**
 *
 */
class Page extends AbstractCrudModel implements PageElementable, Cloneable
{
    use SoftDeletes;
    use HasWeb;
    use HasLocalization;
    use HasPageElements;
    use UserGroupAssociatedWeb;

    protected $table = 'cms_page';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'web_id',
        'localization_id',
        'page_template_id',
        'name',
        //'css_class',
        'seo_url_slug',
        //'is_enabled',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'open_graph_title',
        'open_graph_description',
        //'open_graph_image', // relation
        'open_graph_type',
        'open_graph_url',
        'open_graph_site_name',
        'description'
    ];

    protected $relationships = [
        'web',
        'localization',
        'pageTemplate',
    ];

    protected $pivot_extra = [
        'position',
        'is_visible',
    ];

    protected $image_sizes = [
        'openGraphImage' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 600, 'height' => 600, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'default' => [ 'width' => 1080, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
    ];

    public function pageTemplate()
    {
        return $this->belongsTo(PageTemplate::class);
    }

    public function getFrontpageUrl($params = [])
    {
        if ($this->seo_url_slug === '/') { // homepage
            $pattern = $this->localization->is($this->web->defaultLocalization) ? '//%s' : '//%s/%s';

            return sprintf($pattern, $this->web->domain, $this->localization->seo_url_slug);
        }

        return sprintf('//%s/%s/%s', $this->web->domain, $this->localization->seo_url_slug, $this->seo_url_slug);
    }

    public function beforeSave($data, $action = null)
    {
        if ($this->seo_url_slug !== '/') { // homepage
            $this->seo_url_slug = collect(array_filter(explode('/', $this->seo_url_slug)))->map(function ($slug) {
                return Str::slug($slug);
            })->implode('/');
        }

        return $this;
    }

    public function afterSave($data, $action = null)
    {
        if ($action == 'create') {
            $this->assignTemplatePageElements();
        }

        return $this;
    }

    protected function assignTemplatePageElements()
    {
        $clone_log = new Collection();

        if ($this->pageTemplate()->exists()) {
            foreach ($this->pageTemplate->pageElements() as $page_element) {
                if ($page_element->getPivotData()->get('is_clone_page_element_instance')) {
                    $clone = $page_element->clone($clone_log);

                    $this->addPageElement($clone);
                } else {
                    $this->addPageElement($page_element->cloneContaineeRelations($this->pageTemplate, $this));
                }
            }
        }

        return $this;
    }

    public function openGraphImage()
    {
        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'openGraphImage')->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }
}
