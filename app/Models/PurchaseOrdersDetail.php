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
        'assets_no',
        'acp_id',                
        'short_text',
        'text_id',
        'text_form',
        'text_line',
        'delivery_date_category',
        'account_assignment',
        'purchasing_group_code',
        'gl_acct_code',
        'cost_center_code',
        'profit_center_code',
        'storage_location',
        'request_no',
        'taxt_code',
        'original_price',
        'currency',
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
