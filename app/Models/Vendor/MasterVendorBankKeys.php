<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorBankKeys extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_bank_keys';

    protected $fillable = [
        'key',
        'name'
    ];
}
