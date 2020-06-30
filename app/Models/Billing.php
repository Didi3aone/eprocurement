<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    public const WaitingApproval = 1;
    public const Approved = 1;

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'vendor_id');
    }
}
