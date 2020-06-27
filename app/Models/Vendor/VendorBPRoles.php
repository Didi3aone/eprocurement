<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorBPRoles extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_bp_roles';

    protected $fillable = [
        'vendor_id',
        'bp_role'
    ];
}
