<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MaterialType;
use App\Imports\MaterialTypeImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('material_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialType = MaterialType::all();

        return view('admin.material_type.index', compact('materialType'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('material_type_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new materialTypeImport, public_path($path . $filename));

        return redirect('admin/material_type')->with('success', 'Material Type has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('material_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.material_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $materialType = MaterialType::create($request->all());

        return redirect()->route('admin.material_type.index')->with('status', trans('cruds.materialType.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('material_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialType = MaterialType::findOrFail($id);

        return view('admin.material_type.show', compact('materialType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('material_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialType = MaterialType::findOrFail($id);

        return view('admin.material_type.edit', compact('materialType'));
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
        $materialType = MaterialType::findOrFail($id);
        $materialType->code = $request->get('code');
        $materialType->description = $request->get('description');
        $materialType->save();
        
        return redirect()->route('admin.material_type.index')->with('status', trans('cruds.materialType.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('material_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = MaterialType::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Material Type deleted successfully";
        } else {
            $success = true;
            $message = "Material Type not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
