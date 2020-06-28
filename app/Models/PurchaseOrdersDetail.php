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
        'material_id',
        'assets_no',
        'preq_item',
        'purchasing_document',
        'PR_NO',
        'qty_gr',
        'qty_outstanding',
        'created_at',
        'updated_at'
    ];

    public function po()
    {
        return $this->belongsTo(\App\Models\PurchaseOrder::class,'purchase_order_id');
    }
}
