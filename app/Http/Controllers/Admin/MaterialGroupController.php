<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MaterialGroup;
use App\Imports\MaterialGroupImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MaterialGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('material_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialGroup = MaterialGroup::all();

        return view('admin.material_group.index', compact('materialGroup'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('material_group_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new MaterialGroupImport, public_path($path . $filename));

        return redirect('admin/material_group')->with('success', 'Material Group has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('material_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.material_group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $materialGroup = MaterialGroup::create($request->all());

        return redirect()->route('admin.material_group.index')->with('status', trans('cruds.material_group.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('material_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialGroup = MaterialGroup::findOrFail($id);

        return view('admin.material_group.show', compact('materialGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('material_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialGroup = MaterialGroup::findOrFail($id);

        return view('admin.material_group.edit', compact('materialGroup'));
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
        $materialGroup = MaterialGroup::findOrFail($id);
        $materialGroup->language = $request->get('language');
        $materialGroup->code = $request->get('code');
        $materialGroup->description = $request->get('description');
        $materialGroup->save();
        
        return redirect()->route('admin.material_group.index')->with('status', trans('cruds.material_group.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('material_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = MaterialGroup::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Purchasing Group deleted successfully";
        } else {
            $success = true;
            $message = "Purchasing Group not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
