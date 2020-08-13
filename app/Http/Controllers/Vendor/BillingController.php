<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillingRequest;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\Vendor\Billing;
use App\Models\Vendor\BillingDetail;
use App\Models\Vendor\VendorTaxNumbers;
use App\Models\PurchaseOrderGr;
use App\Models\Vendor\VendorBankDetails;
use Auth;

class BillingController extends Controller
{
    public function index ()
    {
        // po yang sudah di gr
        $purchase_orders = PurchaseOrder::select(
            \DB::raw('purchase_orders.id as id'), 
            'purchase_orders.PO_NUMBER', 
            'purchase_orders.currency', 
            'purchase_orders_details.material_id', 
            'purchase_orders_details.PR_NO', 
            'purchase_orders_details.price',
            'purchase_orders_details.qty',
            'purchase_orders_details.description',
            'purchase_orders_details.unit',
            'purchase_requests_details.purchasing_group_code',
            'purchase_requests_details.plant_code',
            'purchase_requests_details.gl_acct_code',
            'purchase_requests_details.cost_center_code',
            'purchase_requests_details.co_area',
            'purchase_requests_details.profit_center_code',
            'purchase_requests_details.storage_location',
            'purchase_requests_details.co_area',
        )
            ->join('purchase_orders_details', 'purchase_orders_details.purchase_order_id', '=', 'purchase_orders.id')
            ->join('purchase_requests_details', 'purchase_requests_details.material_id', '=', 'purchase_orders_details.material_id')
            ->join('purchase_order_gr', 'purchase_order_gr.po_no', '=', 'purchase_orders.PO_NUMBER')
            ->where('purchase_orders.vendor_id', Auth::user()->code)
            ->where('purchase_requests_details.type_approval', 888)
            ->where('purchase_requests_details.status_approval', 704)
            ->where('purchase_requests_details.is_validate', 1)
            ->groupBy(
                'purchase_order_gr.material_no', 
                'purchase_orders.id', 
                'purchase_orders_details.material_id', 
                'purchase_orders_details.PR_NO',
                'purchase_orders_details.price',
                'purchase_orders_details.qty',
                'purchase_orders_details.description',
                'purchase_orders_details.unit',
                'purchase_requests_details.purchasing_group_code',
                'purchase_requests_details.plant_code',
                'purchase_requests_details.gl_acct_code',
                'purchase_requests_details.cost_center_code',
                'purchase_requests_details.co_area',
                'purchase_requests_details.profit_center_code',
                'purchase_requests_details.storage_location',
                'purchase_requests_details.co_area',
            )
            ->get();

        $data = [];
        foreach ($purchase_orders as $po) {
            // wsdl billing
            $gr = [
                'vendor_id' => Auth::user()->code,
                'po_no' => $po->PO_NUMBER,
                'item_po' => 00010,
                'material_id' => $po->material_id,
                'pr_no' => $po->PR_NO,
                'price' => $po->price,
                'qty' => $po->qty,
                'description' => $po->description,
                'unit' => $po->unit,
                'purchasing_group_code' => $po->purchasing_group_code,
                'plant' => $po->plant_code,
                'gl_acct' => $po->gl_acct_code,
                'cost_center' => $po->cost_center_code,
                'co_area' => $po->co_area,
                'profit_center' => $po->profit_center_code,
                'storage_location' => $po->storage_location,
                'currency' => $po->currency,
                'document_gr' => '5000001046',
                'tahun_gr' => '2019',
                'item_gr' => '0001',
                'reference_doc' => '5000001046',
                'material_document' => '',
                'material_document_item' => '0000',
                'delivery_completed' => 'X',
            ];

            // soap call
            // $wsdl = public_path() . "/xml/zbn_wms_do.xml";
            
            // $username = "IT_02";
            // $password = "ademsari";

            // $client = new \SoapClient($wsdl, array(
            //     'login' => $username,
            //     'password' => $password,
            //     'trace' => true
            // ));

            // $auth = ['Username' => $username, 'Password' => $password];
            // $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
            // $client->__setSoapHeaders($header);

            // $params = [];

            // <EBELN>3010000001</EBELN> no PO
            //    <EBELP>00010</EBELP> Item PO
            //    <LIFNR>0003000048</LIFNR> vendor
            //    <BWART>101</BWART> movement type
            //    <SHKZG>S</SHKZG> debit/credit (S itu debit / h itu credit)
            //    <MATNR>000000000005005752</MATNR> nomor material
            //    <MENGE>1000.0</MENGE> qty
            //    <DMBTR>5000.0</DMBTR> Amount in Local Currency
            //    <WERKS>1101</WERKS> plant
            //    <LGORT>A301</LGORT> sloc
            //    <CHARG/> batch
            //    <MEINS>ST</MEINS> satuan
            //    <WAERS>IDR</WAERS> currency
            //    <MBLNR>5000001046</MBLNR> doc GR
            //    <MJAHR>2019</MJAHR> tahun GR
            //    <ZEILE>0001</ZEILE> item GR
            //    <LFBNR>5000001046</LFBNR> Reference Document
            //    <LFPOS>0001</LFPOS> Reference Doc. Item
            //    <SMBLN/> Material Document
            //    <SMBLP>0000</SMBLP> Material Doc.Item
            //    <ELIKZ>X</ELIKZ> Delivery Completed
            //    <SAKTO/> G/L Account
            //    <PRCTR>0000110001</PRCTR> profit center

            // $GR = [];
            // $params[0]['GR'] = $GR;
            // $params[0]['EBELN'] = $gr['po_no'];
            // $params[0]['EBELP'] = $gr['item_po'];
            // $params[0]['LIFNR'] = $gr['vendor_id'];
            // $params[0]['BWART'] = $gr['po_no'];
            // $params[0]['SHKZG'] = 'S';
            // $params[0]['MATNR'] = $gr['material_id'];
            // $params[0]['MENGE'] = $gr['qty'];
            // $params[0]['DMBTR'] = $gr['price'];
            // $params[0]['WERKS'] = $gr['plant'];
            // $params[0]['LGORT'] = $gr['storage_location'];
            // $params[0]['CHARG'] = '';
            // $params[0]['MEINS'] = $gr['unit'];
            // $params[0]['WAERS'] = $gr['currency'];
            // $params[0]['MBLNR'] = $gr['document_gr'];
            // $params[0]['MJAHR'] = $gr['tahun_gr'];
            // $params[0]['ZEILE'] = $gr['item_gr'];
            // $params[0]['LFBNR'] = $gr['reference_doc'];
            // $params[0]['SMBLN'] = $gr['material_document'];
            // $params[0]['SMBLP'] = $gr['material_document_item'];
            // $params[0]['ELIKZ'] = $gr['delivery_completed'];
            // $params[0]['SAKTO'] = $gr['gl_acct'];
            // $params[0]['PRCTR'] = $gr['profit_center'];

            // $RETURN = [
            //     "TYPE" => "",
            //     "ID" => "",
            //     "NUMBER" => "",
            //     "MESSAGE" => "",
            //     "LOG_NO" => "",
            //     "LOG_MSG_NO" => "",
            //     "MESSAGE_V1" => "",
            //     "MESSAGE_V2" => "",
            //     "MESSAGE_V3" => "",
            //     "MESSAGE_V4" => "",
            //     "PARAMETER" => "",
            //     "ROW" => "",
            //     "FIELD" => "",
            //     "SYSTEM" => "0"
            // ];
            // $params[0]['RETURN'] = $RETURN;
            // // dd($params);
            // $result = $client->__soapCall('ZFM_WS_MIRO', $params, NULL, $header);
        }

        $billing = Billing::where('created_by', Auth::user()->id)
            ->get();

        return view('vendor.billing.index', compact('billing', 'purchase_orders'));
    }

