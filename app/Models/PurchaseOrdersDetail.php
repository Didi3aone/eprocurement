<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrdersDetail extends Model
{
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
}
