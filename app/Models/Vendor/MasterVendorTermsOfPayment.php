<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorTermsOfPayment extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_terms_of_payment';

    protected $fillable = [
        'code',
        'number_of_days',
        'description'
    ];
}
