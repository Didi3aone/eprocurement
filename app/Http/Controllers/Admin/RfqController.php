<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vendor;
use App\Models\MasterRfq;
use App\Models\MasterRfqDetail;
use App\Models\Rfq;
use App\Models\RfqDetail;
use App\Imports\RfqImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RfqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_if(Gate::denies('rfq_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = Vendor::all();

        return view('admin.rfq.index', compact('vendors'));
    }

    public function import (Request $request)
    {
        // abort_if(Gate::denies('rfq_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        \Artisan::call('import:rfq', ['filename' => $real_filename]);

        return redirect('admin/rfq')->with('success', 'RFQ has been successfully imported');
    }

    public function importDetail (Request $request)
    {
        // abort_if(Gate::denies('rfq_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $this->validate($request, [
        //     'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        // ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();
        // dd($file); die();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        \Artisan::call('import:rfq_detail', ['filename' => $real_filename]);

        return redirect('admin/rfq')->with('success', 'RFQ Detail has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_if(Gate::denies('rfq_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = Vendor::all();
        $docTypes = Rfq::all();

        return view('admin.rfq.create', compact('vendors', 'docTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rfq = MasterRfq::create($request->all());

        return redirect()->route('admin.rfq.index')->with('status', trans('cruds.rfq.alert_success_insert'));
    }

    public function addDetail (Request $request, $code)
    {
        return view('admin.rfq.create-detail', compact('code'));
    }

    public function saveDetail (Request $request)
    {
        $rfq_detail = MasterRfqDetail::create($request->all());

        return redirect()->route('admin.rfq.index')->with('status', trans('cruds.rfq-detail.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        // abort_if(Gate::denies('rfq_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rfq = MasterRfq::where('vendor', $code)->get();

        return view('admin.rfq.show', compact('rfq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // abort_if(Gate::denies('rfq_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rfq = Rfq::findOrFail($id);

        return view('admin.rfq.edit', compact('rfq'));
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
        $rfq = Rfq::findOrFail($id);
        $rfq->code = $request->get('code');
        $rfq->description = $request->get('description');
        $rfq->save();
        
        return redirect()->route('admin.rfq.index')->with('status', trans('cruds.rfq.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // abort_if(Gate::denies('rfq_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = Rfq::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "RFQ deleted successfully";
        } else {
            $success = true;
            $message = "RFQ not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function getRfq(Request $request)
    {
        // dd($request->material_id);
        $data = MasterRfq::join('master_acp_materials','master_acp_materials.master_acp_vendor_id','=','master_rfqs.vendor')
                ->join('vendors','vendors.code','=','master_rfqs.vendor')
                ->join('master_acps','master_acps.id','=','master_rfqs.acp_id')
                ->select(
                    'vendors.name',
                    'master_rfqs.purchasing_document',
                )
                ->where('material_id', $request->material_id)
                ->where('master_acps.start_date','>=',\Carbon\Carbon::now())
                ->where('master_acps.end_date','<=',\Carbon\Carbon::now())
                ->where('master_acps.status_approval',)
                ->get();

        return response()->json($data, 200);
    }

    public function getRfqNetPrice(Request $request)
    {
        // $getRfq = \App\Models\AcpTableDetail::where('vendor_code',)
        $data = MasterRfqDetail::where('purchasing_document', $request->purchasing_document)
                // ->where('plant', $request->plant)
                ->first();

        return response()->json($data, 200);
    }
}
