<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Traits\CanContain;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;

class RowNavigation extends AbstractPageElement implements Container
{
    use CanContain;

    protected $table = 'cms_page_element_container_row_navigation';

    protected $fillable = [
        'web_id',
        'name',
        'title',
        'title_note',
        //'default_template',
    ];

    protected $containment_ownership = [
        'items' => true,
    ];

    public function getNavigationItem()
    {
        return new NavigationItem();
    }
}
