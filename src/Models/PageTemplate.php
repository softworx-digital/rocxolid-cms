<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Cloneable;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;

/**
 * Page template model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class PageTemplate extends AbstractElementable // implements Cloneable
{
    use Traits\HasDependencies;
    use Traits\HasMutators;

    protected $table = 'cms_page_templates';

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

    /*
    protected $pivot_extra = [
        'position',
        'is_clone_page_element_instance',
        //'is_visible',
    ];
    */

    public function beforeSave($data, $action = null)
    {
        $this->seo_url_slug = Str::slug($this->seo_url_slug);

        return $this;
    }

    /**
    * {@inheritDoc}
    */
    public function provideDependencies(bool $sub = false): Collection
    {
        dd('@todo', __METHOD__);

        return collect();
    }

    /**
     * {@inheritDoc}
     */
    public function provideViewTheme(): string
    {
        dd('@todo', __METHOD__);

        return '';
    }
}
