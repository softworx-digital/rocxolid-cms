<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
// common models
use Softworx\RocXolid\Common\Models\Image;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;

class Contact extends AbstractPageElement
{
    protected $table = 'cms_page_element_contact';

    protected $fillable = [
        'web_id',
        'name',
        'title',
        'subtitle',
        'text',
        'phone',
        'phone_value',
        'email',
        'email_value',
        'address',
        'address_value',
        'address_map_iframe',
        'form_field_name',
        'form_field_email',
        'form_field_message',
        'form_field_button',
        'form_success',
        'form_error_name_required',
        'form_error_email_required',
        'form_error_email_invalid',
        'form_error_message_required',
    ];
}