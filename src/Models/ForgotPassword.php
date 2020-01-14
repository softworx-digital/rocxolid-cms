<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
// common models
use Softworx\RocXolid\Common\Models\Image;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Traits\HasFrontpageUrlAttribute;

class ForgotPassword extends AbstractPageElement
{
    use HasFrontpageUrlAttribute;

    protected $table = 'cms_page_element_forgot_password';

    protected $fillable = [
        'web_id',
        'name',
        'form_title',
        'form_title_note',
        'form_field_email',
        'form_button',
        'form_foot_note',
        'form_error',
        'form_success',
        'reset_page_id',
        'reset_form_title',
        'reset_form_field_new_password',
        'reset_form_field_new_password_repeat',
        'reset_form_button',
        'reset_form_error_password_required',
        'reset_form_error_password_invalid',
        'reset_form_error_user_invalid',
        'reset_form_success',
    ];

    protected $relationships = [
        'web',
        'resetPage',
    ];

    public function resetPage()
    {
        return $this->belongsTo(Page::class);
    }
}
