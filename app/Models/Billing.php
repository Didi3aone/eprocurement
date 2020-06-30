<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $connection = 'pgsql';

    public const WaitingApproval = 1;
    public const Approved = 1;

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'vendor_id');
    }

    public function detail ()
    {
        return $this->hasMany(\App\Models\BillingDetail::class, 'billing_id', 'id');
    }

    public function gr ()
    {
        return $this->hasOne(\App\Models\PurchaseOrderGr::class, 'po_no', 'po_no');
    }
}
