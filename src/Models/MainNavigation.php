<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\CanContain;
use Softworx\RocXolid\Models\Traits\IsContained;
// cms models
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\NavigationItem;

/**
 *
 */
class MainNavigation extends AbstractPageElement implements Container, Containee
{
    use CanContain;
    use IsContained;

    protected $table = 'cms_page_element_container_main_navigation';

    protected $fillable = [
        'web_id',
        'name',
    ];

    protected $relationships = [
        'web',
    ];

    protected $containment_ownership = [
        'items' => true,
    ];

    public function getNavigationItem()
    {
        return new NavigationItem();
    }
}
