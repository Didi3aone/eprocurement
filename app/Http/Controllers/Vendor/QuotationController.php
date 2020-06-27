<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Models\Vendor\Wholesale;
use App\Models\Vendor;
use App\Models\BiddingHistory;
use SoapClient;
// use Gate;
use Symfony\Component\HttpFoundation\Response;

class QuotationController extends Controller
{
    public function index ()
    {
        $quotation = Quotation::select(
            '*',
            \DB::raw('(
                select count(*) as count 
                from bidding_history 
                where quotation_id = quotation.id 
                    and vendor_id = ' . Auth::user()->id . ' 
                group by quotation_id
            )'),
            'quotation_details.id as detail_id', 'quotation_details.*'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', 'quotation.id')
            ->where('quotation_details.vendor_id', Auth::user()->id)
            ->orderBy('quotation.id', 'desc')
            ->get();

        return view('vendor.quotation.index', compact('quotation'));
    }

    public function online ()
    {
        $quotation = Quotation::select(
            \DB::raw('quotation.id as id'),
            'quotation.status',
            'quotation.model',
            'quotation.po_no',
            'quotation.leadtime_type',
            'quotation.purchasing_leadtime',
            'quotation.start_date',
            'quotation.expired_date',
            'quotation.qty',
            'quotation_details.quotation_order_id',
            \DB::raw('(
                select count(*) as count 
                from bidding_history 
                where quotation_id = quotation.id 
                    and vendor_id = ' . Auth::user()->id . '
                group by quotation_id
            )'),
            'quotation_details.id as detail_id',
            'quotation_details.*'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', 'quotation.id')
            ->where('quotation_details.vendor_id', Auth::user()->code)
            ->where('quotation.status', Quotation::Bidding)
            ->orderBy('quotation.id', 'desc')
            ->get();

        return view('vendor.quotation.online', compact('quotation'));
    }

    public function onlineDetail ($id)
    {
        $quotation = Quotation::select(
            'quotation.id as id',
            'quotation_details.id as detail_id',
            'quotation.status',
            'quotation.po_no',
            'quotation.model',
            'quotation.leadtime_type',
            'quotation.purchasing_leadtime',
            'quotation.target_price',
            'quotation.start_date',
            'quotation.expired_date',
            'quotation.qty'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', '=', 'quotation.id')
            ->where('quotation.id', $id)
            ->first();

        $data = QuotationDetail::where('quotation_order_id', $id)
            ->get();

        return view('vendor.quotation.online-detail', compact('quotation', 'data', 'id'));
    }

    public function repeat ()
    {
        $quotation = Quotation::select(
            'quotation.id',
            'quotation.po_no',
            'quotation.approval_status',
            \DB::raw('sum(quotation_details.qty) as total_qty'),
            \DB::raw('sum(quotation_details.vendor_price) as total_price')
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', '=', 'quotation.id')
            // ->where('quotation_details.vendor_id', Auth::user()->code)
            ->where('quotation.status', 0)
            ->orderBy('quotation.id', 'desc')
            ->groupBy('quotation.id')
            ->get();

        return view('vendor.quotation.repeat', compact('quotation'));
    }

    public function repeatDetail ($id)
    {
        $quotation = Quotation::find($id);

        return view('vendor.quotation.repeat-detail', compact('quotation'));
    }

    public function approveRepeat (Request $request)
    {
        $id = $request->get('id');

        $quotation = Quotation::find($id);
        $vendor_id = @$quotation->vendor_id;
        $vendor = Vendor::find($vendor_id);

        // soap call
        // Testing Alvin, start::
        $wsdl = public_path() . "/xml/zbn_eproc_po.xml";
        
        $username = "IT_02";
        $password = "ademsari";

        $client = new \SoapClient($wsdl, array(
            'login' => $username,
            'password' => $password,
            'trace' => true
        ));

        $auth = ['Username' => $username, 'Password' => $password];
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);

        $params = [];
        $POHEADER = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => 'Z301', // $quotation->doc_type,
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '0003000046', // $vendor ? sprintf('%010d', $vendor->code) : '0003000046',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => '',
            'DSCNT1_TO' => '',
            'DSCNT2_TO' => '',
            'DSCNT3_TO' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'PURCH_ORG' => '',
            'PUR_GROUP' => '',
            'CURRENCY' => 'IDR', // $quotation->currency,
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => '',//'2020-06-12',
            'VPER_START' => '',
            'VPER_END' => '',
            'WARRANTY' => '',
            'QUOTATION' => '',
            'QUOT_DATE' => '',
            'REF_1' => '',
            'SALES_PERS' => '',
            'TELEPHONE' => '',
            'SUPPL_VEND' => '',
            'CUSTOMER' => '',
            'AGREEMENT' => '',
            'GR_MESSAGE' => '',
            'SUPPL_PLNT' => '',
            'INCOTERMS1' => '',
            'INCOTERMS2' => '',
            'COLLECT_NO' => '',
            'DIFF_INV' => '',
            'OUR_REF' => '',
            'LOGSYSTEM' => '',
            'SUBITEMINT' => '',
            'PO_REL_IND' => '',
            'REL_STATUS' => '',
            'VAT_CNTRY' => '',
            'VAT_CNTRY_ISO' => '',
            'REASON_CANCEL' => '',
            'REASON_CODE' => '',
            'RETENTION_TYPE' => '',
            'RETENTION_PERCENTAGE' => '',
            'DOWNPAY_TYPE' => '',
            'DOWNPAY_AMOUNT' => '',
            'DOWNPAY_PERCENT' => '',
            'DOWNPAY_DUEDATE' => '',
            'MEMORY' => '',
            'MEMORYTYPE' => '',
            'SHIPTYPE' => '',
            'HANDOVERLOC' => '',
            'SHIPCOND' => '',
            'INCOTERMSV' => '',
            'INCOTERMS2L' => '',
            'INCOTERMS3L' => '',
            'EXT_SYS' => '',
            'EXT_REF' => ''
        ];
        $params[0]['POHEADER'] = $POHEADER;
        $POHEADERX = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => 'X',
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => 'X',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => '',
            'DSCNT1_TO' => '',
            'DSCNT2_TO' => '',
            'DSCNT3_TO' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'PURCH_ORG' => '',
            'PUR_GROUP' => '',
            'CURRENCY' => 'X',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => '',
            'VPER_START' => '',
            'VPER_END' => '',
            'WARRANTY' => '',
            'QUOTATION' => '',
            'QUOT_DATE' => '',
            'REF_1' => '',
            'SALES_PERS' => '',
            'TELEPHONE' => '',
            'SUPPL_VEND' => '',
            'CUSTOMER' => '',
            'AGREEMENT' => '',
            'GR_MESSAGE' => '',
            'SUPPL_PLNT' => '',
            'INCOTERMS1' => '',
            'INCOTERMS2' => '',
            'COLLECT_NO' => '',
            'DIFF_INV' => '',
            'OUR_REF' => '',
            'LOGSYSTEM' => '',
            'SUBITEMINT' => '',
            'PO_REL_IND' => '',
            'REL_STATUS' => '',
            'VAT_CNTRY' => '',
            'VAT_CNTRY_ISO' => '',
            'REASON_CANCEL' => '',
            'REASON_CODE' => '',
            'RETENTION_TYPE' => '',
            'RETENTION_PERCENTAGE' => '',
            'DOWNPAY_TYPE' => '',
            'DOWNPAY_AMOUNT' => '',
            'DOWNPAY_PERCENT' => '',
            'DOWNPAY_DUEDATE' => '',
            'MEMORY' => '',
            'MEMORYTYPE' => '',
            'SHIPTYPE' => '',
            'HANDOVERLOC' => '',
            'SHIPCOND' => '',
            'INCOTERMSV' => '',
            'INCOTERMS2L' => '',
            'INCOTERMS3L' => '',
            'EXT_SYS' => '',
            'EXT_REF' => ''
        ];
        $params[0]['POHEADERX'] = $POHEADERX;
        $count_data = 2;
        $is_array = $count_data>1?true:false;
        for ($i=0; $i < 2; $i++) { 
            $poLine = 0;
            $schedLine = sprintf('%05d', (10+$i));
            $indexes = $i+1;
            $poItem = sprintf('%05d', (10*$indexes));;
            $POSCHEDULE = [
                "PO_ITEM" => $poItem, //line
                "SCHED_LINE" => $schedLine, // 0001 ++
                "DEL_DATCAT_EXT" => "",
                "DELIVERY_DATE" => "",//delivery date
                "QUANTITY" => "1",// qty
                "DELIV_TIME" => "", 
                "STAT_DATE" => "",
                "PREQ_NO" => "", // kedua no pr di insert
                "PREQ_ITEM" => "", // line 
                "PO_DATE" => "",
                "ROUTESCHED" => "",
                "MS_DATE" => "",
                "MS_TIME" => "",
                "LOAD_DATE" => "",
                "LOAD_TIME" => "",
                "TP_DATE" => "",
                "TP_TIME" => "",
                "GI_DATE" => "",
                "GI_TIME" => "",
                "DELETE_IND" => "",
                "REQ_CLOSED" => "",
                "GR_END_DATE" => "",
                "GR_END_TIME" => "",
                "COM_QTY" => "",
                "COM_DATE" => "",
                "GEO_ROUTE" => "",
                "HANDOVERDATE" => "",
                "HANDOVERTIME" => "",
            ];
            $POSCHEDULEX = [
                "PO_ITEM" => "X",
                "SCHED_LINE" => "X",
                "DEL_DATCAT_EXT" => "",
                "DELIVERY_DATE" => "X",
                "QUANTITY" => "X",
                "DELIV_TIME" => "",
                "STAT_DATE" => "",
                "PREQ_NO" => "X",
                "PREQ_ITEM" => "X",
                "PO_DATE" => "",
                "ROUTESCHED" => "",
                "MS_DATE" => "",
                "MS_TIME" => "",
                "LOAD_DATE" => "",
                "LOAD_TIME" => "",
                "TP_DATE" => "",
                "TP_TIME" => "",
                "GI_DATE" => "",
                "GI_TIME" => "",
                "DELETE_IND" => "",
                "REQ_CLOSED" => "",
                "GR_END_DATE" => "",
                "GR_END_TIME" => "",
                "COM_QTY" => "",
                "COM_DATE" => "",
                "GEO_ROUTE" => "",
                "HANDOVERDATE" => "",
                "HANDOVERTIME" => "",
            ];
            $params[0]['POSCHEDULE'] = $POSCHEDULE;
            $params[0]['POSCHEDULEX'] = $POSCHEDULEX;
            $POITEM = [
                'PO_ITEM' => $poItem,//LINE
                'DELETE_IND' => '',
                'SHORT_TEXT' => '',
                'MATERIAL' => '',
                'MATERIAL_EXTERNAL' => '',
                'MATERIAL_GUID' => '',
                'MATERIAL_VERSION' => '',
                'EMATERIAL' => '',
                'EMATERIAL_EXTERNAL' => '',
                'EMATERIAL_GUID' => '',
                'EMATERIAL_VERSION' => '',
                'PLANT' => '',
                'STGE_LOC' => '',
                'TRACKINGNO' => '',
                'MATL_GROUP' => '',
                'INFO_REC' => '',
                'VEND_MAT' => '',
                'QUANTITY' => '',
                'PO_UNIT' => '',
                'PO_UNIT_ISO' => '',
                'ORDERPR_UN' => '',
                'ORDERPR_UN_ISO' => '',
                'CONV_NUM1' => '',
                'CONV_DEN1' => '',
                'NET_PRICE' => '1000000',//per line
                'PRICE_UNIT' => '',//isi 
                'GR_PR_TIME' => '',
                'TAX_CODE' => 'V1',
                'BON_GRP1' => '',
                'QUAL_INSP' => '',
                'INFO_UPD' => '',
                'PRNT_PRICE' => '',
                'EST_PRICE' => '',
                'REMINDER1' => '',
                'REMINDER2' => '',
                'REMINDER3' => '',
                'OVER_DLV_TOL' => '',
                'UNLIMITED_DLV' => '',
                'UNDER_DLV_TOL' => '',
                'VAL_TYPE' => '',
                'NO_MORE_GR' => '',
                'FINAL_INV' => '',
                'ITEM_CAT' => '',
                'ACCTASSCAT' => '',
                'DISTRIB' => '',
                'PART_INV' => '',
                'GR_IND' => '',
                'GR_NON_VAL' => '',
                'IR_IND' => '',
                'FREE_ITEM' => '',
                'GR_BASEDIV' => '',
                'ACKN_REQD' => '',
                'ACKNOWL_NO' => '',
                'AGREEMENT' => '',
                'AGMT_ITEM' => '',
                'SHIPPING' => '',
                'CUSTOMER' => '',
                'COND_GROUP' => '',
                'NO_DISCT' => '',
                'PLAN_DEL' => '',
                'NET_WEIGHT' => '',
                'WEIGHTUNIT' => '',
                'WEIGHTUNIT_ISO' => '',
                'TAXJURCODE' => '',
                'CTRL_KEY' => '',
                'CONF_CTRL' => '',
                'REV_LEV' => '',
                'FUND' => '',
                'FUNDS_CTR' => '',
                'CMMT_ITEM' => '',
                'PRICEDATE' => '',
                'PRICE_DATE' => '',
                'GROSS_WT' => '',
                'VOLUME' => '',
                'VOLUMEUNIT' => '',
                'VOLUMEUNIT_ISO' => '',
                'INCOTERMS1' => '',
                'INCOTERMS2' => '',
                'PRE_VENDOR' => '',
                'VEND_PART' => '',
                'HL_ITEM' => '',
                'GR_TO_DATE' => '',
                'SUPP_VENDOR' => '',
                'SC_VENDOR' => '',
                'KANBAN_IND' => '',
                'ERS' => '',
                'R_PROMO' => '',
                'POINTS' => '',
                'POINT_UNIT' => '',
                'POINT_UNIT_ISO' => '',
                'SEASON' => '',
                'SEASON_YR' => '',
                'BON_GRP2' => '',
                'BON_GRP3' => '',
                'SETT_ITEM' => '',
                'MINREMLIFE' => '',
                'RFQ_NO' => '',
                'RFQ_ITEM' => '',
                'PREQ_NO' => '1000019608',//pr no jadi 1 dari 2 atau lebih
                'PREQ_ITEM' => '00010',//line
                'REF_DOC' => '',
                'REF_ITEM' => '',
                'SI_CAT' => '',
                'RET_ITEM' => '',
                'AT_RELEV' => '',
                'ORDER_REASON' => '',
                'BRAS_NBM' => '',
                'MATL_USAGE' => '',
                'MAT_ORIGIN' => '',
                'IN_HOUSE' => '',
                'INDUS3' => '',
                'INF_INDEX' => '',
                'UNTIL_DATE' => '',
                'DELIV_COMPL' => '',
                'PART_DELIV' => '',
                'SHIP_BLOCKED' => '',
                'PREQ_NAME' => '',
                'PERIOD_IND_EXPIRATION_DATE' => '',
                'INT_OBJ_NO' => '',
                'PCKG_NO' => '',
                'BATCH' => '',
                'VENDRBATCH' => '',
                'CALCTYPE' => '',
                'GRANT_NBR' => '',
                'CMMT_ITEM_LONG' => '',
                'FUNC_AREA_LONG' => '',
                'NO_ROUNDING' => '',
                'PO_PRICE' => '',
                'SUPPL_STLOC' => '',
                'SRV_BASED_IV' => '',
                'FUNDS_RES' => '',
                'RES_ITEM' => '',
                'ORIG_ACCEPT' => '',
                'ALLOC_TBL' => '',
                'ALLOC_TBL_ITEM' => '',
                'SRC_STOCK_TYPE' => '',
                'REASON_REJ' => '',
                'CRM_SALES_ORDER_NO' => '',
                'CRM_SALES_ORDER_ITEM_NO' => '',
                'CRM_REF_SALES_ORDER_NO' => '',
                'CRM_REF_SO_ITEM_NO' => '',
                'PRIO_URGENCY' => '',
                'PRIO_REQUIREMENT' => '',
                'REASON_CODE' => '',
                'FUND_LONG' => '',
                'LONG_ITEM_NUMBER' => '',
                'EXTERNAL_SORT_NUMBER' => '',
                'EXTERNAL_HIERARCHY_TYPE' => '',
                'RETENTION_PERCENTAGE' => '',
                'DOWNPAY_TYPE' => '',
                'DOWNPAY_AMOUNT' => '',
                'DOWNPAY_PERCENT' => '',
                'DOWNPAY_DUEDATE' => '',
                'EXT_RFX_NUMBER' => '',
                'EXT_RFX_ITEM' => '',
                'EXT_RFX_SYSTEM' => '',
                'SRM_CONTRACT_ID' => '',
                'SRM_CONTRACT_ITM' => '',
                'BUDGET_PERIOD' => '',
                'BLOCK_REASON_ID' => '',
                'BLOCK_REASON_TEXT' => '',
                'SPE_CRM_FKREL' => '',
                'DATE_QTY_FIXED' => '',
                'GI_BASED_GR' => '',
                'SHIPTYPE' => '',
                'HANDOVERLOC' => '',
                'TC_AUT_DET' => '',
                'MANUAL_TC_REASON' => '',
                'FISCAL_INCENTIVE' => '',
                'FISCAL_INCENTIVE_ID' => '',
                'TAX_SUBJECT_ST' => '',
                'REQ_SEGMENT' => '',
                'STK_SEGMENT' => '',
                'SF_TXJCD' => '',
                'INCOTERMS2L' => '',
                'INCOTERMS3L' => '',
                'MATERIAL_LONG' => '',
                'EMATERIAL_LONG' => '',
                'SERVICEPERFORMER' => '',
                'PRODUCTTYPE' => '',
                'STARTDATE' => '',
                'ENDDATE' => '',
                'REQ_SEG_LONG' => '',
                'STK_SEG_LONG' => '',
                'EXPECTED_VALUE' => '',
                'LIMIT_AMOUNT' => '',
                'EXT_REF' => '',
            ];
            $POITEMX = [
                'PO_ITEM' => '00010',
                'PO_ITEMX' => 'X',
                'DELETE_IND' => '',
                'SHORT_TEXT' => '',
                'MATERIAL' => '',
                'MATERIAL_EXTERNAL' => '',
                'MATERIAL_GUID' => '',
                'MATERIAL_VERSION' => '',
                'EMATERIAL' => '',
                'EMATERIAL_EXTERNAL' => '',
                'EMATERIAL_GUID' => '',
                'EMATERIAL_VERSION' => '',
                'PLANT' => '',
                'STGE_LOC' => '',
                'TRACKINGNO' => '',
                'MATL_GROUP' => '',
                'INFO_REC' => '',
                'VEND_MAT' => '',
                'QUANTITY' => '',
                'PO_UNIT' => '',
                'PO_UNIT_ISO' => '',
                'ORDERPR_UN' => '',
                'ORDERPR_UN_ISO' => '',
                'CONV_NUM1' => '',
                'CONV_DEN1' => '',
                'NET_PRICE' => 'X',
                'PRICE_UNIT' => '',
                'GR_PR_TIME' => '',
                'TAX_CODE' => 'X',
                'BON_GRP1' => '',
                'QUAL_INSP' => '',
                'INFO_UPD' => '',
                'PRNT_PRICE' => '',
                'EST_PRICE' => '',
                'REMINDER1' => '',
                'REMINDER2' => '',
                'REMINDER3' => '',
                'OVER_DLV_TOL' => '',
                'UNLIMITED_DLV' => '',
                'UNDER_DLV_TOL' => '',
                'VAL_TYPE' => '',
                'NO_MORE_GR' => '',
                'FINAL_INV' => '',
                'ITEM_CAT' => '',
                'ACCTASSCAT' => '',
                'DISTRIB' => '',
                'PART_INV' => '',
                'GR_IND' => '',
                'GR_NON_VAL' => '',
                'IR_IND' => '',
                'FREE_ITEM' => '',
                'GR_BASEDIV' => '',
                'ACKN_REQD' => '',
                'ACKNOWL_NO' => '',
                'AGREEMENT' => '',
                'AGMT_ITEM' => '',
                'SHIPPING' => '',
                'CUSTOMER' => '',
                'COND_GROUP' => '',
                'NO_DISCT' => '',
                'PLAN_DEL' => '',
                'NET_WEIGHT' => '',
                'WEIGHTUNIT' => '',
                'WEIGHTUNIT_ISO' => '',
                'TAXJURCODE' => '',
                'CTRL_KEY' => '',
                'CONF_CTRL' => '',
                'REV_LEV' => '',
                'FUND' => '',
                'FUNDS_CTR' => '',
                'CMMT_ITEM' => '',
                'PRICEDATE' => '',
                'PRICE_DATE' => '',
                'GROSS_WT' => '',
                'VOLUME' => '',
                'VOLUMEUNIT' => '',
                'VOLUMEUNIT_ISO' => '',
                'INCOTERMS1' => '',
                'INCOTERMS2' => '',
                'PRE_VENDOR' => '',
                'VEND_PART' => '',
                'HL_ITEM' => '',
                'GR_TO_DATE' => '',
                'SUPP_VENDOR' => '',
                'SC_VENDOR' => '',
                'KANBAN_IND' => '',
                'ERS' => '',
                'R_PROMO' => '',
                'POINTS' => '',
                'POINT_UNIT' => '',
                'POINT_UNIT_ISO' => '',
                'SEASON' => '',
                'SEASON_YR' => '',
                'BON_GRP2' => '',
                'BON_GRP3' => '',
                'SETT_ITEM' => '',
                'MINREMLIFE' => '',
                'RFQ_NO' => '',
                'RFQ_ITEM' => '',
                'PREQ_NO' => 'X',
                'PREQ_ITEM' => 'X',
                'REF_DOC' => '',
                'REF_ITEM' => '',
                'SI_CAT' => '',
                'RET_ITEM' => '',
                'AT_RELEV' => '',
                'ORDER_REASON' => '',
                'BRAS_NBM' => '',
                'MATL_USAGE' => '',
                'MAT_ORIGIN' => '',
                'IN_HOUSE' => '',
                'INDUS3' => '',
                'INF_INDEX' => '',
                'UNTIL_DATE' => '',
                'DELIV_COMPL' => '',
                'PART_DELIV' => '',
                'SHIP_BLOCKED' => '',
                'PREQ_NAME' => '',
                'PERIOD_IND_EXPIRATION_DATE' => '',
                'INT_OBJ_NO' => '',
                'PCKG_NO' => '',
                'BATCH' => '',
                'VENDRBATCH' => '',
                'CALCTYPE' => '',
                'NO_ROUNDING' => '',
                'PO_PRICE' => '',
                'SUPPL_STLOC' => '',
                'SRV_BASED_IV' => '',
                'FUNDS_RES' => '',
                'RES_ITEM' => '',
                'GRANT_NBR' => '',
                'FUNC_AREA_LONG' => '',
                'ORIG_ACCEPT' => '',
                'ALLOC_TBL' => '',
                'ALLOC_TBL_ITEM' => '',
                'SRC_STOCK_TYPE' => '',
                'REASON_REJ' => '',
                'CRM_SALES_ORDER_NO' => '',
                'CRM_SALES_ORDER_ITEM_NO' => '',
                'CRM_REF_SALES_ORDER_NO' => '',
                'CRM_REF_SO_ITEM_NO' => '',
                'PRIO_URGENCY' => '',
                'PRIO_REQUIREMENT' => '',
                'REASON_CODE' => '',
                'LONG_ITEM_NUMBER' => '',
                'EXTERNAL_SORT_NUMBER' => '',
                'EXTERNAL_HIERARCHY_TYPE' => '',
                'RETENTION_PERCENTAGE' => '',
                'DOWNPAY_TYPE' => '',
                'DOWNPAY_AMOUNT' => '',
                'DOWNPAY_PERCENT' => '',
                'DOWNPAY_DUEDATE' => '',
                'EXT_RFX_NUMBER' => '',
                'EXT_RFX_ITEM' => '',
                'EXT_RFX_SYSTEM' => '',
                'SRM_CONTRACT_ID' => '',
                'SRM_CONTRACT_ITM' => '',
                'BUDGET_PERIOD' => '',
                'BLOCK_REASON_ID' => '',
                'BLOCK_REASON_TEXT' => '',
                'SPE_CRM_FKREL' => '',
                'DATE_QTY_FIXED' => '',
                'GI_BASED_GR' => '',
                'SHIPTYPE' => '',
                'HANDOVERLOC' => '',
                'TC_AUT_DET' => '',
                'MANUAL_TC_REASON' => '',
                'FISCAL_INCENTIVE' => '',
                'FISCAL_INCENTIVE_ID' => '',
                'TAX_SUBJECT_ST' => '',
                'REQ_SEGMENT' => '',
                'STK_SEGMENT' => '',
                'SF_TXJCD' => '',
                'INCOTERMS2L' => '',
                'INCOTERMS3L' => '',
                'MATERIAL_LONG' => '',
                'EMATERIAL_LONG' => '',
                'SERVICEPERFORMER' => '',
                'PRODUCTTYPE' => '',
                'STARTDATE' => '',
                'ENDDATE' => '',
                'REQ_SEG_LONG' => '',
                'STK_SEG_LONG' => '',
                'EXPECTED_VALUE' => '',
                'LIMIT_AMOUNT' => '',
                'EXT_REF' => '',
            ];
            if ($is_array) {
                $params[0]['POITEM']['item'][$i] = $POITEM;
                $params[0]['POITEMX']['item'][$i] = $POITEMX;
            } else {
                $params[0]['POITEM']['item'][$i] = $POITEM;
                $params[0]['POITEMX']['item'][$i] = $POITEMX;
            }
        }
        $RETURN = [
            "TYPE" => "",
            "ID" => "",
            "NUMBER" => "",
            "MESSAGE" => "",
            "LOG_NO" => "",
            "LOG_MSG_NO" => "",
            "MESSAGE_V1" => "",
            "MESSAGE_V2" => "",
            "MESSAGE_V3" => "",
            "MESSAGE_V4" => "",
            "PARAMETER" => "",
            "ROW" => "",
            "FIELD" => "",
            "SYSTEM" => "0"
        ];
        $params[0]['RETURN'] = $RETURN;
        // dd($params);
        $result = $client->__soapCall('ZFM_WS_PO', $params, NULL, $header);
        dd($result);
        // ::end

        // create po
        $quotation->approval_status = 2;
        $quotation->update();

        \DB::beginTransaction();
        try {
            $po = PurchaseOrder::create([
                'request_id' => $quotation->id,
                'po_date' => date('Y-m-d'),
                'vendor_id' => $quotation->detail[0]->vendor_id,
                'status' => 1,
                'po_no' => $quotation->po_no,
                'PO_NUMBER' => $result->EXPHEADER->PO_NUMBER ?? null,
            ]);

            foreach ($quotation->detail as $det) {
                if (!empty($det->vendor_price)) {
                    $data = [
                        'purchase_order_id'         => $po->id,
                        'description'               => isset($det->description) ?? '-',
                        'qty'                       => $det->qty,
                        'unit'                      => $det->unit,
                        'notes'                     => isset($quotation->notes) ?? '-',
                        'price'                     => $det->vendor_price,
                        'material_id'               => $det->material,
                        'plant_code'                => $det->plant_code,
                        'is_assets'                 => $det->is_assets,
                        'assets_no'                 => $det->assets_no,
                        'short_text'                => $det->short_text,
                        'text_id'                   => $det->text_id,
                        'text_form'                 => $det->text_form,
                        'text_line'                 => $det->text_line,
                        'delivery_date_category'    => $det->delivery_date_category,
                        'account_assignment'        => $det->account_assigment,
                        'purchasing_group_code'     => $det->purchasing_group_code,
                        'preq_name'                 => $det->preq_name,
                        'gl_acct_code'              => $det->gl_acct_code,
                        'cost_center_code'          => $det->cost_center_code,
                        'profit_center_code'        => $det->profit_center_code,
                        'storage_location'          => $det->storage_location,
                        'material_group'            => $det->material_group,
                        'preq_item'                 => $det->preq_item
                    ];

                    $poDetail = PurchaseOrdersDetail::create($data);
                }
            }

            \DB::commit();

            return redirect()->route('vendor.quotation-repeat')->with('status', trans('cruds.quotation.alert_success_quotation'));
        } catch (Exception $e) {
            \DB::rollBack();
        }
    }

    public function direct ()
    {
        $quotation = Quotation::select(
            'quotation.id',
            'quotation.po_no',
            'quotation.approval_status',
            \DB::raw('sum(quotation_details.qty) as total_qty'),
            \DB::raw('sum(quotation_details.vendor_price) as total_price')
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', '=', 'quotation.id')
            ->where('quotation_details.vendor_id', Auth::user()->code)
            ->where('quotation.status', 2)
            ->orderBy('quotation.id', 'desc')
            ->groupBy('quotation.id')
            ->get();

        return view('vendor.quotation.direct', compact('quotation'));
    }

    public function directDetail ($id)
    {
        $quotation = Quotation::find($id);

        return view('vendor.quotation.direct-detail', compact('quotation'));
    }

    public function saveBid (Request $request)
    {
        $target_price = str_replace('.', '', $request->get('target_price'));

        if (empty($request->get('min')))
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Min cannot be zero!');

        if (empty($request->get('max')))
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Max cannot be zero!');

        if (empty($request->get('price')))
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Price cannot be zero!');

        if (empty($request->get('target_price')) && $request->get('model') == 1)
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Price cannot be zero!');

        \DB::beginTransaction();

        $id = $request->get('id');

        try {
            $quotation = Quotation::find($id);
            $quotation->target_price = $target_price;
            $quotation->save();

            $names = $request->get('name');
            $mins = $request->get('min');
            $maxs = $request->get('max');
            $prices = $request->get('price');

            for ($i = 0; $i < count($mins); $i++) {
                $wholesale = new Wholesale();
                $wholesale->quotation_id = $id;
                $wholesale->name = isset($names[$i]) ? $names[$i] : '';
                $wholesale->min = isset($mins[$i]) ? $mins[$i] : '';
                $wholesale->max = isset($maxs[$i]) ? $maxs[$i] : '';
                $wholesale->price = isset($prices[$i]) ? $prices[$i] : '';
                $wholesale->save();
            }

            $vendors = QuotationDetail::where('quotation_order_id', $id)
                ->where('vendor_id', '<>', Auth::user()->id)
                // ->where('vendor_price', $maxPrice)
                ->orderBy('id', 'desc')
                ->get();

            \DB::commit();

            return view('vendor.quotation.bid', compact('quotation', 'vendors'));
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }
    }

    public function bid ($id)
    {
        $quotation = Quotation::find($id);
        $maxPrice = QuotationDetail::where('quotation_order_id', $id)
            ->where('vendor_id', '<>', Auth::user()->id)
            ->whereNotNull('vendor_price')
            ->max('vendor_price');

        $vendors = null;
        
        if (!empty($maxPrice)) {
            $vendors = QuotationDetail::where('quotation_order_id', $id)
                ->where('vendor_id', '<>', Auth::user()->id)
                ->where('vendor_price', $maxPrice)
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('vendor.quotation.bid', compact('quotation', 'vendors'));
    }

    public function store (Request $request)
    {
        $vendor_price = str_replace('.', '', $request->get('vendor_price'));

        if ($vendor_price > $request->get('target_price'))
            return redirect()->route('vendor.quotation-edit', $request->get('id'))
                ->with('error', trans('cruds.quotation.alert_error_price') . ', target price = ' . $request->get('target_price'));

        \DB::beginTransaction();

        try {
            $filename = '';
            
            if ($request->file('upload_file')) {
                $path = 'quotation/';
                $file = $request->file('upload_file');
                
                $filename = $file->getClientOriginalName();
        
                $file->move($path, $filename);
        
                $real_filename = public_path($path . $filename);
            }
    
            $quotation = QuotationDetail::where('quotation_order_id', $request->get('id'))->first();
            $quotation->upload_file = $filename;
            $quotation->vendor_leadtime = $request->get('vendor_leadtime');
            $quotation->vendor_price = $vendor_price;
            $quotation->notes = $request->get('notes');
            $quotation->save();

            $history = new BiddingHistory;
            $history->pr_no = $request->get('po_no');
            $history->vendor_id = Auth::user()->id;
            $history->quotation_id = $request->get('id');
            $history->save();

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('vendor.quotation-online')->with('status', trans('cruds.quotation.alert_success_quotation'));
    }
}