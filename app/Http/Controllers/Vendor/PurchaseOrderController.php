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

    public Function createBidding ($id, $vendor_id)
    {
        $po = PurchaseOrder::find($id);
        $po->bidding = 1;
        $po->vendor_id = $vendor_id;
        $po->save();

        return redirect()->route('vendor.purchase-order')->with('status', trans('cruds.purchase-order.alert_success_bidding'));
    }
}