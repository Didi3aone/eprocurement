<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Vendor extends Authenticatable
{
    protected $connection = 'pgsql';

    use SoftDeletes, Notifiable, HasApiTokens;
    protected $guard = 'vendor';

    protected $fillable = [
        'code',
        'name',
        'address',
        'company_type',
        'company_from',
        'email',
        'npwp',
        'status',
        'country',
        'name1',
        'name2',
        'name3',
        'name4',
        'city',
        'district',
        'po_box',
        'po_box_postal_code',
        'region',
        'search_term',
        'street',
        'first_name',
        'title',
        'house_number',
        'postal_code',
        'country_key',
        'train_station',
        'int_location_no1',
        'int_location_no2',
        'authorization_group',
        'industry',
        'check_digit',
        'data_line',
        'dme_indicator',
        'instruction_key',
        'created_on',
        'created_by',
        'pbc_por_number',
        'group_key',
        'account_group',
        'customer',
        'alternative_payee',
        'central_deletion_flag',
        'central_posting_block',
        'central_purchasing_block',
        'language_key',
        'tax_number1',
        'tax_number2',
        'sales_equalization_tax',
        'liable_for_tax',
        'telebox_number',
        'telephone1',
        'telephone2',
        'fax_number',
        'teletex_number',
        'telex_number',
        'one_time_account',
        'payee_in_document',
        'trading_partner',
        'fiscal_address',
        'vat_registration_no',
        'natural_person',
        'block_function',
        'place_of_birth',
        'date_of_birth',
        'sex',
        'credit_information_number',
        'last_external_review',
        'actual_qm_system',
        'reference_acct_group',
        'po_box_city',
        'plant',
        'vendor_sub_range_relevant',
        'plant_level_relevant',
        'factory_calendar',
        'status_data_transfer',
        'tax_jurisdiction',
        'payment_block',
        'scac',
        'carrier_freight_group',
        'transportation_zone',
        'accts_for_alt_payee',
        'servagntprocgrp',
        'tax_type',
        'tax_number_type',
        'social_insurance',
        'social_ins_code',
        'tax_number3',
        'tax_number4',
        'tax_number5',
        'tax_split',
        'tax_base',
        'profession',
        'stat_grp_service_agent',
        'ext_manufacture',
        'url',
        'name_of_representative',
        'type_of_business',
        'type_of_industry',
        'confirmation_status',
        'confirmation_date',
        'confirmation_time',
        'central_del_block',
        'qm_system_valid_to',
        'relevant_for_pod',
        'tax_office_responsible',
        'tax_number_at_responsible',
        'carrier_confirmation_expected',
        'micro_company',
        'terms_of_liability',
        'crc_number',
        'business_purpose_completed_flag',
        'rg_number',
        'issued_by',
        'state',
        'rg_issuing_date',
        'ric_number',
        'foreign_national_registration',
        'rne_issuing_date',
        'cnae',
        'legal_nature',
        'crt_number',
        'icms_taxprayer',
        'industry_main_type',
        'tax_declaration_type',
        'company_size',
        'declaration_regimen_for_pis',
        'data_element_extensibility_for_supplier',
        'capital_amount',
        'currency',
        'agency_location_code',
        'payment_office',
        'ppa_relevant',
        'processor_group',
        'sla_prepr_proced',
        'date_limit_ext_id',
        'annual_repetition',
        'business_type',
        'partner_trading_name',
        'partner_utr',
        'verification_status',
        'verification_number',
        'tax_status',
        'companies_house_registration_number',
        'ecc_no',
        'excise_registration_no',
        'excise_range',
        'excise_division',
        'excise_commissionerate',
        'cst_number',
        'lst_number',
        'permanent_account_number',
        'exc_tax_ind_vendor',
        'ssi_status',
        'type_of_vendor',
        'cenvat_scheme_participant',
        'change_on',
        'change_by_user',
        'service_tax_registration_number',
        'pan_reference_number',
        'pan_valid_from_date',
        'vendor_for_customs',
        'deductee_reference_number',
        'gst_vendor_classification',
        'public_entity',
        'deed_public_use',
        'social_sec_certificate_valid',
        'social_sec_certificate_submission',
        'cae_code',
        'absence_of_debt',
        'transportation_chain',
        'staging_time',
        'scheduling_procedure',
        'cd_relevant_for_collective_numbering'
    ];

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function department()
    {
        return $this->hasOne(\App\Models\Department::class,'code','department_id');
    }
}
