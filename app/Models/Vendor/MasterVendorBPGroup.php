<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorBPGroup extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_bp_group';

    protected $fillable = [
        'code',
        'name'
    ];
}
