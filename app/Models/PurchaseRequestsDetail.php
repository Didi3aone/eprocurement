<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestsDetail extends Model
{
    protected $fillable = [
        'id',
        'purchase_id',
        'description',
        'qty',
        'unit',
        'notes',
        'price',
        'created_at',
        'updated_at'
    ];
}
