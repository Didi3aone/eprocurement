<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqDetail extends Model
{
    protected $connection = 'pgsql';
    public $timestamps = false;


    public static function getRfq($materialId, $text = null)
    {
        ini_set('memory_limit', '20000M');
        //ini_set('memory_limit', '-1');
        set_time_limit(0);
        return RfqDetail::join('rfqs','rfqs.rfq_number','=','rfq_details.rfq_number')
        ->select(
            'rfqs.id',
            'rfq_details.material_id',
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
        // ->distinct()
        ->groupBy(
            'rfqs.id',
            'rfq_details.material_id',
            'rfqs.po_number',
            'rfqs.rfq_number',
            'rfqs.vendor_id',
            'rfq_details.net_price',
            'rfq_details.currency',
            'rfqs.is_from_po'
        )
        ->get();
    }

    public static function getLastPo($materialId)
    {
        return RfqDetail::join('rfqs','rfqs.rfq_number','=','rfq_details.rfq_number')
        ->select(
            'rfqs.id',
            'rfq_details.material_id',
            'rfqs.po_number',
            'rfqs.rfq_number',
            'rfqs.vendor_id',
            'rfq_details.net_price',
            'rfq_details.currency',
            'rfqs.is_from_po',
        )
        ->where('material_id', $materialId)
        ->orderBy('rfqs.id','desc')
        // ->distinct()
        ->groupBy(
            'rfqs.id',
            'rfq_details.material_id',
            'rfqs.po_number',
            'rfqs.rfq_number',
            'rfqs.vendor_id',
            'rfq_details.net_price',
            'rfq_details.currency',
            'rfqs.is_from_po'
        )
        ->first();
    }
}
