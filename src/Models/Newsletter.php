<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;

class Newsletter extends AbstractPageElement
{
    protected $table = 'cms_page_element_newsletter';

    protected $fillable = [
        'web_id',
        'name',
        'text',
        'text_mobile',
        'form_field_email',
        'form_button',
        'form_error',
        'form_success',
    ];
}