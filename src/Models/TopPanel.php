<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;
/**
 *
 */
class TopPanel extends AbstractPageElement implements Containee
{
    use IsContained;

    protected $table = 'cms_page_element_top_panel';

    protected $fillable = [
        'web_id',
        'login',
        'profile_page_id',
        'logout',
        //'logout_page_id',
        'login_panel',
        'form_field_email',
        'form_field_password',
        'form_error',
        'form_field_remember_me',
        'forgot_password',
        'forgot_password_page_id',
        'button_login',
        'button_register',
        'button_register_page_id',
        'cart',
        'cart_page_id',
        'search',
        'search_page_id',
    ];

    protected $relationships = [
        'web',
        'profilePage',
        //'logoutPage',
        'forgotPasswordPage',
        'buttonRegisterPage',
        'cartPage',
        'searchPage',
    ];

    public function profilePage()
    {
        return $this->belongsTo(Page::class);
    }

    public function logoutPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function forgotPasswordPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function buttonRegisterPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function cartPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function searchPage()
    {
        return $this->belongsTo(Page::class);
    }
}