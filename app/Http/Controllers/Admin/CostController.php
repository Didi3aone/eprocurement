<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Cost;
use App\Imports\CostsImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('cost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $costs = Cost::all();

        return view('admin.cost.index',compact('costs'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('cost_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new CostsImport, public_path($path . $filename));

        return redirect('admin/cost')->with('success', 'Cost Center has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('cost_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cost.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cost = Cost::create($request->all());

        return redirect()->route('admin.cost.index')->with('status', trans('cruds.cost.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('cost_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cost = Cost::findOrFail($id);

        return view('admin.cost.show', compact('cost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('cost_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cost = Cost::findOrFail($id);

        return view('admin.cost.edit', compact('cost'));
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
        $cost = Cost::findOrFail($id);
        $cost->area = $request->get('area');
        $cost->cost_center = $request->get('cost_center');
        $cost->company_code = $request->get('company_code');
        $cost->profit_center = $request->get('profit_center');
        $cost->hierarchy_area = $request->get('hierarchy_area');
        $cost->name = $request->get('name');
        $cost->description = $request->get('description');
        $cost->short_text = $request->get('short_text');
        $cost->save();
        
        return redirect()->route('admin.cost.index')->with('status', trans('cruds.cost.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('cost_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = Cost::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Cost Center deleted successfully";
        } else {
            $success = true;
            $message = "Cost Center not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
