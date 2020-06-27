<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorTitle extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_title';

    protected $fillable = [
        'code',
        'name'
    ];
}
