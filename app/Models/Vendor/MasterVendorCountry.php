<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorCountry extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_country';

    protected $fillable = [
        'code',
        'name'
    ];
}
