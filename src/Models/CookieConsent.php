<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;

class CookieConsent extends AbstractPageElement
{
    protected $table = 'cms_page_element_cookie_consent';

    protected $fillable = [
        'web_id',
        'text',
        'more_info',
        'button',
        'modal_title',
        'modal_body',
        'modal_close_button',
    ];
}