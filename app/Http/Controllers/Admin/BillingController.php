<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use App\Models\Vendor\Billing;
use App\Models\PurchaseOrderGr;
use App\Models\PaymentTerm;
use App\Models\MasterPph;
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
        if (Gate::check('accounting_spv'))
            $spv = 1;

        $billing = Billing::where('is_spv', $spv)->get();

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
        $payments = PaymentTerm::all();
        $tipePphs = MasterPph::all();
        $details = PurchaseOrderGr::join('billing_details', 'billing_details.po_no', '=', 'purchase_order_gr.po_no')
            ->where('billing_details.billing_id', $id)
            ->get();

        return view('admin.billing.edit', compact('billing', 'payments', 'tipePphs', 'details'));
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