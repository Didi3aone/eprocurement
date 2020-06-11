<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRfqDetail extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_rfqs_details';

    protected $fillable = [
        'id',
        'rfq_id',
        'purchasing_document',
        'item',
        'document_item',
        'deletion_indicator',
        'status',
        'last_changed_on',
        'short_text',
        'material',
        'company_code',
        'plant',
        'storage_location',
        'req_tracking_number',
        'material_group',
        'purchasing_info_rec',
        'supplier_material_number',
        'target_quantity',
        'order_quantity',
        'order_unit',
        'order_price_unit',
        'quantity_conversion',
        'equal_to',
        'denominal',
        'net_order_price',
        'price_unit',
        'net_order_value',
        'gross_order_value',
        'quotation_deadline',
        'gr_processing_time',
        'tax_code',
        'base_unit_of_measures',
        'shipping_intr',
        'oa_target_value',
        'non_deductible',
        'stand_rel_order_qty',
        'price_date',
        'purchasing_doc_category',
        'net_weight',
        'unit_of_weight',
        'material_type',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function vendorDetail()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'vendor');
    }
}