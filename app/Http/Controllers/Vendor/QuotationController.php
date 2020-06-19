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

        // $ALLVERSIONS = [
        //     'DOC_TYPE' => '',
        //     'DOC_NUMBER' => '',
        //     'ITEM_NUMBER' => '',
        //     'VERSION' => '',
        //     'CREATED_BY' => '',
        //     'CR_ON' => '',
        //     'REC_TIME' => '',
        //     'RELEASED_BY' => '',
        //     'RELEASE_DATE' => '',
        //     'RELEASE_TIME' => '',
        //     'RELEASEBY_PUR' => '',
        //     'RELEASEDATE_PUR' => '',
        //     'RELEASETIME_PUR' => '',
        //     'REASON' => '',
        //     'DESCRIPTION' => '',
        //     'REQ_BY_EXT' => '',
        //     'REQ_BY' => '',
        //     'NET_VALUE' => '',
        //     'VALUE_CHANGED' => '',
        //     'CURRENCY' => '',
        //     'CURRENCY_ISO' => '',
        //     'POST_DATE' => '',
        //     'COMPLETED' => '',
        //     'STATUS' => '',
        //     'DELETE_IND' => '',
        //     'STATUS_DOC_OLD' => ''
        // ];
        // $params[0]['ALLVERSIONS'] = $ALLVERSIONS;
        // $EXTENSION = [
        //    "STRUCTURE" => '',
        //    "VALUEPART1" => '',
        //    "VALUEPART2" => '',
        //    "VALUEPART3" => '',
        //    "VALUEPART4" => ''
        // ];
        // $params[0]['EXTENSIONIN'] = $EXTENSION;
        // $params[0]['EXTENSIONOUT'] = $EXTENSION;
        // $INVPLANHEADER = [
        //     'DOC_ITEM' => '',
        //     'IV_PLAN_NUM' => '',
        //     'CATEGORY' => '',
        //     'IP_TYPE' => '',
        //     'SORT_FLD' => '',
        //     'START_DATE' => '',
        //     'END_DATE' => '',
        //     'HORIZON' => '',
        //     'ORGN_ST_DAT' => '',
        //     'ORGN_END_DAT' => '',
        //     'PERIOD' => '',
        //     'LNGTH_STAND_PRD' => '',
        //     'REF_IV_PLAN_NUM' => '',
        //     'DATES_FROM' => '',
        //     'IN_ADVANCE' => '',
        //     'ORGN_FROM_DAT' => '',
        //     'DEV_BILL_DAT' => '',
        //     'CALENDER_ID' => '',
        //     'DATES_TO' => '',
        //     'ORGN_UNTIL_DAT' => '',
        //     'PO_NUMBER' => '',
        //     'UNLIMITED' => '',
        //     'AUTO_COR_DAT' => ''
        // ];
        // $params[0]['INVPLANHEADER'] = $INVPLANHEADER;
        // $INVPLANHEADERX = [
        //     'DOC_ITEM' => '',
        //     'IV_PLAN_NUM' => '',
        //     'CATEGORY' => '',
        //     'IP_TYPE' => '',
        //     'SORT_FLD' => '',
        //     'START_DATE' => '',
        //     'END_DATE' => '',
        //     'HORIZON' => '',
        //     'ORGN_ST_DAT' => '',
        //     'ORGN_END_DAT' => '',
        //     'PERIOD' => '',
        //     'LNGTH_STAND_PRD' => '',
        //     'REF_IV_PLAN_NUM' => '',
        //     'DATES_FROM' => '',
        //     'IN_ADVANCE' => '',
        //     'ORGN_FROM_DAT' => '',
        //     'DEV_BILL_DAT' => '',
        //     'CALENDER_ID' => '',
        //     'DATES_TO' => '',
        //     'ORGN_UNTIL_DAT' => '',
        //     'PO_NUMBER' => '',
        //     'UNLIMITED' => '',
        //     'AUTO_COR_DAT' => ''
        // ];
        // $params[0]['INVPLANHEADERX'] = $INVPLANHEADERX;
        // $INVPLANITEM = [
        //     "DOC_ITEM"  => "",
        //     "IV_PLAN_NUM"  => "",
        //     "IV_PLAN_ITEM"  => "",
        //     "DEL_IND"  => "",
        //     "DATE_CATG"  => "",
        //     "DATE_DESC"  => "",
        //     "SETT_DATE_FROM"  => "",
        //     "BILL_RULE"  => "",
        //     "INVOICE_PERCENTAGE"  => "",
        //     "CURRENCY"  => "",
        //     "CURRENCY_ISO"  => "",
        //     "EXCHG_RAT_DAT"  => "",
        //     "BILL_VALUE"  => "",
        //     "BILLING_BLOCK"  => "",
        //     "BILLING_STATUS"  => "",
        //     "SETT_DATE_TO"  => "",
        //     "CALENDER_ID"  => "",
        //     "BILL_DATE"  => "",
        //     "CASH_DISCOUNT"  => "",
        //     "REBATE_BASIS1"  => "",
        //     "PRICING_OK"  => "",
        //     "MILESTONE_NUM"  => "",
        //     "MILESTONE_USE"  => "",
        //     "MANUALLY"  => "",
        // ];
        // $INVPLANITEMX = [
        //     "DOC_ITEM"  => "",
        //     "IV_PLAN_NUM"  => "",
        //     "IV_PLAN_ITEM"  => "",
        //     "DEL_IND"  => "",
        //     "DATE_CATG"  => "",
        //     "DATE_DESC"  => "",
        //     "SETT_DATE_FROM"  => "",
        //     "BILL_RULE"  => "",
        //     "INVOICE_PERCENTAGE"  => "",
        //     "CURRENCY"  => "",
        //     "CURRENCY_ISO"  => "",
        //     "EXCHG_RAT_DAT"  => "",
        //     "BILL_VALUE"  => "",
        //     "BILLING_BLOCK"  => "",
        //     "BILLING_STATUS"  => "",
        //     "SETT_DATE_TO"  => "",
        //     "CALENDER_ID"  => "",
        //     "BILL_DATE"  => "",
        //     "CASH_DISCOUNT"  => "",
        //     "REBATE_BASIS1"  => "",
        //     "PRICING_OK"  => "",
        //     "MILESTONE_NUM"  => "",
        //     "MILESTONE_USE"  => "",
        //     "MANUALLY"  => "",
        // ];
        // $params[0]['INVPLANITEM'] = $INVPLANITEM;
        // $params[0]['INVPLANITEMX'] = $INVPLANITEMX;
        // $params[0]['MEMORY_COMPLETE'] = '';
        // $params[0]['MEMORY_UNCOMPLETE'] = '';
        // $NFMETALLITMS = [
        //     "DATA_INDEX" => "",
        //     "DOC_NUMBER" => "",
        //     "ITM_NUMBER" => "",
        //     "COMPCODE" => "",
        //     "FISCYEAR" => "",
        //     "NFMKEY" => "",
        //     "RATEDETKEY" => "",
        //     "BASEKEY" => "",
        //     "EXCHANGEKEY" => "",
        //     "RATEDETDAT" => "",
        //     "RATEMONTH" => "",
        //     "ACTRATEDAT" => "",
        //     "RATE" => "",
        //     "RATECURKY" => "",
        //     "RATECURKYISO" => "",
        //     "RATEDOCCUR" => "",
        //     "INVOICEBL" => "",
        //     "BVALDOCCUR" => "",
        //     "BVALCURKYD" => "",
        //     "BVALCURKYDISO" => "",
        //     "NETRATE" => "",
        //     "PROVIDER" => "",
        //     "VENDORCOV" => "",
        //     "COVERAGEKY" => "",
        //     "POSTINGDAYS" => "",
        //     "UPDTYPE" => ""
        // ];
        // $params[0]['NFMETALLITMS'] = $NFMETALLITMS;
        // $params[0]['NO_AUTHORITY'] = '';
        // $params[0]['NO_MESSAGE_REQ'] = '';
        // $params[0]['NO_MESSAGING'] = '';
        // $params[0]['NO_PRICE_FROM_PO'] = '';
        // $params[0]['PARK_COMPLETE'] = '';
        // $params[0]['PARK_UNCOMPLETE'] = '';
        // $POACCOUNT = [
        //     'PO_ITEM' => '00010',
        //     'SERIAL_NO' => '01',
        //     'DELETE_IND' => '',
        //     'CREAT_DATE' => '',
        //     'QUANTITY' => '0.000',
        //     'DISTR_PERC' => '0.0',
        //     'NET_VALUE' => '',
        //     'GL_ACCOUNT' => '2132013001',
        //     'BUS_AREA' => '',
        //     'COSTCENTER' => '',
        //     'SD_DOC' => '',
        //     'ITM_NUMBER' => '00000',
        //     'SCHED_LINE' => '0000',
        //     'ASSET_NO' => '490000000044',
        //     'SUB_NUMBER' => '',
        //     'ORDERID' => '',
        //     'GR_RCPT' => '',
        //     'UNLOAD_PT' => '',
        //     'CO_AREA' => '',
        //     'COSTOBJECT' => '',
        //     'PROFIT_CTR' => '',
        //     'WBS_ELEMENT' => '',
        //     'NETWORK' => '',
        //     'RL_EST_KEY' => '',
        //     'PART_ACCT' => '',
        //     'CMMT_ITEM' => '',
        //     'REC_IND' => '',
        //     'FUNDS_CTR' => '',
        //     'FUND' => '',
        //     'FUNC_AREA' => '',
        //     'REF_DATE' => '',
        //     'TAX_CODE' => '',
        //     'TAXJURCODE' => '',
        //     'NOND_ITAX' => '',
        //     'ACTTYPE' => '',
        //     'CO_BUSPROC' => '',
        //     'RES_DOC' => '',
        //     'RES_ITEM' => '',
        //     'ACTIVITY' => '',
        //     'GRANT_NBR' => '',
        //     'CMMT_ITEM_LONG' => '',
        //     'FUNC_AREA_LONG' => '',
        //     'BUDGET_PERIOD' => '',
        //     'FINAL_IND' => '',
        //     'FINAL_REASON' => ''
        // ];
        // $params[0]['POACCOUNT'] = $POACCOUNT;
        // $POACCOUNTPROFITSEGMENT  = [
        //     "PO_ITEM" => "",
        //     "SERIAL_NO" => "",
        //     "FIELDNAME" => "",
        //     "VALUE" => "",
        // ];
        // $params[0]['POACCOUNTPROFITSEGMENT'] = $POACCOUNTPROFITSEGMENT;
        // $POACCOUNTX = [
        //     'PO_ITEM' => '00010', 
        //     'SERIAL_NO' => '01', 
        //     'PO_ITEMX' => 'X', 
        //     'SERIAL_NOX' => 'X', 
        //     'DELETE_IND' => '', 
        //     'CREAT_DATE' => '', 
        //     'QUANTITY' => 'X', 
        //     'DISTR_PERC' => 'X', 
        //     'NET_VALUE' => 'X', 
        //     'GL_ACCOUNT' => 'X', 
        //     'BUS_AREA' => '', 
        //     'COSTCENTER' => '', 
        //     'SD_DOC' => '', 
        //     'ITM_NUMBER' => '', 
        //     'SCHED_LINE' => '', 
        //     'ASSET_NO' => 'X', 
        //     'SUB_NUMBER' => '', 
        //     'ORDERID' => '', 
        //     'GR_RCPT' => '', 
        //     'UNLOAD_PT' => '', 
        //     'CO_AREA' => '', 
        //     'COSTOBJECT' => '', 
        //     'PROFIT_CTR' => '', 
        //     'WBS_ELEMENT' => '', 
        //     'NETWORK' => '', 
        //     'RL_EST_KEY' => '', 
        //     'PART_ACCT' => '', 
        //     'CMMT_ITEM' => '', 
        //     'REC_IND' => '', 
        //     'FUNDS_CTR' => '', 
        //     'FUND' => '', 
        //     'FUNC_AREA' => '', 
        //     'REF_DATE' => '', 
        //     'TAX_CODE' => '', 
        //     'TAXJURCODE' => '', 
        //     'NOND_ITAX' => '', 
        //     'ACTTYPE' => '', 
        //     'CO_BUSPROC' => '', 
        //     'RES_DOC' => '', 
        //     'RES_ITEM' => '', 
        //     'ACTIVITY' => '', 
        //     'GRANT_NBR' => '', 
        //     'BUDGET_PERIOD' => '', 
        //     'FINAL_IND' => '', 
        //     'FINAL_REASON' => ''
        // ];
        // $params[0]['POACCOUNTX'] = $POACCOUNTX;
        // $POADDRDELIVERY = [
        //     "PO_ITEM" => "",
        //     "ADDR_NO" => "",
        //     "FORMOFADDR" => "",
        //     "NAME" => "",
        //     "NAME_2" => "",
        //     "NAME_3" => "",
        //     "NAME_4" => "",
        //     "C_O_NAME" => "",
        //     "CITY" => "",
        //     "DISTRICT" => "",
        //     "CITY_NO" => "",
        //     "POSTL_COD1" => "",
        //     "POSTL_COD2" => "",
        //     "POSTL_COD3" => "",
        //     "PO_BOX" => "",
        //     "PO_BOX_CIT" => "",
        //     "DELIV_DIS" => "",
        //     "STREET" => "",
        //     "STREET_NO" => "",
        //     "STR_ABBR" => "",
        //     "HOUSE_NO" => "",
        //     "STR_SUPPL1" => "",
        //     "STR_SUPPL2" => "",
        //     "LOCATION" => "",
        //     "BUILDING" => "",
        //     "FLOOR" => "",
        //     "ROOM_NO" => "",
        //     "COUNTRY" => "",
        //     "LANGU" => "",
        //     "REGION" => "",
        //     "SORT1" => "",
        //     "SORT2" => "",
        //     "TIME_ZONE" => "",
        //     "TAXJURCODE" => "",
        //     "ADR_NOTES" => "",
        //     "COMM_TYPE" => "",
        //     "TEL1_NUMBR" => "",
        //     "TEL1_EXT" => "",
        //     "FAX_NUMBER" => "",
        //     "FAX_EXTENS" => "",
        //     "STREET_LNG" => "",
        //     "DISTRCT_NO" => "",
        //     "CHCKSTATUS" => "",
        //     "PBOXCIT_NO" => "",
        //     "TRANSPZONE" => "",
        //     "HOUSE_NO2" => "",
        //     "E_MAIL" => "",
        //     "STR_SUPPL3" => "",
        //     "TITLE" => "",
        //     "COUNTRYISO" => "",
        //     "LANGU_ISO" => "",
        //     "BUILD_LONG" => "",
        //     "REGIOGROUP" => "",
        //     "SUPP_VENDOR" => "",
        //     "CUSTOMER" => "",
        //     "SC_VENDOR" => "",
        // ];

        // $params[0]['POADDRDELIVERY'] = $POADDRDELIVERY;
        // $POADDRVENDOR = [
        //     'PO_NUMBER' => '',
        //     'ADDR_NO' => '',
        //     'FORMOFADDR' => '',
        //     'NAME' => '',
        //     'NAME_2' => '',
        //     'NAME_3' => '',
        //     'NAME_4' => '',
        //     'C_O_NAME' => '',
        //     'CITY' => '',
        //     'DISTRICT' => '',
        //     'CITY_NO' => '',
        //     'POSTL_COD1' => '',
        //     'POSTL_COD2' => '',
        //     'POSTL_COD3' => '',
        //     'PO_BOX' => '',
        //     'PO_BOX_CIT' => '',
        //     'DELIV_DIS' => '',
        //     'STREET' => '',
        //     'STREET_NO' => '',
        //     'STR_ABBR' => '',
        //     'HOUSE_NO' => '',
        //     'STR_SUPPL1' => '',
        //     'STR_SUPPL2' => '',
        //     'LOCATION' => '',
        //     'BUILDING' => '',
        //     'FLOOR' => '',
        //     'ROOM_NO' => '',
        //     'COUNTRY' => '',
        //     'LANGU' => '',
        //     'REGION' => '',
        //     'SORT1' => '',
        //     'SORT2' => '',
        //     'TIME_ZONE' => '',
        //     'TAXJURCODE' => '',
        //     'ADR_NOTES' => '',
        //     'COMM_TYPE' => '',
        //     'TEL1_NUMBR' => '',
        //     'TEL1_EXT' => '',
        //     'FAX_NUMBER' => '',
        //     'FAX_EXTENS' => '',
        //     'STREET_LNG' => '',
        //     'DISTRCT_NO' => '',
        //     'CHCKSTATUS' => '',
        //     'PBOXCIT_NO' => '',
        //     'TRANSPZONE' => '',
        //     'HOUSE_NO2' => '',
        //     'E_MAIL' => '',
        //     'STR_SUPPL3' => '',
        //     'TITLE' => '',
        //     'COUNTRYISO' => '',
        //     'LANGU_ISO' => '',
        //     'BUILD_LONG' => '',
        //     'REGIOGROUP' => ''
        // ];
        // $params[0]['POADDRVENDOR'] = $POADDRVENDOR;
        // $POCOMPONENTS = [
        //     "PO_ITEM" => "",
        //     "SCHED_LINE" => "",
        //     "ITEM_NO" => "",
        //     "MATERIAL" => "",
        //     "ENTRY_QUANTITY" => "",
        //     "ENTRY_UOM" => "",
        //     "ENTRY_UOM_ISO" => "",
        //     "FIXED_QUAN" => "",
        //     "PLANT" => "",
        //     "REQ_DATE" => "",
        //     "CHANGE_ID" => "",
        //     "MATERIAL_EXTERNAL" =>"",
        //     "MATERIAL_GUID" => "",
        //     "MATERIAL_VERSION" => "",
        //     "ITEM_CAT" => "",
        //     "REQ_QUAN" => "",
        //     "BASE_UOM" => "",
        //     "BASE_UOM_ISO" => "",
        //     "PHANT_ITEM" => "",
        //     "BATCH" => "",
        //     "MAT_PROVISION" => "",
        //     "ISS_ST_LOC" => "",
        //     "REV_LEV" => "",
        //     "REQ_SEGMENT" => "",
        //     "MATERIAL_LONG" =>"",
        //     "REQ_SEG_LONG" =>"",
        // ];
        // $POCOMPONENTSX = [
        //     "PO_ITEM" => "",
        //     "SCHED_LINE" => "",
        //     "ITEM_NO" => "",
        //     "MATERIAL" => "",
        //     "ENTRY_QUANTITY" => "",
        //     "ENTRY_UOM" => "",
        //     "ENTRY_UOM_ISO" => "",
        //     "FIXED_QUAN" => "",
        //     "PLANT" => "",
        //     "REQ_DATE" => "",
        //     "CHANGE_ID" => "",
        //     "MATERIAL_EXTERNAL" =>"",
        //     "MATERIAL_GUID" => "",
        //     "MATERIAL_VERSION" => "",
        //     "ITEM_CAT" => "",
        //     "REQ_QUAN" => "",
        //     "BASE_UOM" => "",
        //     "BASE_UOM_ISO" => "",
        //     "PHANT_ITEM" => "",
        //     "BATCH" => "",
        //     "MAT_PROVISION" => "",
        //     "ISS_ST_LOC" => "",
        //     "REV_LEV" => "",
        //     "REQ_SEGMENT" => "",
        //     "MATERIAL_LONG" =>"",
        //     "REQ_SEG_LONG" =>"",
        // ];
        // $params[0]['POCOMPONENTS'] = $POCOMPONENTS;
        // $params[0]['POCOMPONENTSX'] = $POCOMPONENTSX;
        // $POCOND = [
        //     "CONDITION_NO" => "",
        //     "ITM_NUMBER" => "",
        //     "COND_ST_NO" => "",
        //     "CONDITION_NOX" => "",
        //     "ITM_NUMBERX" => "",
        //     "COND_ST_NOX" => "",
        //     "COND_COUNT" => "",
        //     "COND_TYPE" => "",
        //     "COND_VALUE" => "",
        //     "CURRENCY" => "",
        //     "CURRENCY_ISO" => "",
        //     "COND_UNIT" => "",
        //     "COND_UNIT_ISO" => "",
        //     "COND_P_UNT" => "",
        //     "APPLICATIO" => "",
        //     "CONPRICDAT" => "",
        //     "CALCTYPCON" => "",
        //     "CONBASEVAL" => "",
        //     "CONEXCHRAT" => "",
        //     "NUMCONVERT" => "",
        //     "DENOMINATO" => "",
        //     "CONDTYPE" => "",
        //     "STAT_CON" => "",
        //     "SCALETYPE" => "",
        //     "ACCRUALS" => "",
        //     "CONINVOLST" => "",
        //     "CONDORIGIN" => "",
        //     "GROUPCOND" => "",
        //     "COND_UPDAT" => "",
        //     "ACCESS_SEQ" => "",
        //     "CONDCOUNT" => "",
        //     "CONDCNTRL" => "",
        //     "CONDISACTI" => "",
        //     "CONDCLASS" => "",
        //     "FACTBASVAL" => "",
        //     "SCALEBASIN" => "",
        //     "SCALBASVAL" => "",
        //     "UNITMEASUR" => "",
        //     "UNITMEASUR_ISO" => "",
        //     "CURRENCKEY" => "",
        //     "CURRENCKEY_ISO" => "",
        //     "CONDINCOMP" => "",
        //     "CONDCONFIG" => "",
        //     "CONDCHAMAN" => "",
        //     "COND_NO" => "",
        //     "CHANGE_ID" => "",
        //     "VENDOR_NO" => "",
        //     "ACCESS_SEQ_LONG" => "",
        //     "COND_COUNT_LONG" => ""
        // ];

        // $params[0]['POCOND'] = $POCOND;
        // $POCONDHEADER = [
        //     "CONDITION_NO" => "",
        //     "ITM_NUMBER" => "",
        //     "COND_ST_NO" => "",
        //     "COND_COUNT" => "",
        //     "COND_TYPE" => "",
        //     "COND_VALUE" => "",
        //     "CURRENCY" => "",
        //     "CURRENCY_ISO" => "",
        //     "COND_UNIT" => "",
        //     "COND_UNIT_ISO" => "",
        //     "COND_P_UNT" => "",
        //     "APPLICATIO" => "",
        //     "CONPRICDAT" => "",
        //     "CALCTYPCON" => "",
        //     "CONBASEVAL" => "",
        //     "CONEXCHRAT" => "",
        //     "NUMCONVERT" => "",
        //     "DENOMINATO" => "",
        //     "CONDTYPE" => "",
        //     "STAT_CON" => "",
        //     "SCALETYPE" => "",
        //     "ACCRUALS" => "",
        //     "CONINVOLST" => "",
        //     "CONDORIGIN" => "",
        //     "GROUPCOND" => "",
        //     "COND_UPDAT" => "",
        //     "ACCESS_SEQ" => "",
        //     "CONDCOUNT" => "",
        //     "CONDCNTRL" => "",
        //     "CONDISACTI" => "",
        //     "CONDCLASS" => "",
        //     "FACTBASVAL" => "",
        //     "SCALEBASIN" => "",
        //     "SCALBASVAL" => "",
        //     "UNITMEASUR" => "",
        //     "UNITMEASUR_ISO" => "",
        //     "CURRENCKEY" => "",
        //     "CURRENCKEY_ISO" => "",
        //     "CONDINCOMP" => "",
        //     "CONDCONFIG" => "",
        //     "CONDCHAMAN" => "",
        //     "COND_NO" => "",
        //     "CHANGE_ID" => "",
        //     "VENDOR_NO" => "",
        //     "ACCESS_SEQ_LONG" => "",
        //     "COND_COUNT_LONG" => "",
        // ];
        // $POCONDHEADERX = [
        //     "CONDITION_NO" => "",
        //     "ITM_NUMBER" => "",
        //     "COND_ST_NO" => "",
        //     "COND_COUNT" => "",
        //     "COND_TYPE" => "",
        //     "COND_VALUE" => "",
        //     "CURRENCY" => "",
        //     "CURRENCY_ISO" => "",
        //     "COND_UNIT" => "",
        //     "COND_UNIT_ISO" => "",
        //     "COND_P_UNT" => "",
        //     "APPLICATIO" => "",
        //     "CONPRICDAT" => "",
        //     "CALCTYPCON" => "",
        //     "CONBASEVAL" => "",
        //     "CONEXCHRAT" => "",
        //     "NUMCONVERT" => "",
        //     "DENOMINATO" => "",
        //     "CONDTYPE" => "",
        //     "STAT_CON" => "",
        //     "SCALETYPE" => "",
        //     "ACCRUALS" => "",
        //     "CONINVOLST" => "",
        //     "CONDORIGIN" => "",
        //     "GROUPCOND" => "",
        //     "COND_UPDAT" => "",
        //     "ACCESS_SEQ" => "",
        //     "CONDCOUNT" => "",
        //     "CONDCNTRL" => "",
        //     "CONDISACTI" => "",
        //     "CONDCLASS" => "",
        //     "FACTBASVAL" => "",
        //     "SCALEBASIN" => "",
        //     "SCALBASVAL" => "",
        //     "UNITMEASUR" => "",
        //     "UNITMEASUR_ISO" => "",
        //     "CURRENCKEY" => "",
        //     "CURRENCKEY_ISO" => "",
        //     "CONDINCOMP" => "",
        //     "CONDCONFIG" => "",
        //     "CONDCHAMAN" => "",
        //     "COND_NO" => "",
        //     "CHANGE_ID" => "",
        //     "VENDOR_NO" => "",
        //     "ACCESS_SEQ_LONG" => "",
        //     "COND_COUNT_LONG" => "",
        // ];
        // $params[0]['POCONDHEADER'] = $POCONDHEADER;
        // $params[0]['POCONDHEADERX'] = $POCONDHEADERX;
        // $POCONDX = [
        //     "CONDITION_NO" => "",
        //     "ITM_NUMBER" => "",
        //     "COND_ST_NO" => "",
        //     "CONDITION_NOX" => "",
        //     "ITM_NUMBERX" => "",
        //     "COND_ST_NOX" => "",
        //     "COND_COUNT" => "",
        //     "COND_TYPE" => "",
        //     "COND_VALUE" => "",
        //     "CURRENCY" => "",
        //     "CURRENCY_ISO" => "",
        //     "COND_UNIT" => "",
        //     "COND_UNIT_ISO" => "",
        //     "COND_P_UNT" => "",
        //     "APPLICATIO" => "",
        //     "CONPRICDAT" => "",
        //     "CALCTYPCON" => "",
        //     "CONBASEVAL" => "",
        //     "CONEXCHRAT" => "",
        //     "NUMCONVERT" => "",
        //     "DENOMINATO" => "",
        //     "CONDTYPE" => "",
        //     "STAT_CON" => "",
        //     "SCALETYPE" => "",
        //     "ACCRUALS" => "",
        //     "CONINVOLST" => "",
        //     "CONDORIGIN" => "",
        //     "GROUPCOND" => "",
        //     "COND_UPDAT" => "",
        //     "ACCESS_SEQ" => "",
        //     "CONDCOUNT" => "",
        //     "CONDCNTRL" => "",
        //     "CONDISACTI" => "",
        //     "CONDCLASS" => "",
        //     "FACTBASVAL" => "",
        //     "SCALEBASIN" => "",
        //     "SCALBASVAL" => "",
        //     "UNITMEASUR" => "",
        //     "UNITMEASUR_ISO" => "",
        //     "CURRENCKEY" => "",
        //     "CURRENCKEY_ISO" => "",
        //     "CONDINCOMP" => "",
        //     "CONDCONFIG" => "",
        //     "CONDCHAMAN" => "",
        //     "COND_NO" => "",
        //     "CHANGE_ID" => "",
        //     "VENDOR_NO" => "",
        //     "ACCESS_SEQ_LONG" => "",
        //     "COND_COUNT_LONG" => ""
        // ];

        // $params[0]['POCONDX'] = $POCONDX;
        // $POCONTRACTLIMITS = [
        //     "PCKG_NO" => "",
        //     "LINE_NO" =>  "",
        //     "CON_NUMBER" => "",
        //     "CON_ITEM" =>  "",
        //     "LIMIT" =>  "",
        //     "NO_LIMIT" =>  "",
        //     "PRICE_CHG" =>  "",
        //     "SHORT_TEXT" =>  "",
        //     "DELETE_IND" => "",
        // ];
        // $params[0]['POCONTRACTLIMITS'] = $POCONTRACTLIMITS;
        // $POEXPIMPHEADER = [
        //     'TRANSPORT_MODE' => '',
        //     'CUSTOMS' => ''
        // ];
        // $params[0]['POEXPIMPHEADER'] = $POEXPIMPHEADER;
        // $POEXPIMPHEADERX = [
        //     'TRANSPORT_MODE' => '',
        //     'CUSTOMS' => ''
        // ];
        // $params[0]['POEXPIMPHEADERX'] = $POEXPIMPHEADERX;
        // $POEXPIMPITEM = [
        //     "PO_ITEM" => "",
        //     "BUSINESS_TRANSACTION_TYPE" => "",
        //     "EXPORT_IMPORT_PROCEDURE" => "",
        //     "COUNTRYORI" => "",
        //     "COUNTRYORI_ISO" => "",
        //     "REGIONORIG" => "",
        //     "COMM_CODE" => "",
        //     "SHIPPING_COUNTRY" => "",
        //     "SHIPPING_COUNTRY_ISO" => "",
        // ];
        // $POEXPIMPITEMX = [
        //     "PO_ITEM" => "",
        //     "BUSINESS_TRANSACTION_TYPE" => "",
        //     "EXPORT_IMPORT_PROCEDURE" => "",
        //     "COUNTRYORI" => "",
        //     "COUNTRYORI_ISO" => "",
        //     "REGIONORIG" => "",
        //     "COMM_CODE" => "",
        //     "SHIPPING_COUNTRY" => "",
        //     "SHIPPING_COUNTRY_ISO" => "",
        // ];
        // $params[0]['POEXPIMPITEM'] =  $POEXPIMPITEM;
        // $params[0]['POEXPIMPITEMX'] = $POEXPIMPITEMX;
        $POHEADER = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => 'Z301',
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '0003000046',
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
            'CURRENCY' => 'IDR',
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
        $POITEM = [
            'PO_ITEM' => '00010',//LINE
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
            'NET_PRICE' => '1000000',
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
            'PREQ_NO' => '1000019608',
            'PREQ_ITEM' => '00010',
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
        $params[0]['POITEM']['item'] = $POITEM;
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
        $params[0]['POITEMX']['item'] = $POITEMX;
        // $POLIMITS = [
        //     "PCKG_NO" => "",
        //     "LIMIT" => "",
        //     "NO_LIMIT" => "",
        //     "EXP_VALUE" => "",
        //     "SSC_EXIST" => "",
        //     "CON_EXIST" => "",
        //     "TMP_EXIST" => "",
        //     "PRICE_CHG" => "",
        //     "FREE_LIMIT" => "",
        //     "NO_FRLIMIT" => "",
        //     "SERV_TYPE" => "",
        //     "EDITION" => "",
        //     "SSC_LIMIT" => "",
        //     "SSC_NOLIM" => "",
        //     "SSC_PRSCHG" => "",
        //     "SSC_PERC" => "",
        //     "TMP_NUMBER" => "",
        //     "TMP_LIMIT" => "",
        //     "TMP_NOLIM" => "",
        //     "TMP_PRSCHG" => "",
        //     "TMP_PERC" => "",
        //     "CONT_PERC" => "",
        // ];
        // $params[0]['POLIMITS'] = $POLIMITS;
        // $POPARTNER = [
        //     "PARTNERDESC"=> "",
        //     "LANGU" => "",
        //     "BUSPARTNO" => "",
        //     "DELETE_IND" => "",
        // ];
        // $params[0]['POPARTNER'] = $POPARTNER;
        // $POSCHEDULE = [
        //     "PO_ITEM" => "",
        //     "SCHED_LINE" => "",
        //     "DEL_DATCAT_EXT" => "",
        //     "DELIVERY_DATE" => "",
        //     "QUANTITY" => "",
        //     "DELIV_TIME" => "",
        //     "STAT_DATE" => "",
        //     "PREQ_NO" => "",
        //     "PREQ_ITEM" => "",
        //     "PO_DATE" => "",
        //     "ROUTESCHED" => "",
        //     "MS_DATE" => "",
        //     "MS_TIME" => "",
        //     "LOAD_DATE" => "",
        //     "LOAD_TIME" => "",
        //     "TP_DATE" => "",
        //     "TP_TIME" => "",
        //     "GI_DATE" => "",
        //     "GI_TIME" => "",
        //     "DELETE_IND" => "",
        //     "REQ_CLOSED" => "",
        //     "GR_END_DATE" => "",
        //     "GR_END_TIME" => "",
        //     "COM_QTY" => "",
        //     "COM_DATE" => "",
        //     "GEO_ROUTE" => "",
        //     "HANDOVERDATE" => "",
        //     "HANDOVERTIME" => "",
        // ];
        // $POSCHEDULEX = [
        //     "PO_ITEM" => "",
        //     "SCHED_LINE" => "",
        //     "DEL_DATCAT_EXT" => "",
        //     "DELIVERY_DATE" => "",
        //     "QUANTITY" => "",
        //     "DELIV_TIME" => "",
        //     "STAT_DATE" => "",
        //     "PREQ_NO" => "",
        //     "PREQ_ITEM" => "",
        //     "PO_DATE" => "",
        //     "ROUTESCHED" => "",
        //     "MS_DATE" => "",
        //     "MS_TIME" => "",
        //     "LOAD_DATE" => "",
        //     "LOAD_TIME" => "",
        //     "TP_DATE" => "",
        //     "TP_TIME" => "",
        //     "GI_DATE" => "",
        //     "GI_TIME" => "",
        //     "DELETE_IND" => "",
        //     "REQ_CLOSED" => "",
        //     "GR_END_DATE" => "",
        //     "GR_END_TIME" => "",
        //     "COM_QTY" => "",
        //     "COM_DATE" => "",
        //     "GEO_ROUTE" => "",
        //     "HANDOVERDATE" => "",
        //     "HANDOVERTIME" => "",
        // ];
        // $params[0]['POSCHEDULE'] = $POSCHEDULE;
        // $params[0]['POSCHEDULEX'] = $POSCHEDULEX;
        // $POSERVICES = [
        //     'PCKG_NO' => '',
        //     'LINE_NO' => '',
        //     'EXT_LINE' => '',
        //     'OUTL_LEVEL' => '',
        //     'OUTL_NO' => '',
        //     'OUTL_IND' => '',
        //     'SUBPCKG_NO' => '',
        //     'SERVICE' => '',
        //     'SERV_TYPE' => '',
        //     'EDITION' => '',
        //     'SSC_ITEM' => '',
        //     'EXT_SERV' => '',
        //     'QUANTITY' => '',
        //     'BASE_UOM' => '',
        //     'UOM_ISO' => '',
        //     'OVF_TOL' => '',
        //     'OVF_UNLIM' => '',
        //     'PRICE_UNIT' => '',
        //     'GR_PRICE' => '',
        //     'FROM_LINE' => '',
        //     'TO_LINE' => '',
        //     'SHORT_TEXT' => '',
        //     'DISTRIB' => '',
        //     'PERS_NO' => '',
        //     'WAGETYPE' => '',
        //     'PLN_PCKG' => '',
        //     'PLN_LINE' => '',
        //     'CON_PCKG' => '',
        //     'CON_LINE' => '',
        //     'TMP_PCKG' => '',
        //     'TMP_LINE' => '',
        //     'SSC_LIM' => '',
        //     'LIMIT_LINE' => '',
        //     'TARGET_VAL' => '',
        //     'BASLINE_NO' => '',
        //     'BASIC_LINE' => '',
        //     'ALTERNAT' => '',
        //     'BIDDER' => '',
        //     'SUPP_LINE' => '',
        //     'OPEN_QTY' => '',
        //     'INFORM' => '',
        //     'BLANKET' => '',
        //     'EVENTUAL' => '',
        //     'TAX_CODE' => '',
        //     'TAXJURCODE' => '',
        //     'PRICE_CHG' => '',
        //     'MATL_GROUP' => '',
        //     'DATE' => '',
        //     'BEGINTIME' => '',
        //     'ENDTIME' => '',
        //     'EXTPERS_NO' => '',
        //     'FORMULA' => '',
        //     'FORM_VAL1' => '',
        //     'FORM_VAL2' => '',
        //     'FORM_VAL3' => '',
        //     'FORM_VAL4' => '',
        //     'FORM_VAL5' => '',
        //     'USERF1_NUM' => '',
        //     'USERF2_NUM' => '',
        //     'USERF1_TXT' => '',
        //     'USERF2_TXT' => '',
        //     'HI_LINE_NO' => '',
        //     'EXTREFKEY' => '',
        //     'DELETE_IND' => '',
        //     'PER_SDATE' => '',
        //     'PER_EDATE' => '',
        //     'EXTERNAL_ITEM_ID' => '',
        //     'SERVICE_ITEM_KEY' => '',
        //     'NET_VALUE' => '',
        // ];
        // $params[0]['POSERVICES'] = $POSERVICES;
        // $POSERVICESTEXT = [
        //     "PCKG_NO" => "",
        //     "LINE_NO" => "",
        //     "TEXT_ID" => "",
        //     "FORMAT_COL" => "",
        //     "TEXT_LINE" => "",
        // ];
        // $params[0]['POSERVICESTEXT'] = $POSERVICESTEXT;
        // $POSHIPPING = [
        // 	"PO_ITEM" => "",
        //     "SHIP_POINT" => "",
        //     "SHIP_COND" => "",
        //     "DLV_PRIO" => "",
        //     "ROUTE" => "",
        //     "UNLOAD_PT" => "",
        //     "AUTH_NUMBER" => "",
        //     "SRC_DLV_NO" => "",
        //     "SRC_HANDLG_UNIT" => "",
        //     "INSPOUT_GUID" => "",
        //     "FOLLOW_UP" => "",
        //     "LOADINGGRP" => "",
        //     "TRANS_GRP" => "",
        // ];
        // $params[0]['POSHIPPING'] = $POSHIPPING;
        // $POSHIPPINGEXP = [
        //     "PO_ITEM" => "",
        //     "SHIP_POINT" => "",
        //     "DLV_PRIO" => "",
        //     "ROUTE" => "",
        //     "CUSTOMER" => "",
        //     "SOLD_TO" => "",
        //     "FWDAGENT" => "",
        //     "SALESORG" => "",
        //     "DISTR_CHAN" => "",
        //     "DIVISION" => "",
        //     "DEL_CREATE_DATE" => "",
        //     "PLND_DELRY" => "",
        //     "LANGU" => "",
        //     "LANGU_ISO" => "",
        //     "SHIP_COND" => "",
        //     "LOADINGGRP" => "",
        //     "TRANS_GRP" => "",
        //     "UNLOAD_PT" => "",
        //     "ORDCOMBIND" => "",
        //     "TIME_ZONE" => "",
        //     "AUTH_NUMBER" => "",
        //     "SRC_DLV_NO" => "",
        //     "SRC_HANDLG_UNIT" => "",
        //     "INSPOUT_GUID" => "",
        //     "FOLLOW_UP" => "",
        // ];
        // $params[0]['POSHIPPINGEXP'] = $POSHIPPINGEXP;
        // $POSHIPPINGX = [
        // 	"PO_ITEM" => "",
        //     "SHIP_POINT" => "",
        //     "SHIP_COND" => "",
        //     "DLV_PRIO" => "",
        //     "ROUTE" => "",
        //     "UNLOAD_PT" => "",
        //     "AUTH_NUMBER" => "",
        //     "SRC_DLV_NO" => "",
        //     "SRC_HANDLG_UNIT" => "",
        //     "INSPOUT_GUID" => "",
        //     "FOLLOW_UP" => "",
        //     "LOADINGGRP" => "",
        //     "TRANS_GRP" => "",
        // ];
        // $params[0]['POSHIPPINGX'] = $POSHIPPINGX;
        // $POSRVACCESSVALUES = [
        //     "PCKG_NO" => "",
        //     "LINE_NO" => "",
        //     "SERNO_LINE" => "",
        //     "PERCENTAGE" => "",
        //     "SERIAL_NO" => "",
        //     "QUANTITY" => "",
        //     "NET_VALUE" => "",
        // ];
        // $params[0]['POSRVACCESSVALUES'] = $POSRVACCESSVALUES;
        // $POTEXTHEADER = [
        //     'PO_NUMBER' => '',
        //     'PO_ITEM' => '00010',
        //     'TEXT_ID' => 'EKKO',
        //     'TEXT_FORM' => 'EN',
        //     'TEXT_LINE' => 'TEST EPROC'
        // ];
        // $params[0]['POTEXTHEADER'] = $POTEXTHEADER;
        // $POTEXTITEM = [
        //     'PO_NUMBER' => '',
        //     'PO_ITEM' => '00010',
        //     'TEXT_ID' => 'EKPO',
        //     'TEXT_FORM' => 'EN',
        //     'TEXT_LINE' => 'TEST ITEM'
        // ];
        // $params[0]['POTEXTITEM'] = $POTEXTITEM;
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
        // $SERIALNUMBER = [
        //     "PO_ITEM"  => "",
        //     "SCHED_LINE"  => "",
        //     "PO_ITEMX"  => "",
        //     "SCHED_LINEX"  => "",
        //     "DELETE_IND"  => "",
        //     "SERIALNO"  => "",
        //     "UII" =>"",
        // ];
        // $SERIALNUMBERX = [
        //     "PO_ITEM"  => "",
        //     "SCHED_LINE"  => "",
        //     "PO_ITEMX"  => "",
        //     "SCHED_LINEX"  => "",
        //     "DELETE_IND"  => "",
        //     "SERIALNO"  => "",
        //     "UII" =>"",
        // ];
        // $params[0]['SERIALNUMBER'] = $SERIALNUMBER;
        // $params[0]['SERIALNUMBERX'] = $SERIALNUMBERX;
        // $params[0]['TESTRUN'] = '';
        // $VERSIONS = [
        //     'POST_DATE' => '',
        //     'COMPLETED' => '',
        //     'REASON' => '',
        //     'DESCRIPTION' => '',
        //     'REQ_BY' => '',
        //     'REQ_BY_EXT' => '',
        //     'ACTIVITY' => ''
        // ];
        // $params[0]['VERSIONS'] = $VERSIONS;
        // dd($params);
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