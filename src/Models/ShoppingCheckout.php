<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;
/**
 *
 */
class ShoppingCheckout extends AbstractPageElement
{
    protected $table = 'cms_page_element_shopping_checkout';

    protected $fillable = [
        'web_id',
        'name',

        'title',
        'subtitle',

        'cart_empty',

        'cart_page_id',
        'success_page_id',
        'failed_page_id',

        'tab_invoice_title',
        'tab_invoice_already_registered',
        'tab_invoice_login_form_field_email',
        'tab_invoice_login_form_field_password',
        'tab_invoice_login_form_field_remember',
        'tab_invoice_login_form_error',
        'tab_invoice_login_form_button',
        'tab_invoice_login_form_forgot_password',
        'tab_invoice_login_form_forgot_password_page_id',

        'tab_invoice_form_option_guest',
        'tab_invoice_form_option_register',

        'tab_invoice_form_field_type',
        'tab_invoice_form_field_type_natural_person',
        'tab_invoice_form_field_type_self_employed',
        'tab_invoice_form_field_type_legal_entity',
        'tab_invoice_form_field_company',
        'tab_invoice_form_field_company_registration_number',
        'tab_invoice_form_field_tax_id',
        'tab_invoice_form_field_vat_number',
        'tab_invoice_form_field_name',
        'tab_invoice_form_field_name_contact_person',
        'tab_invoice_form_field_surname',
        'tab_invoice_form_field_surname_contact_person',
        'tab_invoice_form_field_phone_number',
        'tab_invoice_form_field_address',
        'tab_invoice_form_field_address_detail',
        'tab_invoice_form_field_city',
        'tab_invoice_form_field_region',
        'tab_invoice_form_field_postal_code',
        'tab_invoice_form_field_country',

        'tab_invoice_form_field_email',
        'tab_invoice_form_field_password',
        'tab_invoice_form_field_password_repeat',

        'tab_invoice_form_field_note',

        'tab_invoice_form_field_option_delivery_invoice',
        'tab_invoice_form_field_option_delivery_other',

        'tab_invoice_delivery_form_field_name',
        'tab_invoice_delivery_form_field_name_contact_person',
        'tab_invoice_delivery_form_field_surname',
        'tab_invoice_delivery_form_field_surname_contact_person',
        'tab_invoice_delivery_form_field_address',
        'tab_invoice_delivery_form_field_address_detail',
        'tab_invoice_delivery_form_field_city',
        'tab_invoice_delivery_form_field_region',
        'tab_invoice_delivery_form_field_postal_code',
        'tab_invoice_delivery_form_field_country',

        'tab_invoice_form_button',
        'tab_invoice_form_error_company',
        'tab_invoice_form_error_company_registration_number_required',
        'tab_invoice_form_error_company_registration_number_invalid',
        'tab_invoice_form_error_tax_id_required',
        'tab_invoice_form_error_vat_number_required',
        'tab_invoice_form_error_vat_number_invalid',
        'tab_invoice_form_error_name_required',
        'tab_invoice_form_error_surname_required',
        'tab_invoice_form_error_phone_number_required',
        'tab_invoice_form_error_phone_number_invalid',
        'tab_invoice_form_error_phone_number_used',
        'tab_invoice_form_error_email_required',
        'tab_invoice_form_error_email_invalid',
        'tab_invoice_form_error_email_used',
        'tab_invoice_form_error_password',
        'tab_invoice_form_error_address_required',
        'tab_invoice_form_error_postal_code_required',
        'tab_invoice_form_error_city_required',
        'tab_invoice_form_error_region_required',
        'tab_invoice_form_error_gtc_agreement',
        'tab_invoice_form_error',

        'tab_payment_delivery_title',
        'tab_payment_delivery_delivery_method_title',
        'tab_payment_delivery_delivery_method_balikomat_address',
        'tab_payment_delivery_delivery_method_parcelshop_address',
        'tab_payment_delivery_error_payment_method_required',
        'tab_payment_delivery_error_delivery_method_required',
        'tab_payment_delivery_error_payment_failed',

        'tab_summary_title',
        'tab_summary_table_column_item',
        'tab_summary_table_column_quantity',
        'tab_summary_table_column_price',
        'tab_summary_table_delivery',
        'tab_summary_table_payment',
        'tab_summary_table_discount',
        'tab_summary_table_price_total_vat',
        'tab_summary_form_field_gtc_agreement',
        'tab_summary_form_field_privacy_agreement',
        'tab_summary_form_field_newsletter_registration',
        'tab_summary_form_foot_note',
        'tab_summary_form_button',
        'tab_summary_form_error_gtc_agreement_required',
        'tab_summary_form_error_privacy_agreement_required',

        'gtc',
        'privacy',
    ];

    protected $relationships = [
        'web',
        'cartPage',
        'successPage',
        'failedPage',
        'tabInvoiceLoginFormForgotPasswordPage',
    ];

    public function cartPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function successPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function failedPage()
    {
        return $this->belongsTo(Page::class);
    }

    public function tabInvoiceLoginFormForgotPasswordPage()
    {
        return $this->belongsTo(Page::class);
    }
}