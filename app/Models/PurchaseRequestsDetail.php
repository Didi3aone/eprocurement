<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestsDetail extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'id',
        'request_id',
        'description',
        'qty',
        'unit',
        'notes',
        'price',
        'created_at',
        'updated_at'
    ];
}
