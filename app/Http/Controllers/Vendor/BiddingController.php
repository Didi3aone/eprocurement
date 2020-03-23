<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
// use Gate;
use Symfony\Component\HttpFoundation\Response;

class BiddingController extends Controller
{
    public function index ()
    {
        $purchaseOrders = PurchaseOrder::where('vendor_id', Auth::user()->id);

        return view('vendor.bidding.index', compact('purchaseOrders'));
    }
}