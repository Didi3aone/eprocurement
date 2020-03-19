<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ProfitCenter;
use App\Imports\ProfitCenterImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ProfitCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('profit_center_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profitCenters = ProfitCenter::all();

        return view('admin.profit_center.index', compact('profitCenters'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('profit_center_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new ProfitCenterImport, public_path($path . $filename));

        return redirect('admin/profit_center')->with('success', 'Profit Center has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('profit_center_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.profit_center.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profitCenter = ProfitCenter::create($request->all());

        return redirect()->route('admin.profit_center.index')->with('status', trans('cruds.profit_center.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('profit_center_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profitCenter = ProfitCenter::findOrFail($id);

        return view('admin.profit_center.show', compact('profitCenter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('profit_center_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profitCenter = ProfitCenter::findOrFail($id);

        return view('admin.profit_center.edit', compact('profitCenter'));
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
        $profitCenter = ProfitCenter::findOrFail($id);
        $profitCenter->code = $request->get('code');
        $profitCenter->name = $request->get('name');
        $profitCenter->small_description = $request->get('small_description');
        $profitCenter->description = $request->get('description');
        $profitCenter->save();
        
        return redirect()->route('admin.profit_center.index')->with('status', trans('cruds.profit_center.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('profit_center_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = ProfitCenter::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Profit Center deleted successfully";
        } else {
            $success = true;
            $message = "Profit Center not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