    public function show($id)
    {
        $billing = Billing::find($id);

        return view('vendor.billing.show',compact('billing'));
    }

    public function create() 
    {
        $po_gr = PurchaseOrderGr::where('vendor_id', \Auth::user()->code)
            ->select('doc_gr')
            ->where('debet_credit','S')
            ->where('is_cancel',PurchaseOrderGr::NoCancel)
            ->groupBy('doc_gr')
            ->orderBy('doc_gr','asc')
            ->get();
        $rekening =  VendorBankDetails::where('vendor_id', \Auth::user()->id)
            ->get()
            ->pluck('account_no', 'id');
        $npwp = VendorTaxNumbers::where('vendor_id', \Auth::user()->id)
            ->first();

        return view('vendor.billing.create', compact('po_gr', 'rekening', 'npwp'));
    }

    public function store(StoreBillingRequest $request)
    {
        // dd($request);
        try {
            \DB::beginTransaction();
            // save file
            $filePoName = '';
            $suratJalan = '';
            $fileFakturName  = '';
            $fileInvoiceName = '';
            $fileBebasName = '';
            $path = 'billing/';

            if ($request->file('po')) {
                $filePo = $request->file('po');
                $filePoName = time() . $filePo->getClientOriginalName();
                $filePo->move(public_path() . '/files/uploads/', $filePoName);
            }

            if ($request->file('no_surat_jalan')) {
                $suratJalan = $request->file('no_surat_jalan');
                $suratJalanName = time() . $suratJalan->getClientOriginalName();
                $suratJalan->move(public_path() . '/files/uploads/', $suratJalanName);
            }

            if ($request->file('surat_ket_bebas_pajak')) {
                $fileBebas = $request->file('surat_ket_bebas_pajak');
                $fileBebasName = time() . $fileBebas->getClientOriginalName();
                $fileBebas->move(public_path() . '/files/uploads/', $fileBebasName);
            }
            
            if ($request->file('file_faktur')) {
                $fileFaktur = $request->file('file_faktur');
                $fileFakturName = time() . $fileFaktur->getClientOriginalName();
                $fileFaktur->move(public_path() . '/files/uploads/', $fileFakturName);
            }
            
            if ($request->file('file_invoice')) {
                $fileInvoice = $request->file('file_invoice');
                $fileInvoiceName = time() . $fileInvoice->getClientOriginalName();
                $fileInvoice->move(public_path() . '/files/uploads/', $fileInvoiceName);
            }

            $nominal_inv_after_ppn =  str_replace(',', '', $request->nominal_inv_after_ppn);

            $billing = new Billing;
            $billing->billing_no            = date('ymd').substr(time(),0,-25)."".time();
            $billing->tgl_faktur            = $request->tgl_faktur;
            $billing->no_faktur             = $request->no_faktur;
            $billing->no_invoice            = $request->no_invoice;
            $billing->tgl_invoice           = $request->tgl_invoice;
            $billing->nominal_inv_after_ppn = $nominal_inv_after_ppn;
            $billing->ppn                   = $request->ppn;
            $billing->dpp                   = str_replace(',','',$request->dpp);
            $billing->no_rekening           = $request->no_rekening;
            $billing->no_surat_jalan        = $suratJalanName;
            $billing->npwp                  = $request->npwp;
            $billing->surat_ket_bebas_pajak = $fileBebasName;
            $billing->po                    = $filePoName;
            $billing->keterangan_po         = $request->keterangan_po;
            $billing->file_faktur           = $fileFakturName;
            $billing->file_invoice          = $fileInvoiceName;
            $billing->vendor_id             = Auth::user()->code;
            $billing->save();

            foreach ($request->get('po_no') as $key => $val) {
                $po_no              = $request->get('po_no')[$key];
                $qty                = $request->get('qty')[$key];
                $qty_old            = $request->get('qty_old')[$key];
                $PO_ITEM            = $request->get('PO_ITEM')[$key];
                $material_no        = $request->get('material')[$key];
                $debet_credit       = $request->get('debet_credit')[$key];
                $qty_old            = $request->get('qty_old')[$key];

                $billingDetail                              = new BillingDetail;
                $billingDetail->billing_id                  = $billing->id;
                $billingDetail->po_no                       = $po_no;
                $billingDetail->qty                         = $qty;
                $billingDetail->qty_old                     = $qty_old;
                $billingDetail->PO_ITEM                     = $PO_ITEM;
                $billingDetail->material_id                 = $material_no;
                $billingDetail->debet_credit                = $debet_credit;
                $billingDetail->plant_code                  = $request->get('plant_code')[$key];
                $billingDetail->gl_account                  = $request->get('gl_account')[$key];
                $billingDetail->profit_center               = $request->get('profit_center')[$key];
                $billingDetail->amount                      = $request->get('amount')[$key];
                $billingDetail->material_document           = $request->get('material_document')[$key];
                $billingDetail->reference_document_item     = $request->get('reference_document_item')[$key];
                $billingDetail->doc_gr                      = $request->get('doc_gr')[$key]; 
                $billingDetail->currency                    = $request->get('currency')[$key];
                $billingDetail->item_gr                     = $request->get('item_gr')[$key];
                $billingDetail->storage_location            = $request->get('storage_location')[$key];
                $billingDetail->unit                        = $request->get('unit')[$key];
                $billingDetail->reference_document          = $request->get('reference_document')[$key];
                $billingDetail->price_per_pc                = $request->get('price_per_pc')[$key];
                $billingDetail->material_doc_item           = $request->get('material_doc_item')[$key];
                $billingDetail->cost_center_code            = $request->get('cost_center_code')[$key];
                $billingDetail->tahun_gr                    = $request->get('tahun_gr')[$key];
                $billingDetail->gr_date                     = $request->get('posting_date')[$key];
                $billingDetail->purchase_order_detail_id    = $request->get('purchase_order_detail_id')[$key];
                $billingDetail->item_category               = $request->get('item_category')[$key];
                $billingDetail->description                 = $request->get('description')[$key];
                $billingDetail->save();

                $po_gr = PurchaseOrderGr::where('po_no', $po_no)
                        ->where('po_item', $PO_ITEM)
                        ->where('doc_gr', $request->get('doc_gr')[$key])
                        // ->where('material_no', $material_no)
                        ->first();

                $po_gr->qty_billing = $qty;
                $po_gr->qty         = $qty_old - $qty;
                $po_gr->qty_old     = $qty_old;
                $po_gr->save();

                $poDetail = PurchaseOrdersDetail::where('id', $request->get('purchase_order_detail_id')[$key])->first();
                $poDetail->qty_billing += $qty;
                $poDetail->save();
            }

            \DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            return redirect()->route('vendor.billing-create')->withInput();
        }

        return redirect()->route('vendor.billing')->with('status', 'Billing has been successfully saved');
    }

