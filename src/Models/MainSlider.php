<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Container,
    Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\CanContain,
    Softworx\RocXolid\Models\Traits\IsContained;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\SliderItem;
/**
 *
 */
class MainSlider extends AbstractPageElement implements Container, Containee
{
    use CanContain;
    use IsContained;

    protected $table = 'cms_page_element_container_main_slider';

    protected $fillable = [
        'web_id',
        'name',
        'heading',
        'text',
    ];

    public function getSliderItem()
    {
        return new SliderItem();
    }
}