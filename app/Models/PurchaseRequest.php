<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    public $table = 'purchase_requests';

    public function purchaseDetail()
    {
        return $this->hasMany(\App\Models\PurchaseRequestDetail::class, 'id', 'purchase_id');
    }
}
