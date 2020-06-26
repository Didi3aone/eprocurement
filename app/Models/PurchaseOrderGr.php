<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderGr extends Model
{
    protected $connection = 'pgsql';

    public $table = 'purchase_order_gr';

    protected $fillable = [
        'id',
        'po_no',
        'po_item',
        'vendor_id',
        'movement_type',
        'debet_credit',
        'material_no',
        'qty',
        'amount',
        'plant',
        'storage_location',
        'batch',
        'satuan',
        'currency',
        'doc_gr',
        'tahun_gr',
        'item_gr',
        'reference_document',
        'reference_document_item',
        'material_document',
        'material_doc_item',
        'delivery_completed',
        'gl_account',
        'profit_center',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }
}
