<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Vendor\Quotation;
use App\Models\Vendor;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_if(Gate::denies('quotation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation = Quotation::orderBy('id', 'desc')->get();

        return view('admin.quotation.index', compact('quotation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quotation.create');
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:quotation', ['filename' => $real_filename]);

        return redirect('admin/quotation')->with('success', 'Quotation has been successfully imported');
    }

    public function winner (Request $request)
    {
        $quotation = [];
        
        foreach ($request->get('id') as $id)
            $quotation[$id] = Quotation::find($id);

        return view('admin.quotation.winner', compact('quotation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quotation = Quotation::create($request->all());

        return redirect()->route('admin.quotation.index')->with('status', trans('cruds.quotation.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);

        return view('admin.quotation.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);

        return view('admin.quotation.edit', compact('quotation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $quotation = Quotation::find($id);
        $quotation->notes = $request->input('notes');
        $quotation->upload_file = $request->input('upload_file');
        $quotation->vendor_leadtime = $request->input('vendor_leadtime');
        $quotation->vendor_price = $request->input('vendor_price');
        $quotation->save();
        
        return redirect()->route('admin.quotation.index')->with('status', trans('cruds.quotation.alert_success_update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFromVendor(Request $request, $id)
    {
        $quotation = Quotation::find($id);
        $quotation->notes = $request->input('notes');
        $quotation->upload_file = $request->input('upload_file');
        $quotation->vendor_leadtime = $request->input('vendor_leadtime');
        $quotation->vendor_price = $request->input('vendor_price');
        $quotation->save();
        
        return redirect()->route('admin.quotation.index')->with('status', trans('cruds.quotation.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Quotation::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "quotation deleted successfully";
        } else {
            $success = true;
            $message = "quotation not found";
        }

        // return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
