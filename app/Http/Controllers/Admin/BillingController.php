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
        // abort_if(Gate::denies('billing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        // abort_if(Gate::denies('billing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $billing = Billing::find($id);

        return view('admin.billing.show', compact('billing'));
    }

    public function storeApproved(Request $request, $id)
    {
        $billing = Billing::find($id);
        $billing->status = Billing::Approved;
        $billing->update();

        return redirect()->route('admin.billing')->with('status','Billing has been approved');
    }
    
    public function storeRejected(Request $request, $id)
    {
        $billing = Billing::find($id);
        $billing->status = Billing::Rejected;
        $billing->reason = $request->reason;
        $billing->update();

        return redirect()->route('admin.billing')->with('status','Billing has been rejected');
    }

}