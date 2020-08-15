<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail;
use App\Models\Vendor;
use App\Models\Plant;
use App\Models\DocumentType;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\PurchaseOrderInvoice;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Imports\PurchaseOrderImport;
use App\Models\PurchaseOrderChangeHistoryDetail;
use App\Models\PurchaseOrderChangeHistory;
use App\Mail\PurchaseOrderMail;

class PurchaseOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('purchase_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrder = PurchaseOrder::find($id);
        $currency = \App\Models\Currency::all();
        $top    = \App\Models\PaymentTerm::all();
        $poDetail = PurchaseOrdersDetail::find($id);

        return view('admin.purchase-order.edit-detail', compact('purchaseOrder','currency','top','poDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchaseOrder                 = PurchaseOrder::findOrFail($id);
        $purchaseOrder->notes          = $request->get('notes');
        $purchaseOrder->payment_term   = $request->get('payment_term');

        $poChangeHeader                         = new PurchaseOrderChangeHistory;
        $poChangeHeader->po_id                  = $purchaseOrder->id;
        $poChangeHeader->vendor_old             = $purchaseOrder->vendor_id;
        $poChangeHeader->vendor_change          = $request->get('payment_term') ?? '';
        $poChangeHeader->notes_old              = $purchaseOrder->notes;
        $poChangeHeader->notes_change           = $request->get('notes');
        // $poChangeHeader->peyment_term_old       = $purchaseOrder->payment_term;
        $poChangeHeader->save();
        
        $service        = '';
        $packageParent  = '000000000';
        $subpackgparent = '000000000';
        $noLine         = '';
        $sched          = "";
        $totalPrice = 0;
        foreach ($request->idDetail as $key => $rows) {
            $totalPrice += $request->price[$key];
            $poDetail = PurchaseOrdersDetail::find($rows);
            if( $poDetail->qty != $request->qty[$key] ) {
                $prDetail = PurchaseRequestsDetail::find($poDetail->request_detail_id);
                $prDetail->qty      += $poDetail->qty;
                $prDetail->qty_order = 0;
                $prDetail->update();

                $prDetail->qty      -= $request->qty[$key];
                $prDetail->qty_order = $request->qty[$key];

                $prDetail->save();

            }
            $poChangeDetail = new PurchaseOrderChangeHistoryDetail;
            $poChangeDetail->qty_old        = $poDetail->qty;
            $poChangeDetail->qty_change     = $request->qty[$key];
            $poChangeDetail->po_detail_id   = $poDetail->id;
            $poChangeDetail->po_history_id  = $poChangeHeader->id;
            $poChangeDetail->price_old      = $poDetail->price;
            $poChangeDetail->price_change   = $request->price[$key];
            $poChangeDetail->save();

            $poDetail->qty                  = $request->qty[$key];
            $poDetail->price                = $request->price[$key];
            $poDetail->currency             = $request->currency[$key];
            $poDetail->delivery_date        = $request->delivery_date[$key];
            $poDetail->delivery_complete    = $request->delivery_complete[$key];
            $poDetail->tax_code             = $request->tax_code[$key] == 1 ? 'V1' : 'V0';
            

            $poDetail->update();
        }

        if( $purchaseOrder->total_price != $totalPrice ) {
            $purchaseOrder->status_approval = PurchaseOrder::Rejected;
            $purchaseOrder->approved_asspro = \App\Models\Vendor\Quotation::getQuotationById($purchaseOrder->quotation_id)->approved_asspro;
            $purchaseOrder->approved_head   = 'PROCUREMENT01';
            $purchaseOrder->save();
            return redirect()->route('admin.purchase-order.index')->with('status', 'Purchase order has been updated & waiting approval');
        } else {
            $poChange = \sapHelp::sendPOchangeToSap($purchaseOrder->PO_NUMBER);
            if( $poChange ) {
                $purchaseOrder->status_approval = PurchaseOrder::Approved;
                $purchaseOrder->save();
                return redirect()->route('admin.purchase-order.index')->with('status', 'Purchase order has been updated');
            } else {
                return redirect()->route('admin.purchase-order.index');
                \Session::flash('error','Internal server error');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
