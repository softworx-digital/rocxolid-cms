<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;

class FooterNote extends AbstractPageElement implements Containee
{
    use IsContained;

    protected $table = 'cms_page_element_footer_note';

    protected $fillable = [
        'web_id',
        'first_line',
        'copyright',
    ];
}
