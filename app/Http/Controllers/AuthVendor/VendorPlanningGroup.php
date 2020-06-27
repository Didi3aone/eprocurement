<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorPlanningGroup extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_planning_group';

    protected $fillable = [
        'code',
        'name'
    ];
}
