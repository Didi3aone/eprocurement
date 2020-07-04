<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorCompanyData extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_company_data';

    protected $fillable = [
        'vendor_id',
        'company_code',
        'account_gl',
        'planning_group',
        'payment_terms'
    ];
}
