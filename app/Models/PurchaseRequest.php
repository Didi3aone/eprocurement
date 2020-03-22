<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'id',
        'request_no',
        'notes',
        'request_date',
        'total',
        'approval_status',
        'status',
        'created_at',
        'updated_at'
    ];
    
    public function purchaseDetail()
    {
        return $this->hasMany(\App\Models\PurchaseRequestsDetail::class, 'id', 'purchase_id');
    }
}
