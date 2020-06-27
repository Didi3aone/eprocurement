<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorAccountGL extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_account_gl';

    protected $fillable = [
        'code',
        'name'
    ];
}
