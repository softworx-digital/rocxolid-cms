<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
// common models
use Softworx\RocXolid\Common\Models\Image;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;

class UserProfile extends AbstractPageElement
{
    protected $table = 'cms_page_element_user_profile';

    protected $fillable = [
        'web_id',
        'name',
        'title',
        'subtitle',

        'profile_page_id',

        'profile_data',
        'profile_data_change_button',
        'profile_data_page_id',

        'credentials',
        'credentials_change_button',
        'credentials_page_id',

        'orders_history',
        'orders_history_order_number',
        'orders_history_order_date',
        'orders_history_order_price',
        'orders_history_empty',

        'order_print_invoice',
        'order_show',
        'order_repeat',
        'order_price',
        'order_discount',
        'order_delivery',
        'order_price_final',
        'order_empty',

        'order_item_name',
        'order_item_quantity',
        'order_item_price',

        'profile_form_title_personal',
        'profile_form_field_type',
        'profile_form_field_type_natural_person',
        'profile_form_field_type_self_employed',
        'profile_form_field_type_legal_entity',
        'profile_form_field_company',
        'profile_form_field_company_registration_number',
        'profile_form_field_tax_id',
        'profile_form_field_vat_number',
        'profile_form_field_name',
        'profile_form_field_name_contact_person',
        'profile_form_field_surname',
        'profile_form_field_surname_contact_person',
        'profile_form_field_phone_number',
        'profile_form_field_email',

        'profile_form_title_address',
        'profile_form_field_address',
        'profile_form_field_address_detail',
        'profile_form_field_city',
        'profile_form_field_region',
        'profile_form_field_postal_code',
        'profile_form_field_country',
        'profile_form_field_newsletter',
        'profile_form_button',
        'profile_form_button_back',
        'profile_form_foot_note',

        'profile_form_error_company',
        'profile_form_error_company_registration_number_required',
        'profile_form_error_tax_id_required',
        'profile_form_error_vat_number_required',
        'profile_form_error_vat_number_invalid',
        'profile_form_error_name_required',
        'profile_form_error_surname_required',
        'profile_form_error_phone_number_required',
        'profile_form_error_phone_number_invalid',
        'profile_form_error_phone_number_used',
        'profile_form_error_email_required',
        'profile_form_error_email_invalid',
        'profile_form_error_email_used',

        'profile_form_success',

        'credentials_form_title',
        'credentials_form_field_password',
        'credentials_form_field_password_repeat',
        'credentials_form_button',
        'credentials_form_button_back',
        'credentials_form_foot_note',

        'credentials_form_error_password',

        'credentials_form_success',
    ];

    protected $relationships = [
        'web',
        'profilePage',
        'profileDataPage',
        'credentialsPage',
    ];

    public function profilePage()
    {
        return $this->belongsTo(Page::class);
    }

    public function profileDataPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function credentialsPage()
    {
        return $this->belongsTo(Page::class);
    }
}
