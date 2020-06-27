<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorBankCountry extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_bank_country';

    protected $fillable = [
        'code',
        'name'
    ];
}
