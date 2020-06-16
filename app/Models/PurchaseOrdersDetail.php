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
        'plant_code',
        'is_assets',
        'assets_no',
        'short_text',
        'text_id',
        'text_form',
        'text_line',
        'delivery_date_category',
        'account_assigment',
        'purchasing_group_code',
        'preq_name',
        'gl_acct_code',
        'cost_center_code',
        'profit_center_code',
        'storage_location',
        'material_group',
        'preq_item',
        'created_at',
        'updated_at'
    ];

    public function po()
    {
        return $this->belongsTo(\App\Models\PurchaseOrder::class,'purchase_order_id');
    }
}
