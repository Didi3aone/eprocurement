<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
// use Gate;
use Symfony\Component\HttpFoundation\Response;

class PurchaseOrderController extends Controller
{
    public function index ()
    {
        $purchaseOrders = PurchaseOrder::all();

        return view('vendor.purchase-order.index', compact('purchaseOrders'));
    }

    public function create ()
    {
        return view('vendor.purchase-order.create');
    }

    public function makeQuotation ($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseOrderDetails = PurchaseOrdersDetail::where('purchase_order_id', $id)->get();

        return view('vendor.purchase-order.make-quotation', compact('purchaseOrder', 'purchaseOrderDetails'));
    }

    public function saveQuotation (Request $request)
    {
        \DB::beginTransaction();

        try {
            $quotationOrder = new Quotation;
            $quotationOrder->vendor_id = \Auth::user()->id;
            $quotationOrder->po_no = $request->get('po_no');
            $quotationOrder->po_date = $request->get('po_date');
            $quotationOrder->notes = $request->get('notes');
            $quotationOrder->request_id = $request->get('request_id');
            $quotationOrder->status = 0;
            $quotationOrder->save();

            if( $request->has('description') ) {
                foreach( $request->get('description') as $key => $row ) {
                    $model = new QuotationDetail;
                    $model->quotation_order_id = $quotationOrder->id;
                    $model->description       = $row;
                    $model->qty               = $request->get('qty')[$key];
                    $model->unit              = $request->get('unit')[$key];
                    $model->notes             = $request->get('notes_detail')[$key];
                    $model->price             = $request->get('price')[$key];
                    $model->save();
                }
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('vendor.purchase-order')->with('status', trans('cruds.purchase-order.alert_success_quotation'));
    }

    public Function createBidding ($id, $vendor_id)
    {
        $po = PurchaseOrder::find($id);
        $po->bidding = 1;
        $po->vendor_id = $vendor_id;
        $po->save();

        return redirect()->route('vendor.purchase-order')->with('status', trans('cruds.purchase-order.alert_success_bidding'));
    }
}