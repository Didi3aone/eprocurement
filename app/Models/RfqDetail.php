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

        $rfq = RfqDetail::where('material_id', $materialId)
            ->select(DB::Raw('po_number, rfq_number, net_price, vendor_id, currency, is_from_po'))
            ->orderBy('id','desc');
            // ->get();

        $acp = DB::connection('pgsql')
                ->table('vw_po_acp')
                ->select(DB::Raw('"PO_NUMBER" As po_number, acp_no::integer AS rfq_number,price As net_price, vendor_code As vendor_id, currency,is_winner As is_from_po'))
                ->leftJoin('vw_acp_winner', 'vw_po_acp.purchasing_document', '=', 'vw_acp_winner.acp_no')
                ->where('vw_acp_winner.material_id', $materialId)
                ->unionAll($rfq)
                ->get();

        // $c = $acp->union($acp);
        // $rfq->unionAll($acp);
        // $rfq->get();
        
        return $acp ;
    }

    public static function getLastPo($materialId)
    {
        return RfqDetail::where('material_id', $materialId)
        ->orderBy('id','desc')
        ->first();
    }
}
