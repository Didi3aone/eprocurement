<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Billing;
use App\Http\Requests\StoreBillingRequest;
use Auth;

class BillingController extends Controller
{
    public function index ()
    {
        $billing = Billing::where('created_by', Auth::user()->id)->get();

        return view('vendor.billing.index', compact('billing'));
    }

    public function show($id)
    {
        $billing = Billing::find($id);

        return view('vendor.billing.show',compact('billing'));
    }

    public function create() 
    {
        return view('vendor.billing.create');
    }

    public function store(StoreBillingRequest $request)
    {
        \DB::beginTransaction();
        try {
            // save file
            $filePoName = '';
            $fileFakturName  = '';
            $fileInvoiceName = '';
            $fileBebasName = '';
            $path = 'billing/';
            if ($request->file('po')) {
                $filePo = $request->file('po');
                $filePoName = time() . $filePo->getClientOriginalName();
                $filePo->move(public_path() . '/files/uploads/', $filePoName);
            }

            if ($request->file('surat_ket_bebas_pajak')) {
                $fileBebas = $request->file('surat_ket_bebas_pajak');
                $fileBebasName = time() . $fileBebas->getClientOriginalName();
                $fileBebas->move(public_path() . '/files/uploads/', $fileBebasName);
            }
            
            if ($request->file('file_faktur')) {
                $fileFaktur = $request->file('file_faktur');
                $fileFakturName = time() . $fileFaktur->getClientOriginalName();
                $fileFaktur->move(public_path() . '/files/uploads/', $fileFakturName);
            }
            
            if ($request->file('file_invoice')) {
                $fileInvoice = $request->file('file_invoice');
                $fileInvoiceName = time() . $fileInvoice->getClientOriginalName();
                $fileInvoice->move(public_path() . '/files/uploads/', $fileInvoiceName);
            }

            $billing = new Billing;
            $billing->billing_no            = time();
            $billing->tgl_faktur            = $request->tgl_faktur;
            $billing->no_faktur             = $request->no_faktur;
            $billing->no_invoice            = $request->no_invoice;
            $billing->tgl_invoice           = $request->tgl_invoice;
            $billing->nominal_inv_after_ppn = $request->nominal_inv_after_ppn;
            $billing->ppn                   = $request->ppn;
            $billing->dpp                   = $request->dpp;
            $billing->no_rekening           = $request->no_rekening;
            $billing->no_surat_jalan        = $request->no_surat_jalan;
            $billing->tgl_surat_jalan       = $request->tgl_surat_jalan;
            $billing->npwp                  = $request->npwp;
            $billing->surat_ket_bebas_pajak = $fileBebasName;
            $billing->po                    = $filePoName;
            $billing->keterangan_po         = $request->keterangan_po;
            $billing->file_faktur           = $fileFakturName;
            $billing->file_invoice          = $fileInvoiceName;
            $billing->vendor_id             = Auth::user()->id;
            $billing->save();

            \DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            return redirect()->route('vendor.billing-create')->withInput();
        }

        return redirect()->route('vendor.billing')->with('status', 'Billing has been successfully saved');
    }

    public function edit($id)
    {
        $billing = Billing::find($id);

        return view('vendor.billing.edit',compact('billing'));
    }
}
