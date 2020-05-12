<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Billing;

class BillingController extends Controller
{
    public function index ()
    {
        $billing = Billing::where('vendor_id', \Auth::user()->id)->get();

        return view('vendor.billing.index', compact('billing'));
    }

    public function create() 
    {
        return view('vendor.billing.create');
    }

    public function store(Request $request)
    {

    }
}
