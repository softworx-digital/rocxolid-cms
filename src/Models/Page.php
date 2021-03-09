<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\Cloneable;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\ViewThemeProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;
use Softworx\RocXolid\CMS\Models\PageTemplate;

/**
 * Page model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Page extends AbstractElementable implements
    ElementsDependenciesProvider,
    ElementsMutatorsProvider,
    ViewThemeProvider
{
    use rxTraits\Attributes\HasGeneralDataAttributes;
    use Traits\HasPageHeader;
    use Traits\HasPageFooter;
    use Traits\HasDependencies;
    use Traits\HasMutators;
    use Traits\ProvidesViewTheme;

    const GENERAL_DATA_ATTRIBUTES = [
        'is_enabled',
        'web_id',
        'localization_id',
        // 'page_template_id',
        'name',
        'path',
    ];

    const META_DATA_ATTRIBUTES = [
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_pages';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        // 'page_template_id',
        'name',
        'path',
        'theme',
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

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
        // 'pageTemplate',
    ];

    /**
     * {@inheritDoc}
     */
    protected $image_sizes = [
        'openGraphImage' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 600, 'height' => 600, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'default' => [ 'width' => 1080, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        $this
            ->fillDependencies($data);

        return parent::fillCustom($data);
    }

    // @todo quick'n'dirty
    public function getMetaDataAttributes(bool $keys = false): Collection
    {
        return $keys
            ? collect(static::META_DATA_ATTRIBUTES)
            : collect($this->getAttributes())->only(static::META_DATA_ATTRIBUTES)->sortBy(function ($value, string $field) {
                return array_search($field, static::META_DATA_ATTRIBUTES);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorContentAreaClass(): string
    {
        return 'keditor-rx-page-content-area';
    }



    /*
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

    // @todo revise, find nicer approach
    public function onBeforeSave(Collection $data): Crudable
    {
        // @todo helper
        if ($this->seo_url_slug !== '/') { // homepage
            $this->seo_url_slug = collect(array_filter(explode('/', $this->seo_url_slug)))->map(function ($slug) {
                return Str::slug($slug);
            })->implode('/');
        }

        return parent::onBeforeSave($data);
    }

    public function onCreateAfterSave(Collection $data): Crudable
    {
        $this->assignTemplatePageElements();

        return parent::onCreateAfterSave($data);
    }

    protected function assignTemplatePageElements()
    {
        $clone_log = collect();

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
    */
}
