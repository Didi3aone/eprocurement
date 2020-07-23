<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqDetail extends Model
{
    protected $connection = 'pgsql';
    public $timestamps = false;


    public static function getRfq($materialId, $text = null)
    {
        return RfqDetail::join('rfqs','rfqs.rfq_number','=','rfq_details.rfq_number')
        ->select(
            'rfqs.po_number',
            'rfqs.rfq_number',
            'rfqs.vendor_id',
            'rfq_details.net_price',
            'rfq_details.currency',
            'rfqs.is_from_po',
        )
        ->where('material_id', $materialId)
        ->orWhere('short_text', $text)
        ->orderBy('rfqs.id','desc')
        ->get();
    }
}
