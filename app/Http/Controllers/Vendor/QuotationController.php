<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vendor\Quotation;
use App\Models\BiddingHistory;
// use Gate;
use Symfony\Component\HttpFoundation\Response;

class QuotationController extends Controller
{
    public function index ()
    {
        $quotation = Quotation::where('vendor_id', Auth::user()->id)
            ->with('historyCount')
            ->orderBy('id', 'desc')
            ->get();

        return view('vendor.quotation.index', compact('quotation'));
    }

    public function detail ($id)
    {
        $quotation = Quotation::find($id);

        return view('vendor.quotation.show', compact('quotation'));
    }

    public function edit ($id)
    {
        $quotation = Quotation::find($id);
        $maxPrice = Quotation::where('po_no', $quotation->po_no)
            ->where('vendor_id', '<>', Auth::user()->id)
            ->whereNotNull('vendor_price')
            ->max('vendor_price');

        $vendors = null;
        
        if (!empty($maxPrice)) {
            $vendors = Quotation::where('po_no', $quotation->po_no)
                ->where([
                    'vendor_id', '<>', Auth::user()->id,
                    'vendor_price', $maxPrice
                ])
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('vendor.quotation.edit', compact('quotation', 'vendors'));
    }

    public function store (Request $request)
    {
        if ($request->get('vendor_price') > $request->get('target_price'))
            return redirect()->route('vendor.quotation-edit', $request->get('id'))
                ->with('error', trans('cruds.quotation.alert_error_price') . ', target price = ' . $request->get('target_price'));

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

            $history = new BiddingHistory;
            $history->pr_no = $request->get('po_no');
            $history->vendor_id = Auth::user()->id;
            $history->quotation_id = $request->get('id');
            $history->save();

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('vendor.quotation')->with('status', trans('cruds.quotation.alert_success_quotation'));
    }
}