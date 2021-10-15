<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;
use Softworx\RocXolid\CMS\Models\ArticleCategory;
// rocXolid cms elements traits
use Softworx\RocXolid\CMS\Elements\Models\Traits as ElementsTraits;

/**
 * Article model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 * @todo revise & refactor & doc
 */
class Article extends AbstractElementable
{
    use CommonTraits\HasImage;
    use Traits\HasDependencies;
    use Traits\HasMutators;
    use Traits\ProvidesViewTheme;
    use ElementsTraits\HasBlogRouting;

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    /**
     * {@inheritDoc}
     */
    protected $table = 'cms_articles';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'is_featured',
        'is_newsflash',
        'web_id',
        'localization_id',
        'author_id',
        'article_category_id',
        'date',
        'title',
        'tags',
        //'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'perex',
        'content',
        //'css_class',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
        'related',
    ];

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * {@inheritDoc}
     */
    protected $dates = [
        'date',
    ];

    /**
     * {@inheritDoc}
     */
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
            '1920x' => [ 'width' => 1920, 'height' => 900, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
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

        if (blank($this->meta_title)) {
            $this->meta_title = $this->title;
        }

        if (blank($this->meta_description)) {
            $this->meta_description = strip_tags($this->perex);
        }

        return $this;
    }

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function headerImage(): Relations\MorphOne
    {
        return $this->image('headerImage');
    }

    /**
     * Relation to ArticleCategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleCategory(): Relations\BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    /**
     * Relation to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation to related articles.
     *
     * @Softworx\RocXolid\Annotations\AuthorizedRelation(policy_abilities="['assign']")
     * @return Relations\BelongsToMany
     */
    public function related(): Relations\BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'cms_article_has_related_articles',
            'article_id',
            'related_id'
        );
    }

    public function getMetaTitle()
    {
        return $this->getTitle();
    }

    public function availableLocalizations(): Collection
    {
        return $this->localization ? collect([ $this->localization ]) : $this->web->localizations;
    }

    /**
     * @inheritDoc
     */
    public function getImageUploadTemplateAssignments(Image $image): array
    {
        switch ($image->model_attribute) {
            case 'headerImage':
                return [
                    'size' => '1920x',
                ];
        }

        return [];
    }

    /**
     * Check if Article is featured.
     *
     * @return boolean
     */
    public function isFeatured(): bool
    {
        return $this->is_featured;
    }

    /**
     * Check if Article is a newsflash.
     *
     * @return boolean
     */
    public function isNewsflash(): bool
    {
        return $this->is_newsflash;
    }
}
