<?php

namespace App\Http\Controllers\Admin;

use Artisan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vendor;
use App\Imports\VendorsImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('vendor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = Vendor::all();

        return view('admin.vendors.index',compact('vendors'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        ini_set('max_execution_time', 0);
        
        $path = 'xls/';
        $file = $request->file('xls_file');

        if (!empty($file)) {
            $filename = $file->getClientOriginalName();

            $file->move($path, $filename);

            $real_filename = public_path($path . $filename);

            Artisan::call('import:vendor', ['filename' => $real_filename]);

            return redirect('admin/vendors')->with('error', 'Vendors imported failed');
        } else {
            return redirect('admin/vendors')->with('success', 'Vendors has been successfully imported');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('vendor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendors = Vendor::create($request->all());

        return redirect()->route('admin.vendors.index')->with('status', trans('cruds.vendors.alert_success_insert'));
    }

    public function setPassword (Request $request)
    {
        if ($request->get('password') == $request->get('password_confirmation')) {
            $id = $request->get('vendor_id');

            $model = Vendor::find($id);
            $model->password = \Hash::make($request->get('password'));
            $model->save();
    
            return redirect()->route('admin.vendors.index')->with('success', 'Password has been set');
        } else
            return redirect()->route('admin.vendors.index')->with('error', 'Password confirmation doesnot match');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('vendor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = Vendor::findOrFail($id);

        return view('admin.vendors.show', compact('vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('vendor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = Vendor::findOrFail($id);

        return view('admin.vendors.edit', compact('vendors'));
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
        $vendors = Vendor::findOrFail($id);
        
        $vendors->name = $request->get('name');
        $vendors->email = $request->get('email');
        $vendors->npwp = $request->get('npwp');
        $vendors->address = $request->get('address');
        $vendors->company_type = $request->get('company_type');
        $vendors->company_from = $request->get('company_from');
        $vendors->status = $request->get('status');

        $vendors->save();
        
        return redirect()->route('admin.vendors.index')->with('status', trans('cruds.vendors.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('vendor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = Vendor::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Vendor deleted successfully";
        } else {
            $success = true;
            $message = "Vendor not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function getVendor(Request $request)
    {
        $vendor = Vendor::where('code', $request->code)->get();

        $data = [];
        foreach( $vendor as $row ) {
            $data[$row->code] = $row->code." - ".$row->name;
        }

        return \response()->json($data, 200);
    }
}
