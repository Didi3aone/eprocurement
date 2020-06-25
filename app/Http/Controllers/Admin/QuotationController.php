<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan, Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Models\Vendor\QuotationApproval;
use App\Models\PurchaseRequestsDetail;
use App\Models\PurchaseRequestHistory;
use App\Models\PurchaseOrder;
use App\Models\MasterRfq;
use App\Models\Vendor;
use App\Mail\PurchaseOrderMail;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('quotation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation = Quotation::orderBy('id', 'desc')
                    ->groupBy('id', 'request_id')
                    ->get();

        return view('admin.quotation.index', compact('quotation'));
    }

    public function show(){}

    public function online ()
    {
        $quotation = Quotation::where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.quotation.online', compact('quotation'));
    }

    public function repeat ()
    {
        $quotation = Quotation::where('status', Quotation::Waiting)
                ->orderBy('id', 'desc')
                ->get();

        return view('admin.quotation.repeat', compact('quotation'));
    }

    public function direct ()
    {
        $quotation = Quotation::where('status', 2)
                ->orderBy('id', 'desc')
                ->get();

        return view('admin.quotation.index', compact('quotation'));
    }

    private function _send_sap_po_repeat($id) 
    {
        $quotation = Quotation::find($id);
        $quotation_detail = QuotationDetail::where('quotation_order_id', $id)->get();
        $vendor_id = @$quotation->vendor_id;
        // $vendor = Vendor::find($vendor_id);

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
            'DOC_TYPE' => $quotation->doc_type, // Z301
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '0003000046', // $vendor_id ? sprintf('%010d', $vendor_id) : '0003000046',
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
            'CURRENCY' => $quotation->currency ?? 'IDR',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => '', //'2020-06-12',
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
        $count_ = count($quotation_detail);
        $is_array = ((int)$count_) > 1 ? true : false;
        $pr_no = '1000004218'; // temp
        // $count_ = 1; // temp
        // $is_array = false; // temp
        for ($i=0; $i < $count_; $i++) { 
            // $po_index = sprintf('%05d', (10+$i));
            $indexes = $i+1;
            $po_index = sprintf('%05d', (10*$indexes));
            $POITEM = [
                'PO_ITEM' => $po_index, //LINE
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
                'NET_PRICE' => $quotation_detail[$i]->price ?? '1000000',
                'PRICE_UNIT' => '',
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
                'PREQ_NO' => $pr_no, // $quotation_detail[$i]->PR_NO ?? 0, // '1000019608',
                'PREQ_ITEM' => $po_index,
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
                // 'ALLOC_TBL_ITEM' => '',
                // 'SRC_STOCK_TYPE' => '',
                // 'REASON_REJ' => '',
                // 'CRM_SALES_ORDER_NO' => '',
                // 'CRM_SALES_ORDER_ITEM_NO' => '',
                // 'CRM_REF_SALES_ORDER_NO' => '',
                // 'CRM_REF_SO_ITEM_NO' => '',
                // 'PRIO_URGENCY' => '',
                // 'PRIO_REQUIREMENT' => '',
                // 'REASON_CODE' => '',
                // 'FUND_LONG' => '',
                // 'LONG_ITEM_NUMBER' => '',
                // 'EXTERNAL_SORT_NUMBER' => '',
                // 'EXTERNAL_HIERARCHY_TYPE' => '',
                // 'RETENTION_PERCENTAGE' => '',
                // 'DOWNPAY_TYPE' => '',
                // 'DOWNPAY_AMOUNT' => '',
                // 'DOWNPAY_PERCENT' => '',
                // 'DOWNPAY_DUEDATE' => '',
                // 'EXT_RFX_NUMBER' => '',
                // 'EXT_RFX_ITEM' => '',
                // 'EXT_RFX_SYSTEM' => '',
                // 'SRM_CONTRACT_ID' => '',
                // 'SRM_CONTRACT_ITM' => '',
                // 'BUDGET_PERIOD' => '',
                // 'BLOCK_REASON_ID' => '',
                // 'BLOCK_REASON_TEXT' => '',
                // 'SPE_CRM_FKREL' => '',
                // 'DATE_QTY_FIXED' => '',
                // 'GI_BASED_GR' => '',
                // 'SHIPTYPE' => '',
                // 'HANDOVERLOC' => '',
                // 'TC_AUT_DET' => '',
                // 'MANUAL_TC_REASON' => '',
                // 'FISCAL_INCENTIVE' => '',
                // 'FISCAL_INCENTIVE_ID' => '',
                // 'TAX_SUBJECT_ST' => '',
                // 'REQ_SEGMENT' => '',
                // 'STK_SEGMENT' => '',
                // 'SF_TXJCD' => '',
                // 'INCOTERMS2L' => '',
                // 'INCOTERMS3L' => '',
                // 'MATERIAL_LONG' => '',
                // 'EMATERIAL_LONG' => '',
                // 'SERVICEPERFORMER' => '',
                // 'PRODUCTTYPE' => '',
                // 'STARTDATE' => '',
                // 'ENDDATE' => '',
                // 'REQ_SEG_LONG' => '',
                // 'STK_SEG_LONG' => '',
                // 'EXPECTED_VALUE' => '',
                // 'LIMIT_AMOUNT' => '',
                // 'EXT_REF' => '',
            ];
            $POITEMX = [
                'PO_ITEM' => $po_index,
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
                // 'REQ_SEGMENT' => '',
                // 'STK_SEGMENT' => '',
                // 'SF_TXJCD' => '',
                // 'INCOTERMS2L' => '',
                // 'INCOTERMS3L' => '',
                // 'MATERIAL_LONG' => '',
                // 'EMATERIAL_LONG' => '',
                // 'SERVICEPERFORMER' => '',
                // 'PRODUCTTYPE' => '',
                // 'STARTDATE' => '',
                // 'ENDDATE' => '',
                // 'REQ_SEG_LONG' => '',
                // 'STK_SEG_LONG' => '',
                // 'EXPECTED_VALUE' => '',
                // 'LIMIT_AMOUNT' => '',
                // 'EXT_REF' => '',
            ];
            if ($is_array) {
                $params[0]['POITEM']['item'][$i] = $POITEM;
                $params[0]['POITEMX']['item'][$i] = $POITEMX;
            } else {
                $params[0]['POITEM']['item'] = $POITEM;
                $params[0]['POITEMX']['item'] = $POITEMX;
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
        // dd($result);
        // ::end

        $PO_NUMBER = $result->EXPHEADER->PO_NUMBER ?? null;
        if (!$PO_NUMBER)
            return false;

        $this->_approval_po_repeat($quotation, $quotation_detail, $PO_NUMBER);
    }

    private function _approval_po_repeat($quotation, $quotation_detail, $PO_NUMBER)
    {
        // quotation approve
        $q_update = Quotation::where('id', $quotation->id)->update(['approval_status' => 2]);
        if (!$q_update)
            return false;

        // create po
        $data_po = [
            'request_id' => $quotation->id,
            'po_date' => date('Y-m-d'),
            'vendor_id' => $quotation->vendor_id,
            'status' => 1,
            'po_no' => $quotation->po_no,
            'PO_NUMBER' => $PO_NUMBER,
        ];
        $po_insert = PurchaseOrder::create($data_po);
        if (!$po_insert)
            return false;

        foreach ($quotation_detail as $det) {
            if (!empty($det->vendor_price)) {
                $data_po_detail = [
                    'purchase_order_id'         => $po_insert->id,
                    'description'               => $det->notes ?? '-',
                    'qty'                       => $det->qty,
                    'unit'                      => $det->unit,
                    'notes'                     => $quotation->notes ?? '-',
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

                $poDetail = PurchaseOrdersDetail::create($data_po_detail);
                if (!$poDetail)
                    return false;
            }
        }

        return true;
    }

    public function repeat_approve (Request $request, $ids)
    {
        $ids = base64_decode($ids);
        $ids = explode(',', $ids);
        \DB::beginTransaction();
        try {
            foreach ($ids as $i => $id) {
                $approve = $this->_send_sap_po_repeat($id);
                if ($approve===false)
                    throw new Exception("Invalid Request");
            }
            \DB::commit();
            return redirect()->route('admin.quotation.repeat')->with('status', 'Success processing');
        } catch (Exception $e) {
            \DB::rollBack();
            return redirect()->route('admin.quotation.repeat')->with('error', 'Somethig error proccessing :(');
        }
    }

    public function saveOnline (Request $request)
    {
        if ($request->get('search-vendor') == '-- Select --')
            return redirect()->route('admin.purchase-request-online', [$request->get('id'), $request->get('quantities')])->with('status', 'No vendor chosen!');

        $vendors = $request->get('vendor_id');

        if (empty($vendors))
            return redirect()->route('admin.purchase-request-online', [$request->get('id'), $request->get('quantities')])->with('status', 'No vendors selected!');

        \DB::beginTransaction();

        try {
            $net_price = $request->get('net_price');
            if ($request->input('model') == 0)
                for ($i = 0; $i < count($net_price); $i++)
                    if (empty($net_price[$i]))
                        return redirect()->route('admin.purchase-request-online', [$request->get('id'), $request->get('quantities')])->with('status', 'Net price cannot be zero!');
                        
            $quotation = new Quotation;
            $quotation->po_no               = $request->get('PR_NO');
            $quotation->model               = $request->get('model');
            $quotation->leadtime_type       = $request->get('leadtime_type');
            $quotation->purchasing_leadtime = $request->get('purchasing_leadtime');
            $quotation->start_date          = $request->get('start_date');
            $quotation->expired_date        = $request->get('expired_date');
            $quotation->status              = 1;
            $quotation->save();
            
            $quotation_ids = [];
            foreach ($vendors as $key => $val) {
                $quotationDetail = new QuotationDetail;
                $quotationDetail->quotation_order_id = $quotation->id;
                $quotationDetail->vendor_id = $val;
                $quotationDetail->flag = 0;
                $quotationDetail->save();

                array_push($quotation_ids, $quotationDetail->id);
            }

            for ($i = 0; $i < count($net_price); $i++) {
                if ($net_price[$i]) {
                    $detail = QuotationDetail::find($quotation_ids[$i]);
                    $detail->price = $net_price[$i];
                    $detail->save();
                }
            }
                        
            // if( $price <= 25000000 ) {
            //     $tingkat = 'STAFF';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // } else if( $price > 25000000 && $price < 100000000) {
            //     $tingkat = 'CMO';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // } else if( $price > 100000000 && $price <= 250000000) {
            //     $tingkat = 'CFO';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // } else if( $price > 250000000) {
            //     $tingkat = 'COO';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // }

            \DB::commit();

            return redirect()->route('admin.quotation.online')->with('status', trans('cruds.purchase-order.alert_success_insert'));
        } catch (Exception $e) {
            \DB::rollBack();
    
            return redirect()->route('admin.quotation.online')->with('error', trans('cruds.purchase-order.alert_error_insert'));
        }
    }

    public function saveRepeat (Request $request)
    {
        $qty = 0;
        $price = 0;
        $details = [];
        for ($i = 0; $i < count($request->get('qty')); $i++) {
            $qy = str_replace('.', '', $request->get('qty')[$i]);
            $qty += $qy;

            // update material qty
            $material = PurchaseRequestsDetail::where('id', $request->id[$i])->first();

            // insert to pr history
            $data = [
                'request_no'                => $request->get('rn_no')[$i],
                'pr_id'                     => $request->get('pr_no')[$i],
                'rn_no'                     => $request->get('rn_no')[$i],
                'material_id'               => $request->get('material_id')[$i],
                'unit'                      => $request->get('unit')[$i],
                'vendor_id'                 => $request->get('vendor_id'),
                'plant_code'                => $request->get('plant_code')[$i],
                'price'                     => $request->get('price')[$i],
                'qty'                       => $request->get('qty')[$i],
                'qty_pr'                    => $material->qty,
                'is_assets'                 => $request->get('is_assets')[$i],
                'assets_no'                 => $request->get('assets_no')[$i],
                'text_id'                   => $request->get('text_id')[$i],
                'text_form'                 => $request->get('text_form')[$i],
                'text_line'                 => $request->get('text_line')[$i],
                'delivery_date_category'    => $request->get('delivery_date_category')[$i],
                'account_assignment'        => $request->get('account_assignment')[$i],
                'purchasing_group_code'     => $request->get('purchasing_group_code')[$i],
                'preq_name'                 => $request->get('preq_name')[$i],
                'gl_acct_code'              => $request->get('gl_acct_code')[$i],
                'cost_center_code'          => $request->get('cost_center_code')[$i],
                'profit_center_code'        => $request->get('profit_center_code')[$i],
                'storage_location'          => $request->get('storage_location')[$i],
                'material_group'            => $request->get('material_group')[$i],
                'preq_item'                 => $request->get('preq_item')[$i],
                'PR_NO'                     => $request->get('PR_NO')[$i]
            ];

            array_push($details, $data);
            $this->savePRHistory($data);

            $material->qty -= $request->get('qty')[$i];
            $material->save();
        }

        \DB::beginTransaction();

        try {
            $quotation = new Quotation;
            $quotation->po_no           = $request->get('po_no');
            $quotation->notes           = $request->get('notes');
            $quotation->doc_type        = $request->get('doc_type');
            $quotation->upload_file     = $request->get('upload_files');
            $quotation->currency        = $request->get('currency');
            $quotation->payment_term    = $request->get('payment_term');
            $quotation->vendor_id       = $request->vendor_id;
            $quotation->status          = 0;

            $quotation->save();
            foreach ($details as $detail) {
                $quotationDetail = new QuotationDetail;
                $quotationDetail->quotation_order_id        = $quotation->id;
                $quotationDetail->qty                       = $detail['qty'];
                $quotationDetail->unit                      = $detail['unit'];
                $quotationDetail->material                  = $detail['material_id'];
                $quotationDetail->plant_code                = $detail['plant_code'];
                $quotationDetail->vendor_price              = $detail['price'];
                $quotationDetail->vendor_id                 = $detail['vendor_id'];
                $quotationDetail->is_assets                 = $detail['is_assets'];
                $quotationDetail->assets_no                 = $detail['assets_no'];
                $quotationDetail->text_id                   = $detail['text_id'];
                $quotationDetail->text_form                 = $detail['text_form'];
                $quotationDetail->text_line                 = $detail['text_line'];
                $quotationDetail->delivery_date_category    = $detail['delivery_date_category'];
                $quotationDetail->account_assignment        = $detail['account_assignment'];
                $quotationDetail->purchasing_group_code     = $detail['purchasing_group_code'];
                $quotationDetail->preq_name                 = $detail['preq_name'];
                $quotationDetail->gl_acct_code              = $detail['gl_acct_code'];
                $quotationDetail->cost_center_code          = $detail['cost_center_code'];
                $quotationDetail->profit_center_code        = $detail['profit_center_code'];
                $quotationDetail->storage_location          = $detail['storage_location'];
                $quotationDetail->material_group            = $detail['material_group'];
                $quotationDetail->preq_item                 = $detail['preq_item'];
                $quotationDetail->PR_NO                     = $detail['PR_NO'];
                $quotationDetail->vendor_id                 = $request->vendor_id;

                $quotationDetail->save();
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('admin.quotation.index')->with('status', 'Repeat Order has been successfully ordered!');
    }

    public function saveDirect (Request $request)
    {
        $qty = 0;
        $price = 0;
        $details = [];
        // dd($request);

        for ($i = 0; $i < count($request->get('qty')); $i++) {
            $qy = str_replace('.', '', $request->get('qty')[$i]);
            $qty += $qy;
            // update material qty
            $material = PurchaseRequestsDetail::where('id', $request->id[$i])->first();

            // insert to pr history
            $data = [
                'request_no'                => $request->get('rn_no')[$i],
                'pr_id'                     => $request->get('pr_no')[$i],
                'rn_no'                     => $request->get('rn_no')[$i],
                'material_id'               => $request->get('material_id')[$i],
                'unit'                      => $request->get('unit')[$i],
                'vendor_id'                 => $request->get('vendor_id'),
                'plant_code'                => $request->get('plant_code')[$i],
                'price'                     => $request->get('price')[$i],
                'qty'                       => $request->get('qty')[$i],
                'qty_pr'                    => $material->qty,
                'is_assets'                 => $request->get('is_assets')[$i],
                'assets_no'                 => $request->get('assets_no')[$i],
                'text_id'                   => $request->get('text_id')[$i],
                'text_form'                 => $request->get('text_form')[$i],
                'text_line'                 => $request->get('text_line')[$i],
                'delivery_date_category'    => $request->get('delivery_date_category')[$i],
                'account_assignment'        => $request->get('account_assignment')[$i],
                'purchasing_group_code'     => $request->get('purchasing_group_code')[$i],
                'preq_name'                 => $request->get('preq_name')[$i],
                'gl_acct_code'              => $request->get('gl_acct_code')[$i],
                'cost_center_code'          => $request->get('cost_center_code')[$i],
                'profit_center_code'        => $request->get('profit_center_code')[$i],
                'storage_location'          => $request->get('storage_location')[$i],
                'material_group'            => $request->get('material_group')[$i],
                'preq_item'                 => $request->get('preq_item')[$i],
                'PR_NO'                     => $request->get('PR_NO')[$i]
            ];

            array_push($details, $data);

            $this->savePRHistory($data);

            $material->qty -= $request->get('qty')[$i];
            $material->save();
        }

        \DB::beginTransaction();

        try {
            $quotation = new Quotation;
            $quotation->po_no        = $request->get('po_no');
            $quotation->notes        = $request->get('notes');
            $quotation->doc_type     = $request->get('doc_type');
            $quotation->upload_file  = $request->get('upload_files');
            $quotation->status       = 2;
            $quotation->currency     = 'IDR';
            $quotation->payment_term = $request->get('payment_term');
            $quotation->vendor_id    = $request->vendor_id;
            $quotation->acp_id       = $request->acp_id;
            $quotation->save();

            $price = 0;
            foreach ($details as $detail) {
                $price += $detail['price'];

                $quotationDetail = new QuotationDetail;
                $quotationDetail->quotation_order_id        = $quotation->id;
                $quotationDetail->qty                       = $detail['qty'];
                $quotationDetail->unit                      = $detail['unit'];
                $quotationDetail->material                  = $detail['material_id'];
                $quotationDetail->plant_code                = $detail['plant_code'];
                $quotationDetail->vendor_price              = $detail['price'];
                $quotationDetail->vendor_id                 = $detail['vendor_id'];
                $quotationDetail->is_assets                 = $detail['is_assets'];
                $quotationDetail->assets_no                 = $detail['assets_no'];
                $quotationDetail->text_id                   = $detail['text_id'];
                $quotationDetail->text_form                 = $detail['text_form'];
                $quotationDetail->text_line                 = $detail['text_line'];
                $quotationDetail->delivery_date_category    = $detail['delivery_date_category'];
                $quotationDetail->account_assignment        = $detail['account_assignment'];
                $quotationDetail->purchasing_group_code     = $detail['purchasing_group_code'];
                $quotationDetail->preq_name                 = $detail['preq_name'];
                $quotationDetail->gl_acct_code              = $detail['gl_acct_code'];
                $quotationDetail->cost_center_code          = $detail['cost_center_code'];
                $quotationDetail->profit_center_code        = $detail['profit_center_code'];
                $quotationDetail->storage_location          = $detail['storage_location'];
                $quotationDetail->material_group            = $detail['material_group'];
                $quotationDetail->preq_item                 = $detail['preq_item'];
                $quotationDetail->PR_NO                     = $detail['PR_NO'];
                $quotationDetail->vendor_id                 = $request->vendor_id;
                $quotationDetail->save();
            }

            if( $price <= 25000000 ) {
                $tingkat = 'STAFF';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            } else if( $price > 25000000 && $price < 100000000) {
                $tingkat = 'CMO';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            } else if( $price > 100000000 && $price <= 250000000) {
                $tingkat = 'CFO';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            } else if( $price > 250000000) {
                $tingkat = 'COO';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        // send email
        $vendor = Vendor::where('code', $request->get('vendor'))->first();
        $files = explode(', ', $request->get('upload_files'));
        $attachments = [];
        $data = [
            'vendor' => $vendor,
            'request_no' => $request->get('po_no'),
            'attachments' => $attachments,
            'subject' => 'PO Repeat ' . $request->get('po_no')
        ];

        $mail_sent = '';
        if (!empty($vendor->email))
            \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));
        else
            $mail_sent = '<br>But Email cannot be send, because vendor doesnot have an email address';

        return redirect()->route('admin.quotation.direct')->with('status', 'Direct Order has been successfully ordered!' . $mail_sent);
    }

    public function showOnline (Request $request, $id)
    {
        $model = Quotation::find($id);

        return view('admin.quotation.show-online', compact('model'));
    }

    public function showRepeat (Request $request, $id)
    {
        $model = Quotation::find($id);

        return view('admin.quotation.show-repeat', compact('model'));
    }

    public function approveRepeat (Request $request)
    {
        if (empty($request->get('id')))
            return redirect()->route('admin.quotation-show-repeat', $request->get('quotation_id'))->with('error', 'Please check your material!');

        \DB::beginTransaction();

        try {
            foreach ($request->get('id') as $id) {
                $quotationDetail = QuotationDetail::find($id);

                $model = $quotationDetail->quotation;
                $model->approval_status = 1;
                $model->save();
            }

            // send email
            $vendor = Vendor::where('code', $request->get('vendor_code'))->first();
            $files = explode(', ', $request->get('upload_files'));
            $attachments = [];
            $data = [
                'vendor' => $vendor,
                'request_no' => $request->get('po_no'),
                'attachments' => $attachments,
                'subject' => 'Repeat Order ' . $request->get('po_no')
            ];

            $mail_sent = '';
            if (!empty($vendor->email))
                // \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));
                \Mail::to('diditriawan13@gmail.com')->send(new PurchaseOrderMail($data));
            else
                \Mail::to('diditriawan13@gmail.com')->send(new PurchaseOrderMail($data));
                $mail_sent = '<br>But Email cannot be send, because vendor doesnot have an email address';

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('admin.quotation.repeat')->with('status', 'Repeat Order has been approval!' . $mail_sent);
    }

    public function winner (Request $request)
    {
        $quotation = [];
        
        foreach ($request->get('id') as $id)
            $quotation[$id] = QuotationDetail::find($id);

        return view('admin.quotation.winner', compact('quotation'));
    }

    public function toWinner (Request $request)
    {
        \DB::beginTransaction();

        try {
            foreach ($request->get('id') as $id => $val) {
                $vendor_price = $request->get('vendor_price')[$id];
                $qty = $request->get('qty')[$id];
                $qty = str_replace('.', '', $qty);
                
                $model = QuotationDetail::find((int) $val);
                $model->is_winner = 1;
                $model->qty = $qty;
                $model->save();
            }

            \DB::commit();

            return redirect()->route('admin.quotation.list-winner')->with('success', 'Winner has been set!');
        } catch (Exception $e) {
            \DB::rollBack();
         
            return redirect()->route('admin.quotation.index')->with('error', 'Winner has not been set!');
        }
    }

    public function listWinner ()
    {
        $quotation = Quotation::where('status', 1)
            ->orderBy('quotation.created_at', 'desc')
            ->get();

        return view('admin.quotation.list-winner', compact('quotation'));
    }

    public function showWinner ($id)
    {
        $quotation = QuotationDetail::where('quotation_order_id', $id)->get();

        return view('admin.quotation.show-winner', compact('quotation', 'id'));
    }

    public function approve (Request $request, $id)
    {
        $model = QuotationDetail::find($id);
        $vendor = Vendor::find($model->vendor_id);

        $po = new PurchaseOrder;
        $po->request_id = $id;
        $po->bidding = 0;
        $po->po_date = date('Y-m-d');
        $po->vendor_id = $model->vendor_id;
        $po->status = 0;
        $po->po_no = $model->po_no;
        $po->save();

        $subject = '';
        if ($model->status == 0) {
            $subject = 'PO Repeat Order ' . $model->po_no;
        } else if ($model->status == 2) {
            $subject = 'Penunjukkan Langsung ' . $model->po_no;
        }

        $data = [
            'vendor' => $model->vendor,
            'request_no' => $model->po_no,
            'subject' => $subject
        ];

        \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

        return redirect()->route('admin.purchase-order.index')->with('success', 'Winner has been set!');
    }

    public function approveWinner (Request $request)
    {
        $id = $request->get('id');
        $quotation_id = $request->get('quotation_id');

        for ($i = 0; $i < count($id); $i++) {
            $id = $id[$i];

            $detail = QuotationDetail::find($id);
            $price = $detail->vendor_price;
            $vendor_id = $detail->vendor_id;
        
            \DB::beginTransaction();

            try {
                if( ($price >= 250000000) ) {
                    $this->saveApproval($quotation_id, 'COO');
                } else if( ($price <= 250000000) && ($price >= 100000000) ) {
                    $this->saveApproval($quotation_id, 'CFO');
                } else {
                    $this->saveApproval($quotation_id, 'No');
                }

                $quotation = Quotation::find($quotation_id);

                $po = new PurchaseOrder;
                $po->request_id = $quotation->request_id;
                $po->bidding = 1;
                $po->po_no = str_replace('PR', 'PO', $quotation->po_no);
                $po->notes = $detail->notes;
                $po->vendor_id = $vendor_id;
                $po->status = 1;
                $po->po_date = date('Y-m-d');
                $po->save();

                \DB::commit();

                return redirect()->route('admin.purchase-order.index')->with('success', 'Bidding has been approved successfully');
            } catch (\Exception $th) {
                \DB::rollback();

                return redirect()->route('admin.quotation.show-winner', $request->get('quotation_id'))->with('success', 'Bidding has been approved failed');
            }
        }
    }

    public function editOnline (Request $request, $id)
    {
        $quotation = Quotation::find($id);

        return view('admin.quotation.edit-online', compact('quotation'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Quotation::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "quotation deleted successfully";
        } else {
            $success = true;
            $message = "quotation not found";
        }

        // return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    protected function savePRHistory ($data)
    {
        // insert to purchase_request_history
        $prHistory = new PurchaseRequestHistory;
        $prHistory->pr_id       = $data['pr_id'];
        $prHistory->request_no  = $data['rn_no'];
        $prHistory->material_id = $data['material_id'];
        $prHistory->vendor_id   = $data['vendor_id'];
        $prHistory->qty         = $data['qty_pr'];
        $prHistory->qty_po          = $data['qty'] ?? 0;
        $prHistory->qty_outstanding = $data['qty_pr'] - $data['qty'];
        $prHistory->save();
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:quotation', ['filename' => $real_filename]);

        return redirect('admin/quotation')->with('success', 'Quotation has been successfully imported');
    }

    private function saveApprovals($quotation_id, $tingkat,$type)
    {

        if( $tingkat == 'STAFF' ) {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
        } else if ($tingkat == 'CMO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
        } else if ($tingkat == 'CFO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            
            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 4,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
        } else if ($tingkat == 'COO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            
            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 4,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 5,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
        }
    }
}
