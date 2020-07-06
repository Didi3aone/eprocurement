<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use App\Models\Vendor\Billing;
use App\Models\Vendor\BillingDetail;
use App\Models\PurchaseOrderGr;
use App\Models\PaymentTerm;
use App\Models\MasterPph;
use App\Models\Currency;
use App\Models\MasterBankHouse;
use Symfony\Component\HttpFoundation\Response;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spv = 0;
        $billing = Billing::where('is_spv', $spv)->get();

        return view('admin.billing.index', compact('billing'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listSpv()
    {
        $spv = 1;

        $billing = Billing::where('is_spv', $spv)->get();

        return view('admin.billing.index-spv', compact('billing'));
    }
 
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing = Billing::find($id);
        $payments = PaymentTerm::all();
        $tipePphs = MasterPph::all();
        $currency = Currency::all();
        $bankHouse = MasterBankHouse::all();

        return view('admin.billing.show', compact('billing', 'bankHouse','payments', 'tipePphs','currency'));
    }

    public function edit ($id)
    {
        $billing = Billing::find($id);
        $payments = PaymentTerm::all();
        $tipePphs = MasterPph::all();
        $currency = Currency::all();
        $bankHouse = MasterBankHouse::all();

        return view('admin.billing.edit', compact('billing', 'bankHouse','payments', 'tipePphs','currency'));
    }

    public function store (Request $request)
    {
        // foreach ($request->get('po_no') as $key => $val) {
        //     $data = [
        //         'po_no' => $request->get('po_no')[$key],
        //         'posting_date' => $request->get('posting_date')[$key],
        //     ];

        //     $this->_sendToSap($data);
        // }

        \Session::flash('status','Billing has been approved');
        return \redirect()->route('admin.billing-spv-list');
    }

    public function storeApproved(Request $request)
    {
        $billing = Billing::find($request->id);
        $billing->status = Billing::Approved;
        $billing->assignment = $request->assignment;
        $billing->payment_term_claim  = $request->payment_term_claim;
        $billing->tipe_pph = $request->tipe_pph;
        $billing->jumlah_pph = $request->jumlah_pph;
        $billing->currency = $request->currency;
        $billing->perihal_claim = $request->perihal_claim;
        $billing->house_bank = $request->house_bank;
        $billing->exchange_rate  = $request->exchange_rate   ;
        $billing->is_spv = 1;
        $billing->update();

        foreach( $request->iddetail as $key => $rows ) {
            $detail = BillingDetail::find($rows);
            $detail->amount = $request->amount[$key];
        }

        \Session::flash('status','Billing has been approved');
        return \redirect()->route('admin.billing');
    }
    
    public function storeRejected(Request $request)
    {
        $billing = Billing::find($request->id);
        $billing->status = Billing::Rejected;
        $billing->reason_rejected = $request->reason;
        $billing->update();

        \Session::flash('status','Billing has been rejected');
    }

    protected function _sendToSap ($data)
    {
        $purchaseOrder = PurchaseOrder::where('PO_NUMBER', $data['po_no'])->first();
        $docType = $purchaseOrder->doc_type;

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

        $HEADER = [
            'INVOICE_IND' => 'X',
            'DOC_TYPE' => 'RE',
            'DOC_DATE' => date('Y-m-d'),
            'PSTNG_DATE' => $data['posting_date'],
            'REF_DOC_NO' => $data['document_no'],
            'COMP_CODE' => '1100',
            'DIFF_INV' => '',
            'CURRENCY' => $data['currency'],
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => $data['exchange_rate'],
            'EXCH_RATE_V' => '',
            'GROSS_AMOUNT' => $data['amount'],
            'CALC_TAX_IND' => 'X',
            'PMNTTRMS' => '',
            'BLINE_DATE' => '',
            'DSCT_DAYS' => '',
            'DSCT_DAYS2' => '',
            'NETTERMS' => '',
            'DSCT_PCT' => '',
            'DSCT_PCT2' => '',
            'IV_CATEGORY' => '',
            'HEADER_TXT' => '',
            'PMNT_BLOCK' => '',
            'DEL_COSTS' => '',
            'DEL_COSTS_TAXC' => '',
            'DEL_COSTS_TAXJ' => '',
            'PERSON_EXT' => '',
            'PYMT_METH' => 'T',
            'PMTMTHSUPL' => '',
            'INV_DOC_NO' => '',
            'SCBANK_IND' => '',
            'SUPCOUNTRY' => '',
            'BLLSRV_IND' => '',
            'REF_DOC_NO_LONG' => '',
            'DSCT_AMOUNT' => '',
            'PO_SUB_NO' => '',
            'PO_CHECKDG' => '',
            'PO_REF_NO' => '',
            'PAYEE_PAYER' => '',
            'PARTNER_BK' => '',
            'HOUSEBANKID' => '',
            'ALLOC_NMBR' => '',
            'PAYMT_REF' => '',
            'INV_REF_NO' => '',
            'INV_YEAR' => '',
            'INV_REC_DATE' => '',
            'PLANNING_LEVEL' => '',
            'PLANNING_DATE' => '',
            'FIXEDTERMS' => '',
            'BUS_AREA' => '',
            'LOT_NUMBER' => '',
            'ITEM_TEXT' => '',
            'J_BNFTYPE' => '',
            'EU_TRIANG_DEAL' => '',
            'REPCOUNTRY' => '',
            'VAT_REG_NO' => '',
            'BUSINESS_PLACE' => '',
            'TAX_EXCH_RATE' => '',
            'GOODS_AFFECTED' => '',
            'RET_DUE_PROP' => '',
            'DELIV_POSTING' => '',
            'RETURN_POSTING' => '',
            'INV_TRAN' => '',
            'SIMULATION' => '',
            'J_TPBUPL' => '',
            'SECCO' => '',
            'VATDATE' => '',
            'DE_CRE_IND' => '',
            'TRANS_DATE' => '',
        ];

        $ITEMDATA = [
            'INVOICE_DOC_ITEM' => '',
            'PO_NUMBER' => '',
            'PO_ITEM' => '',
            'REF_DOC' => '',
            'REF_DOC_YEAR' => '',
            'REF_DOC_IT' => '',
            'DE_CRE_IND' => '',
            'TAX_CODE' => '',
            'TAXJURCODE' => '',
            'ITEM_AMOUNT' => '',
            'QUANTITY' => '',
            'PO_UNIT' => '',
            'PO_UNIT_ISO' => '',
            'PO_PR_QNT' => '',
            'PO_PR_UOM' => '',
            'PO_PR_UOM_ISO' => '',
            'COND_TYPE' => '',
            'COND_ST_NO' => '',
            'COND_COUNT' => '',
            'SHEET_NO' => '',
            'ITEM_TEXT' => '',
            'FINAL_INV' => '',
            'SHEET_ITEM' => '',
            'GRIR_CLEAR_SRV' => '',
            'FREIGHT_VEN' => '',
            'CSHDIS_IND' => '',
            'RETENTION_DOCU_CURRENCY' => '',
            'RETENTION_PERCENTAGE' => '',
            'RETENTION_DUE_DATE' => '',
            'NO_RETENTION' => '',
            'VALUATION_TYPE' => '',
            'INV_RELATION' => '',
            'INV_ITM_ORIGIN' => '',
            'COND_COUNT_LONG' => '',
            'DEL_CREATE_DATE' => '',
        ];

        $RETURN = [
            'TYPE' => '',
            'ID' => '',
            'NUMBER' => '',
            'MESSAGE' => '',
            'LOG_NO' => '',
            'LOG_MSG_NO' => '',
            'MESSAGE_V' => '',
            'MESSAGE_V2' => '',
            'MESSAGE_V3' => '',
            'MESSAGE_V4' => '',
            'PARAMETER' => '',
            'ROW' => '',
            'FIELD' => '',
            'SYSTEM' => '',
        ];

        // Z300 PO RM PM
        if ($docType == 'Z300') {
        } else if ($docType == 'Z301') { // indirect
        } else if ($docType == 'Z302') { // service
        } else if ($docType == 'Z303') { // asset prod march
        }
        $params[0]['HEADERDATA'] = $HEADER;
        $params[0]['ITEMDATA'] = $ITEMDATA;
        $params[0]['RETURN'] = $RETURN;

        $result = $client->__soapCall('ZFM_WS_MIRO', $params, null, $header);
        dd($result);
    }
}