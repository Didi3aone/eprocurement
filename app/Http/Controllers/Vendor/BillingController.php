<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillingRequest;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Vendor\Billing;
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
            ->where('purchase_orders.vendor_id', Auth::user()->code)
            ->where('purchase_requests_details.type_approval', 888)
            ->where('purchase_requests_details.status_approval', 704)
            ->where('purchase_requests_details.is_validate', 1)
            ->get();
            dd($purchase_orders);

        $data = [];
        foreach ($purchase_orders as $po) {
            // wsdl billing
            $gr = [
                'po_no' => $po->PO_NUMBER,
                'material_id' => $po->material_id,
                'pr_no' => $po->PR_NO,
                'price' => $po->price,
                'qty' => $po->qty,
                'description' => $po->description,
                'unit' => $po->unit,
                'purchasing_group_code' => $po->purchasing_group_code,
                'plant_code' => $po->plant_code,
                'gl_acct_code' => $po->gl_acct_code,
                'cost_center_code' => $po->cost_center_code,
                'co_area' => $po->co_area,
                'profit_center_code' => $po->profit_center_code,
                'storage_location' => $po->storage_location,
                'currency' => $po->currency,
            ];

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

            $GR = [];
            $params[0]['GR'] = $GR;
            // <EBELN>3010000001</EBELN> no PO
            // <EBELP>00010</EBELP> Item PO
            // <LIFNR>0003000048</LIFNR> vendor
            // <BWART>101</BWART> movement type
            // <SHKZG>S</SHKZG> debit/credit (S itu debit / h itu credit)
            // <MATNR>000000000005005752</MATNR> nomor material
            // <MENGE>1000.0</MENGE> qty
            // <DMBTR>5000.0</DMBTR> Amount in Local Currency
            // <WERKS>1101</WERKS> plant
            // <LGORT>A301</LGORT> sloc
            // <CHARG/> batch
            // <MEINS>ST</MEINS> satuan
            // <WAERS>IDR</WAERS> currency
            // <MBLNR>5000001046</MBLNR> doc GR
            // <MJAHR>2019</MJAHR> tahun GR
            // <ZEILE>0001</ZEILE> item GR
            // <LFBNR>5000001046</LFBNR> Reference Document
            // <LFPOS>0001</LFPOS> Reference Doc. Item
            // <SMBLN/> Material Document
            // <SMBLP>0000</SMBLP> Material Doc.Item
            // <ELIKZ>X</ELIKZ> Delivery Completed
            // <SAKTO/> G/L Account
            // <PRCTR>0000110001</PRCTR> Profit center
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
        }

        $billing = Billing::where('created_by', Auth::user()->id)->get();

        return view('vendor.billing.index', compact('billing'));
    }

    public function show($id)
    {
        $billing = Billing::find($id);

        return view('vendor.billing.show',compact('billing'));
    }

    public function create() 
    {
        return view('vendor.billing.create');
    }

    public function store(StoreBillingRequest $request)
    {
        \DB::beginTransaction();
        try {
            // save file
            $filePoName = '';
            $fileFakturName  = '';
            $fileInvoiceName = '';
            $fileBebasName = '';
            $path = 'billing/';
            if ($request->file('po')) {
                $filePo = $request->file('po');
                $filePoName = time() . $filePo->getClientOriginalName();
                $filePo->move(public_path() . '/files/uploads/', $filePoName);
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

            $billing = new Billing;
            $billing->billing_no            = time();
            $billing->tgl_faktur            = $request->tgl_faktur;
            $billing->no_faktur             = $request->no_faktur;
            $billing->no_invoice            = $request->no_invoice;
            $billing->tgl_invoice           = $request->tgl_invoice;
            $billing->nominal_inv_after_ppn = $request->nominal_inv_after_ppn;
            $billing->ppn                   = $request->ppn;
            $billing->dpp                   = $request->dpp;
            $billing->no_rekening           = $request->no_rekening;
            $billing->no_surat_jalan        = $request->no_surat_jalan;
            $billing->tgl_surat_jalan       = $request->tgl_surat_jalan;
            $billing->npwp                  = $request->npwp;
            $billing->surat_ket_bebas_pajak = $fileBebasName;
            $billing->po                    = $filePoName;
            $billing->keterangan_po         = $request->keterangan_po;
            $billing->file_faktur           = $fileFakturName;
            $billing->file_invoice          = $fileInvoiceName;
            $billing->vendor_id             = Auth::user()->id;
            $billing->save();

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

        return view('vendor.billing.edit',compact('billing'));
    }
}
