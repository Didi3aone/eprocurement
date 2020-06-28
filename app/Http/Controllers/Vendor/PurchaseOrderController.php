<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;

class PurchaseOrderController extends Controller
{
 
    public function repeat ()
    {
        $poRepeat = PurchaseOrder::where('status',PurchaseOrder::POrepeat)
                    ->where('vendor_id',\Auth::user()->code)
                    ->get();

        return view('vendor.purchase-order.repeat', compact('poRepeat'));
    }

    public function direct ()
    {
        $poDirect = PurchaseOrder::where('status',PurchaseOrder::POdirect)
                    ->where('vendor_id',\Auth::user()->code)
                    ->get();

        return view('vendor.purchase-order.direct', compact('poDirect'));
    }

    public function repeatDetail($id) 
    {
        $id = Crypt::decryptString($id);

        $poRepeat = PurchaseOrder::find($id);

        return view('vendor.purchase-order.show-repeat', compact('poRepeat'));
    }

    public function directDetail($id) 
    {
        $id = Crypt::decryptString($id);

        $poDirect = PurchaseOrder::find($id);

        return view('vendor.purchase-order.show-direct', compact('poDirect'));
    }

}