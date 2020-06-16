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
            ->where('quotation_details.vendor_id', Auth::user()->code)
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
        $params[0]['POACCOUNT'] = array();
        $params[0]['POACCOUNTPROFITSEGMENT'] = array();
        $params[0]['POACCOUNTX'] = array();
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
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => '',
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '',
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
            'CURRENCY' => '',
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
        $params[0]['POHEADER'] = $POHEADER;
        $POHEADERX = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => '',
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '',
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
            'CURRENCY' => '',
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
        $params[0]['POITEM'] = array();
        $params[0]['POITEMX'] = array();
        $params[0]['POLIMITS'] = array();
        $params[0]['POPARTNER'] = array();
        $params[0]['POSCHEDULE'] = array();
        $params[0]['POSCHEDULEX'] = array();
        $params[0]['POSERVICES'] = array();
        $params[0]['POSERVICESTEXT'] = array();
        $params[0]['POSHIPPING'] = array();
        $params[0]['POSHIPPINGEXP'] = array();
        $params[0]['POSHIPPINGX'] = array();
        $params[0]['POSRVACCESSVALUES'] = array();
        $POTEXTHEADER = [
            'PO_NUMBER' => '',
            'PO_ITEM' => '',
            'TEXT_ID' => '',
            'TEXT_FORM' => '',
            'TEXT_LINE' => ''
        ];
        $params[0]['POTEXTHEADER'] = $POTEXTHEADER;
        $POTEXTITEM = [
            'PO_NUMBER' => '',
            'PO_ITEM' => '',
            'TEXT_ID' => '',
            'TEXT_FORM' => '',
            'TEXT_LINE' => ''
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
            'quotation.status',
            'quotation.po_no',
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