<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
// general contracts
use Softworx\RocXolid\Models\Contracts\Container,
    Softworx\RocXolid\Models\Contracts\Containee;
// general traits
use Softworx\RocXolid\Models\Traits\CanContain,
    Softworx\RocXolid\Models\Traits\IsContained;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasContaineeProxyPage;
// cms models
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
// commerce models
use Softworx\RocXolid\Commerce\Models\Product,
    Softworx\RocXolid\Commerce\Models\ProductCategory;
/**
 *
 */
class ProductList extends AbstractPageElement implements Container, Containee
{
    use CanContain {
        getContainees as protected traitGetContainees;
    }
    use IsContained;
    use HasContaineeProxyPage;

    protected $table = 'cms_page_element_container_product_list';

    protected $fillable = [
        'web_id',
        'product_category_id',
        'container_fill_type',
        'container_auto_order_by_attribute',
        'container_auto_order_by_direction',
        'name',
        'title',
        'text',
        'all_products',
        'containee_page_proxy_id',
        'containee_button',
        'containee_price_vat_label',
        'page_prev',
        'page_next',

    ];

    protected $relationships = [
        'web',
        'productCategory',
        'containeePageProxy',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function isManualContainerFillType()
    {
        return $this->container_fill_type == 'manual';
    }

    public function getContainees(string $relation_name, $visible_only = false, $paged = false, $page = 1, $per_page = 12): Collection
    {
        if ($this->getModel()->isManualContainerFillType())
        {
            return $this->traitGetContainees($relation_name, $visible_only, $paged, $page, $per_page);
        }
        else
        {
            $query = Product::query();

            if ($this->container_auto_order_by_attribute)
            {
                $query->orderBy($this->container_auto_order_by_attribute, $this->container_auto_order_by_direction ?: 'asc');
            }

            if ($visible_only)
            {
                $query->where('is_visible', 1);
            }

            if ($this->productCategory()->exists())
            {
                $query->where('product_category_id', $this->productCategory->id);
            }

            if ($paged)
            {
                $query
                    ->skip(($page - 1) * $per_page)
                    ->take($per_page);
            }

            return $query->get();
        }
    }
}