<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestHistory extends Model
{
    protected $connection = 'pgsql';
    public $table = 'purchase_request_history';

    protected $fillable = [
        'id',
        'purchase_id',
        'material_id',
        'vendor_id',
        'qty',
        'price',
        'created_at',
        'updated_at'
    ];
}
