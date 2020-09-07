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
use App\Mail\billingRejected;
use App\Mail\billingApproved;
use App\Mail\billingVerify;
use App\Models\EmailMarketingVendor;
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
        
        $billing    = Billing::find($id);
        $plantCode = "";
        if( $billing->detail[0]->plant_code == "1101" ) {
            $plantCode = '1101';
        } else if( $billing->detail[0]->plant_code == "1201" OR $billing->detail[0]->plant_code == "1202") {
            $plantCode = '1201';
        } else if( $billing->detail[0]->plant_code == '2101' ) {
            $plantCode = '2101';
        }
        $payments   = PaymentTerm::all();
        $tipePphs   = MasterPph::all();
        $currency   = Currency::all();
        $bankHouse  = MasterBankHouse::where('plant_code', $plantCode)->get();

        return view('admin.billing.edit', compact('billing', 'bankHouse','payments', 'tipePphs','currency'));
    }

    public function store (Request $request)
    {
        try {
            \DB::beginTransaction();
            $billing = Billing::find($request->id);
            //get partner bank
            $vendor     = \App\Models\Vendor::where('code',$billing->vendor_id)->first();
            $vendorBank = \App\Models\Vendor\VendorBankDetails::where('vendor_id',$vendor->id)->first();
            
            // $billing->status                = Billing::Submitted;
            $billing->assignment            = $request->assignment;
            $billing->payment_term_claim    = $request->payment_term_claim;
            $billing->tipe_pph              = $request->tipe_pphs;
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
            if( $postSap == 'YES') {
                \Session::flash('status','Billing has been submitted');
                // \DB::commit();
            } else {
                \Session::flash('error','Internal server error !!!');
                //\DB::rollback();
            }
            \DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
        }

        return \redirect()->route('admin.billing');
    }

    public function storeApproved(request $request)
    {
        \DB::beginTransaction();
        try {
            $billing = Billing::find($request->id);
            
            $billing->status      = Billing::Approved;
            $billing->is_spv      = Billing::sendToSpv;//approve spv
            $billing->update();

            $vendor             = \App\Models\Vendor::where('code',$billing->vendor_id)->first();
            $getEmailMarketing  = EmailMarketingVendor::where('vendor_id', $billing->vendor_id)->get();

            $configEnv = \configEmailNotification();
            if( !empty($getEmailMarketing) ) {
                foreach( $getEmailMarketing as $rows ) {
                    if (\App\Models\BaseModel::Development == $configEnv->type) {
                        $email = 'ari.budiman@enesis.com';
                        $name  = $vendor->name;
                    } else {
                        $email = $rows->email;
                        $name  = $vendor->name;
                    }
                    \Mail::to($email)->send(new billingApproved($billing, $name));
                }
            } else {
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = 'ari.budiman@enesis.com';
                    $name  = $vendor->name;
                } else {
                    $email = $vendor->email;
                    $name  = $vendor->name;
                }

                \Mail::to($email)->send(new billingApproved($billing, $name));
            }

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

        $vendor = \App\Models\Vendor::where('code',$billing->vendor_id)->first();

        // $configEnv = \configEmailNotification();
        // if (\App\Models\BaseModel::Development == $configEnv->type) {
        //     $email = 'ari.budiman@enesis.com';
        //     $name  = $vendor->name;
        // } else {
        //     $email = $vendor->email;
        //     $name  = $vendor->name;
        // }
        $getEmailMarketing  = EmailMarketingVendor::where('vendor_id', $billing->vendor_id)->get();

        $configEnv = \configEmailNotification();
        if( !empty($getEmailMarketing) ) {
            foreach( $getEmailMarketing as $rows ) {
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = 'ari.budiman@enesis.com';
                    $name  = $vendor->name;
                } else {
                    $email = $rows->email;
                    $name  = $vendor->name;
                }
                \Mail::to($email)->send(new billingRejected($billing, $name));
            }
        } else {
            if (\App\Models\BaseModel::Development == $configEnv->type) {
                $email = 'ari.budiman@enesis.com';
                $name  = $vendor->name;
            } else {
                $email = $vendor->email;
                $name  = $vendor->name;
            }
            \Mail::to($email)->send(new billingRejected($billing, $name));
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

        $vendor = \App\Models\Vendor::where('code',$billing->vendor_id)->first();
        // if (\App\Models\BaseModel::Development == $configEnv->type) {
        //     $email = 'ari.budiman@enesis.com';
        //     $name  = $vendor->name;
        // } else {
        //     $email = $vendor->email;
        //     $name  = $vendor->name;
        // }

        // \Mail::to($email)->send(new billingVerify($billing, $name));
        $getEmailMarketing  = EmailMarketingVendor::where('vendor_id', $billing->vendor_id)->get();

        $configEnv = \configEmailNotification();
        if( !empty($getEmailMarketing) ) {
            foreach( $getEmailMarketing as $rows ) {
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = 'ari.budiman@enesis.com';
                    $name  = $vendor->name;
                } else {
                    $email = $rows->email;
                    $name  = $vendor->name;
                }
                \Mail::to($email)->send(new billingVerify($billing, $name));
            }
        } else {
            if (\App\Models\BaseModel::Development == $configEnv->type) {
                $email = 'ari.budiman@enesis.com';
                $name  = $vendor->name;
            } else {
                $email = $vendor->email;
                $name  = $vendor->name;
            }
            \Mail::to($email)->send(new billingVerify($billing, $name));
        }
        \Session::flash('status','Billing has been verify');
        return \redirect()->route('admin.billing-edit',$request->id);
    }

    public function storeIncompleted(Request $request)
    {
        $billing                    = Billing::find($request->id);
        $billing->status            = Billing::Incompleted;
        $billing->reason_rejected   = $request->reason;

        $billing->update();

        $vendor = \App\Models\Vendor::where('code',$billing->vendor_id)->first();
        $getEmailMarketing  = EmailMarketingVendor::where('vendor_id', $billing->vendor_id)->get();

        $configEnv = \configEmailNotification();
        if( !empty($getEmailMarketing) ) {
            foreach( $getEmailMarketing as $rows ) {
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = 'ari.budiman@enesis.com';
                    $name  = $vendor->name;
                } else {
                    $email = $rows->email;
                    $name  = $vendor->name;
                }
                \Mail::to($email)->send(new billingIncompleted($billing, $name));
            }
        } else {
            if (\App\Models\BaseModel::Development == $configEnv->type) {
                $email = 'ari.budiman@enesis.com';
                $name  = $vendor->name;
            } else {
                $email = $vendor->email;
                $name  = $vendor->name;
            }
            \Mail::to($email)->send(new billingIncompleted($billing, $name));
        }

        \Session::flash('status','Billing has been incompleted');
        return \redirect()->route('admin.billing');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $billing = billing::find($id);
        $billing->delete();

        BillingDetail::where('billing_id', $id)->delete();

        
        return redirect()->route('admin.billing')->with('status', 'Billing has been successfully deleted !');
    }
}