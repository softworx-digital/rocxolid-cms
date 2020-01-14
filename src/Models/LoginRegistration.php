<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;

/**
 *
 */
class LoginRegistration extends AbstractPageElement
{
    protected $table = 'cms_page_element_login_registration';

    protected $fillable = [
        'web_id',
        'name',
        //
        'login_form_title',
        'login_form_field_email',
        'login_form_field_password',
        'login_form_foot_note',
        'login_form_button',
        'login_form_forgot_password',
        'login_form_forgot_password_page_id',
        'login_form_error',
        'login_form_success',
        //
        'registration_form_title',
        'registration_form_field_type',
        'registration_form_field_type_natural_person',
        'registration_form_field_type_self_employed',
        'registration_form_field_type_legal_entity',
        'registration_form_field_company',
        'registration_form_field_company_registration_number',
        'registration_form_field_tax_id',
        'registration_form_field_vat_number',
        'registration_form_field_name',
        'registration_form_field_name_contact_person',
        'registration_form_field_surname',
        'registration_form_field_surname_contact_person',
        'registration_form_field_phone_number',
        'registration_form_field_email',
        'registration_form_field_password',
        'registration_form_field_password_repeat',
        'registration_form_field_address',
        'registration_form_field_address_detail',
        'registration_form_field_city',
        'registration_form_field_region',
        'registration_form_field_postal_code',
        'registration_form_field_country',
        'registration_form_field_gtc_agreement',
        'registration_form_field_newsletter',
        'registration_form_foot_note',
        'registration_form_button',
        'registration_form_error_company',
        'registration_form_error_company_registration_number_required',
        'registration_form_error_tax_id_required',
        'registration_form_error_vat_number_required',
        'registration_form_error_vat_number_invalid',
        'registration_form_error_name_required',
        'registration_form_error_surname_required',
        'registration_form_error_phone_number_required',
        'registration_form_error_phone_number_invalid',
        'registration_form_error_phone_number_used',
        'registration_form_error_email_required',
        'registration_form_error_email_invalid',
        'registration_form_error_email_used',
        'registration_form_error_password',
        'registration_form_error_gtc_agreement',
        'registration_form_error',
        'registration_form_success',
        'registration_form_success_page_id',
    ];

    protected $relationships = [
        'web',
        'loginFormForgotPasswordPage',
        'registrationFormSuccessPage',
    ];

    public function loginFormForgotPasswordPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function registrationFormSuccessPage()
    {
        return $this->belongsTo(Page::class);
    }
}
