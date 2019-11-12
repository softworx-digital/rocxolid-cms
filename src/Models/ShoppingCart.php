<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
// common models
use Softworx\RocXolid\Common\Models\Image;
// cms models
use Softworx\RocXolid\CMS\Models\AbstractPageElement,
    Softworx\RocXolid\CMS\Models\Page;
/**
 *
 */
class ShoppingCart extends AbstractPageElement
{
    protected $table = 'cms_page_element_shopping_cart';

    protected $fillable = [
        'web_id',
        'name',
        'title',
        //'subtitle',
        'continue_shopping',
        'continue_shopping_page_id',
        'checkout',
        'checkout_page_id',
        'table_items_product',
        'table_items_quantity',
        'table_items_price_unit_vat',
        'table_items_price_total_vat',
        'discount_price',
        'discount_percent',
        'gift',
        'gift_for_price_above',
        'empty_cart',
        'free_delivery_text',
        'free_delivery_remaining_price',
        'free_delivery_price',
        'free_delivery_already',
        'free_delivery_for_free',
        'coupon_active',
        'coupon_active_clear',
        'coupon_possible',
        'coupon_possible_apply',
        'cart_price_vat',
        'cart_discount',
        'cart_price_total_vat',
        'help_phone_number',
        'help_note',
    ];

    protected $relationships = [
        'web',
        'continueShoppingPage',
        'checkoutPage',
    ];

    public function continueShoppingPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function checkoutPage()
    {
        return $this->belongsTo(Page::class);
    }
}