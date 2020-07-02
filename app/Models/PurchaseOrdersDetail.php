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
        'material_group',
        'preq_item',
        'purchasing_document',
        'PR_NO',
        'qty_gr',
        'qty_outstanding',
        'acp_id',                
        'short_text',
        'text_id',
        'text_form',
        'text_line',
        'delivery_date_category',
        'account_assignment',
        'purchasing_group_code',
        'preq_name',
        'gl_acct_code',
        'cost_center_code',
        'profit_center_code',
        'storage_location',
        'request_no',
        'tax_code',
        'original_price',
        'currency',
        'item_category',
        'PO_ITEM',
        'package_no',
        'subpackage_no',
        'line_no',
        'is_active',
        'created_at',
        'updated_at',
        'delivery_date',
        'plant_code'
    ];

    public const SERVICE = 9;

    public function po()
    {
        return $this->belongsTo(\App\Models\PurchaseOrder::class,'purchase_order_id');
    }

    public function acp()
    {
        return $this->hasOne(\App\Models\AcpTable::class, 'acp_id');
    }
}
