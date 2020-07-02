<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use App\Models\Vendor\Billing;
use App\Models\PurchaseOrderGr;
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
        $billing = Billing::all();

        return view('admin.billing.index', compact('billing'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing = Billing::find($id);

        return view('admin.billing.show', compact('billing'));
    }

    public function edit ($id)
    {
        $billing = Billing::find($id);
        $details = PurchaseOrderGr::join('billing_details', 'billing_details.po_no', '=', 'purchase_order_gr.po_no')
            ->where('billing_details.billing_id', $id)
            ->get();

        return view('admin.billing.edit', compact('billing', 'details'));
    }

    public function store (Request $request)
    {
        dd($request->all());
    }

    public function storeApproved(Request $request)
    {
        $billing = Billing::find($request->id);
        $billing->status = Billing::Approved;
        $billing->update();

        \Session::flash('status','Billing has been approved');
    }
    
    public function storeRejected(Request $request)
    {
        $billing = Billing::find($request->id);
        $billing->status = Billing::Rejected;
        $billing->reason_rejected = $request->reason;
        $billing->update();

        \Session::flash('status','Billing has been rejected');
    }

}