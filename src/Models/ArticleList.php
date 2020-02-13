<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
// general contracts
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
// general traits
use Softworx\RocXolid\Models\Traits\CanContain;
use Softworx\RocXolid\Models\Traits\IsContained;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasContaineeProxyPage;
// cms models
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Article;

/**
 *
 */
class ArticleList extends AbstractPageElement implements Container, Containee
{
    use CanContain {
        getContainees as protected traitGetContainees;
    }
    use IsContained;
    use HasContaineeProxyPage;

    protected $table = 'cms_page_element_container_article_list';

    protected $fillable = [
        'web_id',
        'container_fill_type',
        'container_auto_order_by_attribute',
        'container_auto_order_by_direction',
        'name',
        'title',
        'text',
        'all',
        'containee_page_proxy_id',
        'containee_button',
        'page_prev',
        'page_next',
    ];

    protected $relationships = [
        'web',
        'containeePageProxy',
    ];

    public function isManualContainerFillType()
    {
        return $this->container_fill_type == 'manual';
    }

    public function getContainees(string $relation_name, $visible_only = true, $paged = false, $page = 1, $per_page = 12): Collection
    {
        if ($this->getModel()->isManualContainerFillType()) {
            return $this->traitGetContainees($relation_name, $visible_only, $paged, $page, $per_page);
        } else {
            $query = Article::query();

            $query->where('localization_id', $this->containeePageProxy->localization->getKey());

            if ($this->container_auto_order_by_attribute) {
                $query->orderBy($this->container_auto_order_by_attribute, $this->container_auto_order_by_direction ?: 'asc');
            }

            if ($visible_only) {
                $query->where('is_enabled', 1);
            }

            if ($paged) {
                $query
                    ->skip(($page - 1) * $per_page)
                    ->take($per_page);
            }

            return $query->get();
        }
    }
}
