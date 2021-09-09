<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts as rxContracts;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Article;
// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts as ElementsContracts;
// rocXolid cms elements models traits
use Softworx\RocXolid\CMS\Elements\Models\Traits as ElementsTraits;

/**
 * ArticleCategory model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ArticleCategory extends AbstractCrudModel implements
    rxContracts\Sortable,
    ElementsContracts\PresentationModeProvider
{
    use SoftDeletes;
    use rxTraits\Sortable;
    use ElementsTraits\ProvidesPresentationMode;

    protected $table = 'cms_article_categories';

    protected static $title_column = 'title';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'is_enabled',
        'position',
        // 'icon',
        'title',
        'subtitle',
        'description',
        //'slug',
    ];

    /**
     * {@inheritDoc}
     */
    public function onBeforeSave(Collection $data): Crudable
    {
        $this->slug = Str::slug($this->title);

        return $this;
    }

    /**
     * Relation to Articles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(): Relations\HasMany
    {
        return $this->hasMany(Article::class)->orderBy('position');
    }

    public function getMetaTitle()
    {
        return $this->getTitle();
    }
}