    public function edit($id)
    {
        $billing = Billing::find($id);
        $details = BillingDetail::where('billing_id', $id)
            ->get();
        $rekening =  VendorBankDetails::where('vendor_id', \Auth::user()->id)
            ->get()
            ->pluck('account_no', 'id');

        return view('vendor.billing.edit',compact('billing', 'details','rekening'));
    }

    public function update(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            // save file
            $filePoName = '';
            $suratJalanName = '';
            $fileFakturName  = '';
            $fileInvoiceName = '';
            $fileBebasName = '';
            $path = 'billing/';

            if ($request->file('po') != null) {
                $filePo = $request->file('po');
                $filePoName = time() . $filePo->getClientOriginalName();
                $filePo->move(public_path() . '/files/uploads/', $filePoName);
            }

            if ($request->file('no_surat_jalan') != null) {
                $suratJalan = $request->file('no_surat_jalan');
                $suratJalanName = time() . $suratJalan->getClientOriginalName();
                $suratJalan->move(public_path() . '/files/uploads/', $suratJalanName);
            }

            if ($request->file('surat_ket_bebas_pajak') != null) {
                $fileBebas = $request->file('surat_ket_bebas_pajak');
                $fileBebasName = time() . $fileBebas->getClientOriginalName();
                $fileBebas->move(public_path() . '/files/uploads/', $fileBebasName);
            }
            
            if ($request->file('file_faktur') != null) {
                $fileFaktur = $request->file('file_faktur');
                $fileFakturName = time() . $fileFaktur->getClientOriginalName();
                $fileFaktur->move(public_path() . '/files/uploads/', $fileFakturName);
            }
            
            if ($request->file('file_invoice') != null) {
                $fileInvoice = $request->file('file_invoice');
                $fileInvoiceName = time() . $fileInvoice->getClientOriginalName();
                $fileInvoice->move(public_path() . '/files/uploads/', $fileInvoiceName);
            }

            $nominal_inv_after_ppn =  str_replace(',', '', $request->nominal_inv_after_ppn);

            $billing = Billing::find($id);
            $billing->tgl_faktur            = $request->tgl_faktur;
            $billing->no_faktur             = $request->no_faktur;
            $billing->no_invoice            = $request->no_invoice;
            $billing->tgl_invoice           = $request->tgl_invoice;
            $billing->nominal_inv_after_ppn = $nominal_inv_after_ppn;
            $billing->ppn                   = $request->ppn;
            $billing->dpp                   = $request->dpp;
            $billing->no_rekening           = $request->no_rekening;
            $billing->npwp                  = $request->npwp;
            $billing->status                = Billing::WaitingApprove;
            
            if( $suratJalanName != '' ) {
                $billing->no_surat_jalan        = $suratJalanName;
            }
            if( $fileBebasName != '' ) {
                $billing->surat_ket_bebas_pajak = $fileBebasName;
            } 
            if( $filePoName != '' ) {
                $billing->po                    = $filePoName;
            }
            if( $fileFakturName != '' ) {
                $billing->file_faktur           = $fileFakturName;
            }
            if( $fileInvoiceName != '' ) {
                $billing->file_invoice          = $fileInvoiceName;
            }
            $billing->keterangan_po         = $request->keterangan_po;
            $billing->vendor_id             = Auth::user()->code;
            $billing->save();

            if( $request->has('idDetails') ) {
                foreach ($request->get('idDetails') as $key => $val) {
                    $billingDetail = BillingDetail::find($val);
                    //jika rubah qty
                    if( $billingDetail->qty != $request->get('qty')[$key] ) {
                        $poGr = PurchaseOrderGr::where('po_no', $billingDetail->po_no)
                            ->where('po_item', $billingDetail->PO_ITEM)
                            ->where('doc_gr', $billingDetail->doc_gr)
                            ->where('material_no', $billingDetail->material_id)
                            ->first();

                        $poGr->qty    += $billingDetail->qty;
                        $poGr->update();

                        $poDetail = PurchaseOrdersDetail::find($billingDetail->purchase_order_detail_id);
                        $poDetail->qty_billing -= $billingDetail->qty;
                        $poDetail->update();
                    }

                    $poNo               = $request->get('po_no')[$key];
                    $qty                = $request->get('qty')[$key];
                    $qty_old            = $request->get('qty_old')[$key];

                    $billingDetail->billing_id   = $id;
                    $billingDetail->po_no        = $poNo;
                    $billingDetail->qty          = $qty;
                    $billingDetail->qty_old      = $qty_old;
                    $billingDetail->update();

                    $_poGr = PurchaseOrderGr::where('po_no', $poNo)
                            ->where('po_item', $billingDetail->PO_ITEM)
                            // ->where('material_no', $billingDetail->material_id)
                            ->where('doc_gr', $billingDetail->doc_gr)
                            ->first();

                    $_poGr->qty_billing = $qty;
                    $_poGr->qty         = $qty_old - $qty;
                    $_poGr->update();

                    $poDetail_ = PurchaseOrdersDetail::find($billingDetail->purchase_order_detail_id);
                    $poDetail_->qty_billing = $qty;
                    $poDetail_->update();
                }
            }

            \DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            return redirect()->route('vendor.billing-create')->withInput();
        }

        return redirect()->route('vendor.billing')->with('status', 'Billing has been successfully saved');
    }

    public function poGR ($po_no)
    { 
        $model = PurchaseOrderGr::with('material')->where('doc_gr', $po_no)
            ->where('qty','>','0.00')
            ->where('is_cancel',PurchaseOrderGr::NoCancel)
            ->where('debet_credit','S')
            ->get();
        
        return response()->json($model);
    }

    public function printBilling($id)
    {
        $billingId = Billing::find($id);
        $billingId = $billingId->billing_no;
        return view('vendor.billing.print',compact('billingId'));
    }
}
