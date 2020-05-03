<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'id',
        'request_id',
        'bidding',
        'vendor_id',
        'notes',
        'po_date',
        'status',
        'po_no',
        'created_at',
        'updated_at'
    ];

    public function purchaseRequest ()
    {
        return $this->hasOne(\App\Models\PurchaseRequest::class, 'id', 'request_id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'id', 'vendor_id');
    }
}
