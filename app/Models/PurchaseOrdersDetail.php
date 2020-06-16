<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrdersDetail extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'id',
        'purchase_order_id',
        'description',
        'qty',
        'unit',
        'notes',
        'price',
        'created_at',
        'updated_at'
    ];

    public function po()
    {
        return $this->belongsTo(\App\Models\PurchaseOrder::class,'purchase_order_id');
    }
}
