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
            'quotation.target_price',
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
            'quotation_details.id as detail_id', 'quotation_details.*'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', 'quotation.id')
            ->where('quotation_details.vendor_id', Auth::user()->code)
            ->where('quotation.status', Quotation::Bidding)
            ->orderBy('quotation.id', 'desc')
            ->get();

        return view('vendor.quotation.online', compact('quotation'));
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

    public function approveRepeat (Request $request)
    {
        // soap call
        // Testing Alvin, start::
        $wsdl = public_path() . "/xml/zbn_eproc_po.xml";
        
        $username = "it_02";
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

        $ALLVERSIONS = [
            'DOC_TYPE' => '',
            'DOC_NUMBER' => '',
            'ITEM_NUMBER' => '',
            'VERSION' => '',
            'CREATED_BY' => '',
            'CR_ON' => '',
            'REC_TIME' => '',
            'RELEASED_BY' => '',
            'RELEASE_DATE' => '',
            'RELEASE_TIME' => '',
            'RELEASEBY_PUR' => '',
            'RELEASEDATE_PUR' => '',
            'RELEASETIME_PUR' => '',
            'REASON' => '',
            'DESCRIPTION' => '',
            'REQ_BY_EXT' => '',
            'REQ_BY' => '',
            'NET_VALUE' => '',
            'VALUE_CHANGED' => '',
            'CURRENCY' => '',
            'CURRENCY_ISO' => '',
            'POST_DATE' => '',
            'COMPLETED' => '',
            'STATUS' => '',
            'DELETE_IND' => '',
            'STATUS_DOC_OLD' => ''
        ];
        $params[0]['ALLVERSIONS'] = $ALLVERSIONS;
        $params[0]['EXTENSIONIN'] = array();
        $params[0]['EXTENSIONOUT'] = array();
        $INVPLANHEADER = [
            'DOC_ITEM' => '',
            'IV_PLAN_NUM' => '',
            'CATEGORY' => '',
            'IP_TYPE' => '',
            'SORT_FLD' => '',
            'START_DATE' => '',
            'END_DATE' => '',
            'HORIZON' => '',
            'ORGN_ST_DAT' => '',
            'ORGN_END_DAT' => '',
            'PERIOD' => '',
            'LNGTH_STAND_PRD' => '',
            'REF_IV_PLAN_NUM' => '',
            'DATES_FROM' => '',
            'IN_ADVANCE' => '',
            'ORGN_FROM_DAT' => '',
            'DEV_BILL_DAT' => '',
            'CALENDER_ID' => '',
            'DATES_TO' => '',
            'ORGN_UNTIL_DAT' => '',
            'PO_NUMBER' => '',
            'UNLIMITED' => '',
            'AUTO_COR_DAT' => ''
        ];
        $params[0]['INVPLANHEADER'] = $INVPLANHEADER;
        $INVPLANHEADERX = [
            'DOC_ITEM' => '',
            'IV_PLAN_NUM' => '',
            'CATEGORY' => '',
            'IP_TYPE' => '',
            'SORT_FLD' => '',
            'START_DATE' => '',
            'END_DATE' => '',
            'HORIZON' => '',
            'ORGN_ST_DAT' => '',
            'ORGN_END_DAT' => '',
            'PERIOD' => '',
            'LNGTH_STAND_PRD' => '',
            'REF_IV_PLAN_NUM' => '',
            'DATES_FROM' => '',
            'IN_ADVANCE' => '',
            'ORGN_FROM_DAT' => '',
            'DEV_BILL_DAT' => '',
            'CALENDER_ID' => '',
            'DATES_TO' => '',
            'ORGN_UNTIL_DAT' => '',
            'PO_NUMBER' => '',
            'UNLIMITED' => '',
            'AUTO_COR_DAT' => ''
        ];
        $params[0]['INVPLANHEADERX'] = $INVPLANHEADERX;
        $params[0]['INVPLANITEM'] = array();
        $params[0]['INVPLANITEMX'] = array();
        $params[0]['MEMORY_COMPLETE'] = '';
        $params[0]['MEMORY_UNCOMPLETE'] = '';
        $params[0]['NFMETALLITMS'] = array();
        $params[0]['NO_AUTHORITY'] = '';
        $params[0]['NO_MESSAGE_REQ'] = '';
        $params[0]['NO_MESSAGING'] = '';
        $params[0]['NO_PRICE_FROM_PO'] = '';
        $params[0]['PARK_COMPLETE'] = '';
        $params[0]['PARK_UNCOMPLETE'] = '';
        $POACCOUNT = [
            'PO_ITEM' => '0010',
            'SERIAL_NO' => '01',
            'DELETE_IND' => '',
            'CREAT_DATE' => '',
            'QUANTITY' => '0.000',
            'DISTR_PERC' => '0.0',
            'NET_VALUE' => '0.000000000',
            'GL_ACCOUNT' => '6126043011',
            'BUS_AREA' => '',
            'COSTCENTER' => '1101000004',
            'SD_DOC' => '',
            'ITM_NUMBER' => '00000',
            'SCHED_LINE' => '0000',
            'ASSET_NO' => '',
            'SUB_NUMBER' => '',
            'ORDERID' => '',
            'GR_RCPT' => '',
            'UNLOAD_PT' => '',
            'CO_AREA' => '',
            'COSTOBJECT' => '',
            'PROFIT_CTR' => '',
            'WBS_ELEMENT' => '',
            'NETWORK' => '',
            'RL_EST_KEY' => '',
            'PART_ACCT' => '',
            'CMMT_ITEM' => '',
            'REC_IND' => '',
            'FUNDS_CTR' => '',
            'FUND' => '',
            'FUNC_AREA' => '',
            'REF_DATE' => '',
            'TAX_CODE' => '',
            'TAXJURCODE' => '',
            'NOND_ITAX' => '',
            'ACTTYPE' => '',
            'CO_BUSPROC' => '',
            'RES_DOC' => '',
            'RES_ITEM' => '',
            'ACTIVITY' => '',
            'GRANT_NBR' => '',
            'CMMT_ITEM_LONG' => '',
            'FUNC_AREA_LONG' => '',
            'BUDGET_PERIOD' => '',
            'FINAL_IND' => '',
            'FINAL_REASON' => ''
        ];
        $params[0]['POACCOUNT'] = $POACCOUNT;
        $params[0]['POACCOUNTPROFITSEGMENT'] = array();
        $POACCOUNTX = [
            'PO_ITEM' => '00010', 
            'SERIAL_NO' => '01', 
            'PO_ITEMX' => 'X', 
            'SERIAL_NOX' => 'X', 
            'DELETE_IND' => '', 
            'CREAT_DATE' => '', 
            'QUANTITY' => 'X', 
            'DISTR_PERC' => 'X', 
            'NET_VALUE' => 'X', 
            'GL_ACCOUNT' => 'X', 
            'BUS_AREA' => '', 
            'COSTCENTER' => 'X', 
            'SD_DOC' => '', 
            'ITM_NUMBER' => '', 
            'SCHED_LINE' => '', 
            'ASSET_NO' => '', 
            'SUB_NUMBER' => '', 
            'ORDERID' => '', 
            'GR_RCPT' => '', 
            'UNLOAD_PT' => '', 
            'CO_AREA' => '', 
            'COSTOBJECT' => '', 
            'PROFIT_CTR' => '', 
            'WBS_ELEMENT' => '', 
            'NETWORK' => '', 
            'RL_EST_KEY' => '', 
            'PART_ACCT' => '', 
            'CMMT_ITEM' => '', 
            'REC_IND' => '', 
            'FUNDS_CTR' => '', 
            'FUND' => '', 
            'FUNC_AREA' => '', 
            'REF_DATE' => '', 
            'TAX_CODE' => '', 
            'TAXJURCODE' => '', 
            'NOND_ITAX' => '', 
            'ACTTYPE' => '', 
            'CO_BUSPROC' => '', 
            'RES_DOC' => '', 
            'RES_ITEM' => '', 
            'ACTIVITY' => '', 
            'GRANT_NBR' => '', 
            'BUDGET_PERIOD' => '', 
            'FINAL_IND' => '', 
            'FINAL_REASON' => ''
        ];
        $params[0]['POACCOUNTX'] = $POACCOUNTX;
        $params[0]['POADDRDELIVERY'] = array();
        $POADDRVENDOR = [
            'PO_NUMBER' => '',
            'ADDR_NO' => '',
            'FORMOFADDR' => '',
            'NAME' => '',
            'NAME_2' => '',
            'NAME_3' => '',
            'NAME_4' => '',
            'C_O_NAME' => '',
            'CITY' => '',
            'DISTRICT' => '',
            'CITY_NO' => '',
            'POSTL_COD1' => '',
            'POSTL_COD2' => '',
            'POSTL_COD3' => '',
            'PO_BOX' => '',
            'PO_BOX_CIT' => '',
            'DELIV_DIS' => '',
            'STREET' => '',
            'STREET_NO' => '',
            'STR_ABBR' => '',
            'HOUSE_NO' => '',
            'STR_SUPPL1' => '',
            'STR_SUPPL2' => '',
            'LOCATION' => '',
            'BUILDING' => '',
            'FLOOR' => '',
            'ROOM_NO' => '',
            'COUNTRY' => '',
            'LANGU' => '',
            'REGION' => '',
            'SORT1' => '',
            'SORT2' => '',
            'TIME_ZONE' => '',
            'TAXJURCODE' => '',
            'ADR_NOTES' => '',
            'COMM_TYPE' => '',
            'TEL1_NUMBR' => '',
            'TEL1_EXT' => '',
            'FAX_NUMBER' => '',
            'FAX_EXTENS' => '',
            'STREET_LNG' => '',
            'DISTRCT_NO' => '',
            'CHCKSTATUS' => '',
            'PBOXCIT_NO' => '',
            'TRANSPZONE' => '',
            'HOUSE_NO2' => '',
            'E_MAIL' => '',
            'STR_SUPPL3' => '',
            'TITLE' => '',
            'COUNTRYISO' => '',
            'LANGU_ISO' => '',
            'BUILD_LONG' => '',
            'REGIOGROUP' => ''
        ];
        $params[0]['POADDRVENDOR'] = $POADDRVENDOR;
        $params[0]['POCOMPONENTS'] = array();
        $params[0]['POCOMPONENTSX'] = array();
        $params[0]['POCOND'] = array();
        $params[0]['POCONDHEADER'] = array();
        $params[0]['POCONDHEADERX'] = array();
        $params[0]['POCONDX'] = array();
        $params[0]['POCONTRACTLIMITS'] = array();
        $POEXPIMPHEADER = [
            'TRANSPORT_MODE' => '',
            'CUSTOMS' => ''
        ];
        $params[0]['POEXPIMPHEADER'] = $POEXPIMPHEADER;
        $POEXPIMPHEADERX = [
            'TRANSPORT_MODE' => '',
            'CUSTOMS' => ''
        ];
        $params[0]['POEXPIMPHEADERX'] = $POEXPIMPHEADERX;
        $params[0]['POEXPIMPITEM'] = array();
        $params[0]['POEXPIMPITEMX'] = array();
        $POHEADER = [
            // 'PO_NUMBER' => 'PO/06/2020/0000012',
            'PO_NUMBER' => '',
            'COMP_CODE' => '1100',
            'DOC_TYPE' => 'z302',
            'DELETE_IND' => '',
            'STATUS' => '',
            // 'CREAT_DATE' => '12.06.2020',
            'CREAT_DATE' => '2020-06-12',
            'CREATED_BY' => 'IT_02',
            'ITEM_INTVL' => '0000',
            'VENDOR' => '3000046',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => 'z030',
            'DSCNT1_TO' => '0',
            'DSCNT2_TO' => '0',
            'DSCNT3_TO' => '0',
            'DSCT_PCT1' => '0.000',
            'DSCT_PCT2' => '0.000',
            'PURCH_ORG' => '0000',
            'PUR_GROUP' => 'H03',
            'CURRENCY' => 'IDR',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            // 'DOC_DATE' => '12.06.2020',
            'DOC_DATE' => '2020-06-12',
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
            // 'PO_NUMBER' => 'PO/06/2020/0000012',
            'PO_NUMBER' => '',
            'COMP_CODE' => 'X',
            'DOC_TYPE' => 'X',
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => 'X',
            'CREATED_BY' => 'X',
            'ITEM_INTVL' => '',
            'VENDOR' => 'X',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => 'X',
            'DSCNT1_TO' => '',
            'DSCNT2_TO' => '',
            'DSCNT3_TO' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'PURCH_ORG' => 'X',
            'PUR_GROUP' => 'X',
            'CURRENCY' => 'X',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => 'X',
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
        $POITEM = [
            'PO_ITEM' => '00010',
            'DELETE_IND' => '',
            'SHORT_TEXT' => 'TEST SERVICE',
            'MATERIAL' => '',
            'MATERIAL_EXTERNAL' => '',
            'MATERIAL_GUID' => '',
            'MATERIAL_VERSION' => '',
            'EMATERIAL' => '',
            'EMATERIAL_EXTERNAL' => '',
            'EMATERIAL_GUID' => '',
            'EMATERIAL_VERSION' => '',
            'PLANT' => '1101',
            'STGE_LOC' => '',
            'TRACKINGNO' => '10',
            'MATL_GROUP' => 'T11023',
            'INFO_REC' => '',
            'VEND_MAT' => '',
            'QUANTITY' => '0.000',
            'PO_UNIT' => '',
            'PO_UNIT_ISO' => '',
            'ORDERPR_UN' => '',
            'ORDERPR_UN_ISO' => '',
            'CONV_NUM1' => '0',
            'CONV_DEN1' => '0',
            'NET_PRICE' => '',
            'PRICE_UNIT' => '',
            'GR_PR_TIME' => '',
            'TAX_CODE' => 'V1',
            'BON_GRP1' => '',
            'QUAL_INSP' => '',
            'INFO_UPD' => '',
            'PRNT_PRICE' => '',
            'EST_PRICE' => '',
            'REMINDER1' => '0',
            'REMINDER2' => '0',
            'REMINDER3' => '0',
            'OVER_DLV_TOL' => '0.0',
            'UNLIMITED_DLV' => '',
            'UNDER_DLV_TOL' => '0.0',
            'VAL_TYPE' => '',
            'NO_MORE_GR' => '',
            'FINAL_INV' => '',
            'ITEM_CAT' => '',
            'ACCTASSCAT' => '9',
            'DISTRIB' => 'K',
            'PART_INV' => '',
            'GR_IND' => '',
            'GR_NON_VAL' => 'X',
            'IR_IND' => '',
            'FREE_ITEM' => 'X',
            'GR_BASEDIV' => '',
            'ACKN_REQD' => 'X',
            'ACKNOWL_NO' => '',
            'AGREEMENT' => '',
            'AGMT_ITEM' => '00000',
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
            'MINREMLIFE' => '0',
            'RFQ_NO' => '',
            'RFQ_ITEM' => '00000',
            'PREQ_NO' => '1400000708',
            'PREQ_ITEM' => '00010',
            'REF_DOC' => '',
            'REF_ITEM' => '00000',
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
            'PREQ_NAME' => 'SUTOYO',
            'PERIOD_IND_EXPIRATION_DATE' => 'D',
            'INT_OBJ_NO' => '000000000000000000',
            'PCKG_NO' => '000000001',
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
        $params[0]['POITEM'] = $POITEM;
        $POITEMX = [
            'PO_ITEM' => '00010',
            'PO_ITEMX' => 'X',
            'DELETE_IND' => '',
            'SHORT_TEXT' => 'X',
            'MATERIAL' => '',
            'MATERIAL_EXTERNAL' => '',
            'MATERIAL_GUID' => '',
            'MATERIAL_VERSION' => '',
            'EMATERIAL' => '',
            'EMATERIAL_EXTERNAL' => '',
            'EMATERIAL_GUID' => '',
            'EMATERIAL_VERSION' => '',
            'PLANT' => 'X',
            'STGE_LOC' => 'X',
            'TRACKINGNO' => 'X',
            'MATL_GROUP' => 'X',
            'INFO_REC' => '',
            'VEND_MAT' => '',
            'QUANTITY' => 'X',
            'PO_UNIT' => 'X',
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
            'ITEM_CAT' => 'X',
            'ACCTASSCAT' => 'X',
            'DISTRIB' => 'X',
            'PART_INV' => '',
            'GR_IND' => 'X',
            'GR_NON_VAL' => '',
            'IR_IND' => 'X',
            'FREE_ITEM' => '',
            'GR_BASEDIV' => 'X',
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
            'RFQ_NO' => 'X',
            'RFQ_ITEM' => 'X',
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
            'PREQ_NAME' => 'X',
            'PERIOD_IND_EXPIRATION_DATE' => '',
            'INT_OBJ_NO' => '',
            'PCKG_NO' => 'X',
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
        $params[0]['POITEMX'] = $POITEMX;
        $params[0]['POLIMITS'] = array();
        $params[0]['POPARTNER'] = array();
        $params[0]['POSCHEDULE'] = array();
        $params[0]['POSCHEDULEX'] = array();
        $POSERVICES = [
            'PCKG_NO' => '0000000001',
            'LINE_NO' => '0000000001',
            'EXT_LINE' => '0000000000',
            'OUTL_LEVEL' => '0',
            'OUTL_NO' => '',
            'OUTL_IND' => 'X',
            'SUBPCKG_NO' => '0000000002',
            'SERVICE' => '',
            'SERV_TYPE' => '',
            'EDITION' => '000',
            'SSC_ITEM' => '',
            'EXT_SERV' => '',
            'QUANTITY' => '0.000',
            'BASE_UOM' => '',
            'UOM_ISO' => '',
            'OVF_TOL' => '',
            'OVF_UNLIM' => '0.0',
            'PRICE_UNIT' => '',
            'GR_PRICE' => '0',
            'FROM_LINE' => '0.0000',
            'TO_LINE' => '',
            'SHORT_TEXT' => '',
            'DISTRIB' => '',
            'PERS_NO' => '00000000',
            'WAGETYPE' => '',
            'PLN_PCKG' => '0000000155',
            'PLN_LINE' => '0000000001',
            'CON_PCKG' => '0000000000',
            'CON_LINE' => '0000000000',
            'TMP_PCKG' => '0000000000',
            'TMP_LINE' => '0000000000',
            'SSC_LIM' => '',
            'LIMIT_LINE' => '0000000000',
            'TARGET_VAL' => '0.0000',
            'BASLINE_NO' => '0000000000',
            'BASIC_LINE' => '',
            'ALTERNAT' => '',
            'BIDDER' => '',
            'SUPP_LINE' => '',
            'OPEN_QTY' => '',
            'INFORM' => '',
            'BLANKET' => '',
            'EVENTUAL' => '',
            'TAX_CODE' => '',
            'TAXJURCODE' => '',
            'PRICE_CHG' => '',
            'MATL_GROUP' => '',
            'DATE' => '',
            'BEGINTIME' => '00:00:00',
            'ENDTIME' => '00:00:00',
            'EXTPERS_NO' => '',
            'FORMULA' => '',
            'FORM_VAL1' => '',
            'FORM_VAL2' => '',
            'FORM_VAL3' => '',
            'FORM_VAL4' => '',
            'FORM_VAL5' => '',
            'USERF1_NUM' => '',
            'USERF2_NUM' => '',
            'USERF1_TXT' => '',
            'USERF2_TXT' => '',
            'HI_LINE_NO' => '',
            'EXTREFKEY' => '',
            'DELETE_IND' => '',
            'PER_SDATE' => '',
            'PER_EDATE' => '',
            'EXTERNAL_ITEM_ID' => '',
            'SERVICE_ITEM_KEY' => '',
            'NET_VALUE' => '',
        ];
        $params[0]['POSERVICES'] = $POSERVICES;
        $params[0]['POSERVICESTEXT'] = array();
        $params[0]['POSHIPPING'] = array();
        $params[0]['POSHIPPINGEXP'] = array();
        $params[0]['POSHIPPINGX'] = array();
        $params[0]['POSRVACCESSVALUES'] = array();
        $POTEXTHEADER = [
            // 'PO_NUMBER' => 'PO/06/2020/0000012',
            'PO_NUMBER' => '',
            'PO_ITEM' => '00010',
            'TEXT_ID' => 'EKKO',
            'TEXT_FORM' => 'EN',
            'TEXT_LINE' => 'TEST EPROC'
        ];
        $params[0]['POTEXTHEADER'] = $POTEXTHEADER;
        $POTEXTITEM = [
            // 'PO_NUMBER' => 'PO/06/2020/0000012',
            'PO_NUMBER' => '',
            'PO_ITEM' => '00010',
            'TEXT_ID' => 'EKPO',
            'TEXT_FORM' => 'EN',
            'TEXT_LINE' => 'TEST ITEM'
        ];
        $params[0]['POTEXTITEM'] = $POTEXTITEM;
        $params[0]['RETURN'] = array();
        $params[0]['SERIALNUMBER'] = array();
        $params[0]['SERIALNUMBERX'] = array();
        $params[0]['TESTRUN'] = '';
        $VERSIONS = [
            'POST_DATE' => '',
            'COMPLETED' => '',
            'REASON' => '',
            'DESCRIPTION' => '',
            'REQ_BY' => '',
            'REQ_BY_EXT' => '',
            'ACTIVITY' => ''
        ];
        $params[0]['VERSIONS'] = $VERSIONS;

        $result = $client->__soapCall('ZFM_WS_PO', $params, NULL, $header);
        dd($result);
        // ::end

        // create po
        $id = $request->get('id');

        $quotation = Quotation::find($id);
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
            'quotation.expired_date',
            'quotation.qty'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', '=', 'quotation.id')
            ->where('quotation_details.id', $id)
            ->first();

        return view('vendor.quotation.online-detail', compact('quotation'));
    }

    public function repeatDetail ($id)
    {
        $quotation = Quotation::find($id);

        return view('vendor.quotation.repeat-detail', compact('quotation'));
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