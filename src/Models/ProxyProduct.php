<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractProxyPageElement;
use Softworx\RocXolid\Commerce\Models\Product;
use Softworx\RocXolid\CMS\Models\Page;
/**
 *
 */
class ProxyProduct extends AbstractProxyPageElement
{
    protected $table = 'cms_page_element_proxy_product';

    public static $model_type = Product::class;

    protected $fillable = [
        'web_id',
        'name',
        'no_images',
        'rating',
        'variants',
        'quantity',
        'sold_out',
        'free_delivery',
        'pieces',
        'price_vat_label',
        'add_to_cart',
        'added_to_cart',
        'continue_shopping',
        'to_cart',
        'cart_page_id',
        'tab_description',
        'tab_reviews',
        'tab_faq',
        'related_products',
        'related_products_button',
        'tab_reviews_add',
        'tab_reviews_form_field_name',
        'tab_reviews_form_field_content',
        'tab_reviews_form_field_content_placeholder',
        'tab_reviews_form_field_rating',
        'tab_reviews_form_button',
        'tab_reviews_login_to_add_review',
        'tab_reviews_no_reviews',
        'tab_faq_no_faqs',
    ];

    protected $relationships = [
        'web',
        'cartPage',
    ];

    public function cartPage()
    {
        return $this->belongsTo(Page::class);
    }
}