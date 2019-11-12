<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\Commerce\Models\Order;
use Softworx\RocXolid\Common\Models\Traits\HasImage;
/**
 *
 */
class ShoppingAfter extends AbstractPageElement
{
    use HasImage;

    protected $table = 'cms_page_element_shopping_after';

    private $_order = null;

    protected $fillable = [
        'web_id',
        'name',
        'title',
        'subtitle',
        'invalid_order',
        'home_button',
        'text',
        'form_field_text',
        'form_button',
        'form_error',
        'form_success',
        'fb_link',
    ];

    protected $image_dimensions = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '301x150' => [ 'width' => 301, 'height' => 150, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
        ],
    ];

    public function getOrder($request)
    {
        if (is_null($this->_order))
        {
            if ($this->_order = Order::find($request->input('order_id')))
            {
                $this->_order->load('delivery');
                $this->_order->load('payment');
            }
        }

        return $this->_order;
    }
}