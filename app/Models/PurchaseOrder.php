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
        'request_date',
        'approval_status',
        'status',
        'created_at',
        'updated_at'
    ];

    public function purchaseRequest ()
    {
        return $this->hasOne(\App\Models\PurchaseRequest::class, 'id', 'request_id');
    }
}
