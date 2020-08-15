<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class UserVendors extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendors';

    protected $fillable = [
        'code',
        'vendor_title_id',
        'vendor_bp_group_id',
        'specialize',
        'company_name', 
        'different_city',
        'city',
        'postal_code',
        'country',
        'street',
        'street_2',
        'street_3',
        'street_4',
        'street_5',
        'language',
        'office_telephone',
        'telephone_2',
        'telephone_3',
        'office_fax',
        'fax_2',
        'name',
        'email',
        'email_2',
        'password',
        'status',
        'payment_terms',
        'is_export'
    ];

    public function getBpGroup()
    {
        return $this->hasOne(\App\Models\Vendor\MasterVendorBPGroup::class,'id','vendor_bp_group_id');
    }

    public function getTitle()
    {
        return $this->hasOne(\App\Models\Vendor\MasterVendorTitle::class,'id','vendor_title_id');
    }

    public function getTerm()
    {
        return $this->hasOne(\App\Models\Vendor\MasterVendorTermsOfPayment::class,'terms_of_payment_key_id');
    }

    public function getBankDetails()
    {
        return $this->hasOne(\App\Models\Vendor\VendorBankDetails::class,'vendor_id');
    }

    public function getTaxNumber()
    {
        return $this->hasOne(\App\Models\Vendor\VendorTaxNumbers::class,'vendor_id');
    }

    public function getCompanyData()
    {
        return $this->hasMany(\App\Models\Vendor\VendorCompanyData::class,'vendor_id','id');
    }
}
