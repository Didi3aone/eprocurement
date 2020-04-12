<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vendor\Quotation;
// use Gate;
use Symfony\Component\HttpFoundation\Response;

class QuotationController extends Controller
{
    public function index ()
    {
        $quotation = Quotation::all();

        return view('vendor.quotation.index', compact('quotation'));
    }

    public function edit ($id)
    {
        $quotation = Quotation::find($id);

        return view('vendor.quotation.edit', compact('quotation'));
    }

    public function store (Request $request)
    {
        \DB::beginTransaction();

        try {
            $filename = '';
            
            if ($request->file('upload_file')) {
                $path = 'quotation/';
                $file = $request->file('upload_file');
                
                $filename = $file->getClientOriginalName();
        
                $file->move($path, $filename);
        
                $real_filename = public_path($path . $filename);
            }
    
            $quotation = Quotation::find($request->get('id'));
            $quotation->upload_file = $filename;
            $quotation->vendor_leadtime = $request->get('vendor_leadtime');
            $quotation->vendor_price = $request->get('vendor_price');
            $quotation->notes = $request->get('notes');
            $quotation->save();

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('vendor.quotation')->with('status', trans('cruds.quotation.alert_success_quotation'));
    }
}