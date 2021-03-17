<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid common models
use Softworx\RocXolid\UserManagement\Models\User;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
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
    use rxTraits\Attributes\HasGeneralDataAttributes;
    use CommonTraits\HasImage;
    use Traits\HasDependencies;
    use Traits\HasMutators;

    const GENERAL_DATA_ATTRIBUTES = [
        'is_enabled',
        'web_id',
        'localization_id',
        // 'page_template_id',
        'author_id',
        'date',
        'title',
        // 'path',
    ];

    const META_DATA_ATTRIBUTES = [
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    protected $table = 'cms_articles';

    protected $fillable = [
        'web_id',
        'localization_id',
        // 'author_id',
        'date',
        'title',
        //'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'perex',
        'content',
        //'css_class',
        'is_enabled'
    ];

    protected $dates = [
        'date',
    ];

    protected $image_sizes = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'mid' => [ 'width' => 512, 'height' => 512, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'fb' => [ 'width' => 828, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            '828x' => [ 'width' => 828, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            '1920x' => [ 'width' => 1920, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
        ],
        'headerImage' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'fb' => [ 'width' => 828, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            '828x' => [ 'width' => 828, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            '1920x' => [ 'width' => 1920, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->author()->associate(auth('rocXolid')->user());

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function onBeforeSave(Collection $data): Crudable
    {
        $this->slug = Str::slug($this->title);

        /*
        if (blank($this->meta_title)) {
            $this->meta_title = $this->title;
        }

        if (blank($this->meta_description)) {
            $this->meta_description = strip_tags($this->perex);
        }
        */

        return $this;
    }

    public function headerImage()
    {
        return $this->image('headerImage');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * {@inheritDoc}
    */
    public function provideDependencies(bool $sub = false): Collection
    {
        dd(__METHOD__, '@todo');

        return collect();
    }

    /**
     * {@inheritDoc}
     */
    public function provideViewTheme(): string
    {
        dd(__METHOD__, '@todo');

        return '';
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
}
