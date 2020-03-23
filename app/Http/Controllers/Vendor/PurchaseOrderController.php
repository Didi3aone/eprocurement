<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
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

    public Function bidding ($id, $vendor_id)
    {
        $po = PurchaseOrder::find($id);
        $po->bidding = 1;
        $po->vendor_id = $vendor_id;
        $po->save();

        return redirect()->route('vendor.purchase-order')->with('status', trans('cruds.purchase-order.alert_success_bidding'));
    }
}