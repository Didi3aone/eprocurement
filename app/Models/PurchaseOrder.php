<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'id',
        'request_id',
        'bidding',
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
}
