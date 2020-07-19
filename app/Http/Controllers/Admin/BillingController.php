<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use App\Models\Vendor\Billing;
use App\Models\Vendor\BillingDetail;
use App\Models\PurchaseOrdersDetail;
use App\Models\PurchaseOrderGr;
use App\Models\PaymentTerm;
use App\Models\MasterPph;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MasterBankHouse;
use App\Http\Requests\UpdateBillingRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\billingIncompleted;
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
    public function listSpv()
    {
        $billing = Billing::all();

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

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showStaff($id)
    {
        $billing = Billing::find($id);
        $payments = PaymentTerm::all();
        $tipePphs = MasterPph::all();
        $currency = Currency::all();
        $bankHouse = MasterBankHouse::all();

        return view('admin.billing.show-staff', compact('billing', 'bankHouse','payments', 'tipePphs','currency'));
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
        \DB::beginTransaction();
        try {
            $billing = Billing::find($request->id);
            //get partner bank
            $vendor     = \App\Models\Vendor::where('code',$billing->vendor_id)->first();
            $vendorBank = \App\Models\Vendor\VendorBankDetails::where('vendor_id',$vendor->id)->first();
            
            $billing->status                = Billing::Submitted;
            $billing->assignment            = $request->assignment;
            $billing->payment_term_claim    = $request->payment_term_claim;
            $billing->tipe_pph              = $request->tipe_pph;
            $billing->jumlah_pph            = $request->jumlah_pph ? str_replace(',', '',$request->jumlah_pph) : "00.00";
            $billing->base_pph              = $request->base_pph ? str_replace(',', '',$request->base_pph) : "00.00";
            $billing->currency              = $request->currency;
            $billing->perihal_claim         = $request->perihal_claim;
            $billing->house_bank            = $request->house_bank;
            $billing->exchange_rate         = $request->exchange_rate ? str_replace(',', '',$request->exchange_rate) : "00.00";
            $billing->base_line_date        = $request->base_line_date;
            $billing->ref_key_3             = $request->ref_key_3 ?? '-';
            $billing->ref_key_1             = $request->ref_key_1 ?? '-';
            $billing->partner_bank          = $vendorBank->partner_bank;
            $billing->payment_block         = $request->payment_block;
            $billing->calculate_tax         = $request->calculate_tax ?? 0;
            $billing->tax_amount            = $request->tax_amount ? str_replace(',', '',$request->tax_amount) : '00.00';
            $billing->nominal_balance       = $request->nominal_balance ? str_replace(',', '',$request->nominal_balance) : '00.00';
            $billing->nominal_invoice_staff = $request->nominal_invoice_staff ? str_replace(',', '',$request->nominal_invoice_staff) : "00.00";
            $billing->is_spv                = Billing::sendToSpv;//approve spv
            $billing->update();
            foreach( $request->iddetail as $key => $rows ) {
                // if( str_replace(',', '',$request->dpp) !=  str_replace(',', '',$request->amount[$key]) ) {
                //     \Session::flash('error','Dpp and amount not balance');
                //     return redirect()->route('admin.billing-edit', $request->id);
                // } 
                $detail         = BillingDetail::find($rows);
                $detail->amount = str_replace(',', '',$request->amount[$key]);
    
                $detail->update();
            }
            
            $postSap = \sapHelp::sendBillingToSap($request);
            if( $postSap ) {
                \Session::flash('status','Billing has been submitted');
            } else {
                \Session::flash('error','Internal server error !!!');
            }
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
        }

        return \redirect()->route('admin.billing-spv-list');
    }

    public function storeApproved(request $request)
    {
        \DB::beginTransaction();
        try {
            $billing = Billing::find($request->id);
            
            $billing->status                = Billing::Approved;
            $billing->is_spv                = Billing::sendToSpv;//approve spv
            $billing->update();
            \Session::flash('status','Billing has been approved');
            return \redirect()->route('admin.billing');
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
        }
    }
    
    public function storeRejected(Request $request)
    {
        $billing                    = Billing::find($request->id);
        $billing->status            = Billing::Rejected;
        $billing->reason_rejected   = $request->reason;

        $billing->update();

        foreach( $billing->detail as $key => $rows ) {
            $poGr = PurchaseOrderGr::where('po_no', $rows->po_no)
                ->where('po_item', $rows->PO_ITEM)
                ->where('material_no', $rows->material_id)
                ->first();

            $poGr->qty += $rows->qty;

            $poGr->save();

            $poDetail = PurchaseOrdersDetail::where('id', $rows->purchase_order_detail_id)
                        ->first();
            $poDetail->qty_billing -= $rows->qty;
            $poDetail->save();
        }
        \Session::flash('status','Billing has been rejected');
        return \redirect()->route('admin.billing');
    }

    public function storeVerify(Request $request) 
    {
        $billing                    = Billing::find($request->id);
        $billing->status            = Billing::Verify;
        $billing->verify_date       = date('Y-m-d');

        $billing->update();
        $name  = "didi";
        $email = 'diditriawan13@gmail.com';
        // $getEmailVendor = \App\Models\Vendor::where('code',$billing->vendor_id)->first();

        \Mail::to($email)->send(new billingIncompleted($billing, $name));

        \Session::flash('status','Billing has been verify');
        return \redirect()->route('admin.billing-edit',$request->id);
    }

    public function storeIncompleted(Request $request)
    {
        $billing                    = Billing::find($request->id);
        $billing->status            = Billing::Incompleted;
        $billing->reason_rejected   = $request->reason;

        $billing->update();
        $name  = "didi";
        $email = 'diditriawan13@gmail.com';
        // $getEmailVendor = \App\Models\Vendor::where('code',$billing->vendor_id)->first();

        \Mail::to($email)->send(new billingIncompleted($billing, $name));

        \Session::flash('status','Billing has been canceled');
        return \redirect()->route('admin.billing');
    }
}