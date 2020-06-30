<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'po_no',
        'qty',
        'billing_id',
        'created_at',
        'updated_at',
    ];

    public function billing ()
    {
        return $this->hasOne(\App\Models\Billing::class, 'id', 'billing_id');
    }
}
