<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use App\Models\Vendor\Billing;
use App\Models\Vendor\BillingDetail;
use App\Models\PurchaseOrderGr;
use App\Models\PaymentTerm;
use App\Models\MasterPph;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MasterBankHouse;
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
        $billing = Billing::where('is_spv', $spv)->get();

        return view('admin.billing.index', compact('billing'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listSpv()
    {
        $spv = 1;

        $billing = Billing::where('is_spv', $spv)->get();

        return view('admin.billing.index-spv', compact('billing'));
    }
 
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing = Billing::find($id);
        $payments = PaymentTerm::all();
        $tipePphs = MasterPph::all();
        $currency = Currency::all();
        $bankHouse = MasterBankHouse::all();

        return view('admin.billing.show', compact('billing', 'bankHouse','payments', 'tipePphs','currency'));
    }

    public function edit ($id)
    {
        $billing = Billing::find($id);
        $payments = PaymentTerm::all();
        $tipePphs = MasterPph::all();
        $currency = Currency::all();
        $bankHouse = MasterBankHouse::all();

        return view('admin.billing.edit', compact('billing', 'bankHouse','payments', 'tipePphs','currency'));
    }

    public function store (Request $request)
    {
        $postSap = \sapHelp::sendBillingToSap($request);
        if( $postSap ) {
            \Session::flash('status','Billing has been approved');
        } else {
            \Session::flash('error','Internal server error !!!');
        }

        return \redirect()->route('admin.billing-spv-list');
    }

    public function storeApproved(Request $request)
    {
        $billing = Billing::find($request->id);
        $billing->status                = Billing::Approved;
        $billing->assignment            = $request->assignment;
        $billing->payment_term_claim    = $request->payment_term_claim;
        $billing->tipe_pph              = $request->tipe_pph;
        $billing->jumlah_pph            = $request->jumlah_pph;
        $billing->currency              = $request->currency;
        $billing->perihal_claim         = $request->perihal_claim;
        $billing->house_bank            = $request->house_bank;
        $billing->exchange_rate         = $request->exchange_rate;
        $billing->base_line_date        = $request->base_line_date;
        $billing->calculate_tax         = $request->calculate_tax;
        $billing->tax_amount            = $request->tax_amount ?? '';
        $billing->nominal_inv_after_ppn = $request->nominal_inv_after_ppn;
        $billing->is_spv                = Billing::sendToSpv;//approve spv
        $billing->update();

        foreach( $request->iddetail as $key => $rows ) {
            $detail         = BillingDetail::find($rows);
            $detail->amount = $request->amount[$key];

            $detail->update();
        }

        \Session::flash('status','Billing has been approved');
        return \redirect()->route('admin.billing');
    }
    
    public function storeRejected(Request $request)
    {
        $billing                    = Billing::find($request->id);
        $billing->status            = Billing::Rejected;
        $billing->reason_rejected   = $request->reason;
        $billing->update();

        \Session::flash('status','Billing has been rejected');
    }
}