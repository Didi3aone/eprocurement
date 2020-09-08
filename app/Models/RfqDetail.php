<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RfqDetail extends Model
{
    protected $connection = 'pgsql';
    public $timestamps = false;


    public static function getRfq($materialId)
    {
        // echo $materialId;die;
        ini_set('memory_limit', '20000M'); 
        //ini_set('memory_limit', '-1');
        set_time_limit(0);
        // return RfqDetail::where('material_id', $materialId)
        //     ->orderBy('id','desc')
        //     ->get();

        // $rfq = RfqDetail::where('material_id', $materialId)
        //     ->orWhere('short_text', $materialId)
        //     ->select(DB::Raw('po_number, rfq_number, net_price, vendor_id, currency, is_from_po'))
        //     ->orderBy('id','desc');
        //     // ->get();

        // $acp = DB::connection('pgsql')
        //         ->table('vw_po_acp')
        //         ->select(DB::Raw('"PO_NUMBER" As po_number, acp_no::integer AS rfq_number,price As net_price, vendor_code As vendor_id, currency,is_winner As is_from_po'))
        //         ->leftJoin('vw_acp_winner', 'vw_po_acp.purchasing_document', '=', 'vw_acp_winner.acp_no')
        //         ->where('vw_acp_winner.material_id', $materialId)
        //         ->unionAll($rfq)
        //         ->get();
        $rfq = DB::connection('pgsql')
            ->select(DB::Raw(
                'select rfq_details.po_number as po,rfq_number, '."''".' as acp,net_price,vendor_id,currency  from rfq_details
                where material_id='."'$materialId'".'	or short_text = '."'$materialId'".'
                union all 
                select purchase_orders."PO_NUMBER" as po, purchase_orders_details.rfq_number, purchase_orders_details.purchasing_document as acp,
                price, purchase_orders.vendor_id, purchase_orders_details.currency
                from purchase_orders
                join purchase_orders_details on purchase_orders_details.purchase_order_id = purchase_orders.id 
                where purchase_orders_details.material_id='."'$materialId'".' or purchase_orders_details.short_text = '."'$materialId'".''
            ));
        // dd($rfq);
        // $c = $acp->union($acp);
        // $rfq->unionAll($acp);
        // $rfq->get();
        
        return $rfq ;
    }

    public static function getLastPo($materialId)
    {
        return RfqDetail::where('material_id', $materialId)
        ->orWhere('short_text', $materialId)
        ->orderBy('id','desc')
        ->first();
    }
}
