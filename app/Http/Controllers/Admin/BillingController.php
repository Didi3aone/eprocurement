<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use App\Models\Vendor\Billing;
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