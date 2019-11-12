<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Traits\CanContain;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
/**
 *
 */
class DeliveryList extends AbstractPageElement implements Container
{
    use CanContain;

    protected $table = 'cms_page_element_container_delivery_list';

    protected $fillable = [
        'web_id',
        'name',
        'title',
        'title_note',
        'subtitle',
        'subtitle_note',
        'list',
        'footer',
        'footer_note',
    ];
}