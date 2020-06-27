<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class MasterVendorPlanningGroup extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_vendor_planning_group';

    protected $fillable = [
        'code',
        'name'
    ];
}
