<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\HasImage;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;
// rocXolid cms model traits
use Softworx\RocXolid\CMS\Models\Traits\IsProxyPaged;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;

/**
 * Article model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Article extends AbstractElementable
{
    use HasImage;
    use IsProxyPaged;

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

    protected $pivot_extra = [
        'position',
        'is_visible',
    ];

    protected $image_sizes = [
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
        //$this->seo_url_slug = sprintf('%s/%s', $this->getKey(), Str::slug($this->name));
        $this->seo_url_slug = Str::slug($this->name);

        return $this;
    }

    public function openGraphImage()
    {
        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'openGraphImage')->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }
}
