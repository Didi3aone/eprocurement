<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestsApproval extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'id',
        'nik',
        'approval_position',
        'status',
        'flag',
        'approve_date',
        'created_at',
        'updated_at',
        'purchase_request_id'
    ];

    public function getPurchaseRequest()
    {
        return $this->hasOne(\App\Models\PurchaseRequest::class,'id','purchase_request_id');
    }
}
