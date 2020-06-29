<?php

namespace App\Http\Controllers\Admin;

use Artisan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vendor;
use App\Models\Vendor\UserVendors;
use App\Models\Vendor\MasterVendorTermsOfPayment;
use App\Models\Vendor\VendorCompanyData;
use App\Models\Vendor\VendorPurchasingOrganization;
use App\Imports\VendorsImport;
use Gate, Exception;
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

        // $vendors = Vendor::all();
        $vendors = UserVendors::select(
                        'user_vendors.*',
                        'master_vendor_bp_group.code as vendor_bp_group_code',
                        'master_vendor_bp_group.name as vendor_bp_group_name',
                        \DB::raw('CASE WHEN user_vendors.status = 0 THEN 0 ELSE 1 END AS status_')
                    )
                    ->join('master_vendor_bp_group', 'master_vendor_bp_group.id', 'user_vendors.vendor_bp_group_id')
                    ->orderBy('status_', 'asc')
                    ->orderBy('updated_at', 'desc')
                    ->get();
        foreach ($vendors as $row) {
            $row->created_date = date('d M Y, H:i', strtotime($row->created_at));
            $row->updated_date = date('d M Y, H:i', strtotime($row->updated_at));
            $row->status_str = '<span class="badge badge-primary">Waiting For Approval</span>';
            if ($row->status==1)
                $row->status_str = '<span class="badge badge-success">Approved</span>';
            else if ($row->status==2)
                $row->status_str = '<span class="badge badge-danger">Rejected</span>';
        }

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

        // $vendors = Vendor::findOrFail($id);
        $vendors = UserVendors::findOrFail($id);
        $vendors->terms_of_payment = MasterVendorTermsOfPayment::find($vendors->terms_of_payment_key_id)->description;

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

        // $vendors = Vendor::findOrFail($id);
        $vendors = UserVendors::findOrFail($id);
        $terms_of_payment = MasterVendorTermsOfPayment::get();

        return view('admin.vendors.edit', compact('vendors','terms_of_payment'));
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
        $status = $request->input('status');
        $terms_of_payment_id = $request->input('terms_of_payment_id');
        $terms_of_payment = MasterVendorTermsOfPayment::findOrFail($terms_of_payment_id);
        $user_vendors = UserVendors::findOrFail($id);

        try {
            \DB::beginTransaction();

            $do_update = true;
            $do_update = $do_update && UserVendors::where('id', $id)
                                        ->update([
                                            'terms_of_payment_key_id' => $terms_of_payment_id,
                                            'status' => $status
                                        ]);
            $do_update = $do_update && VendorCompanyData::where('vendor_id', $id)
                                        ->update([
                                            'payment_terms' => $terms_of_payment->code
                                        ]);
            $do_update = $do_update && VendorPurchasingOrganization::where('vendor_id', $id)
                                        ->update([
                                            'term_of_payment_key' => $terms_of_payment->code
                                        ]);
            if (!$do_update) throw new Exception('Invalid request');
            
            \DB::commit();
            return redirect()->route('admin.vendors.index')->with('status', trans('cruds.vendors.alert_success_update'));
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->route('admin.vendors.index')->with('error', trans('cruds.vendors.alert_error_update'));
        }
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
