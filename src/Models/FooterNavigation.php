<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
use Softworx\RocXolid\Common\Models\Traits\HasImage;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasProxyPageLink;;
/**
 *
 */
class FooterNavigation extends AbstractPageElement implements Containee
{
    use HasImage;
    use HasProxyPageLink;
    use IsContained;

    protected $table = 'cms_page_element_footer_navigation';

    protected $fillable = [
        'name',
        'web_id',
        //'delivery',
        //'delivery_page_id',
        'gtc',
        'gtc_page_id',
        'privacy',
        'privacy_page_id',
    ];

    protected $relationships = [
        'web',
        //'deliveryPage',
        'gtcPage',
        'privacyPage',
    ];

    protected $image_dimensions = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '100x25' => [ 'width' => 100, 'height' => 25, 'method' => 'fit', 'constraints' => [ ], ],
        ],
    ];

    public function deliveryPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function gtcPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function privacyPage()
    {
        return $this->belongsTo(Page::class);
    }
}