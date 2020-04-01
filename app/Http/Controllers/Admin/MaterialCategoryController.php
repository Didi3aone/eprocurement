<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialCategory;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;

class MaterialCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('material_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $material_category = MaterialCategory::all();

        return view('admin.material-category.index', compact('material_category'));
    }

    public function select (Request $request)
    {
        $material = MaterialCategory::all();
        
        $data = [];
        foreach ($material as $row) {
            $data[$row->code] = $row->code . ' - ' . $row->description;
        }

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.material-category.create');
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:material_category', ['filename' => $real_filename]);

        return redirect('admin/material-category')->with('success', 'Material Categories has been successfully imported');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $material_category = MaterialCategory::create($request->all());

        return redirect()->route('admin.material-category.index')->with('status', trans('cruds.material-category.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $material_category = MaterialCategory::findOrFail($id);

        return view('admin.material-category.show', compact('material_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $material_category = MaterialCategory::findOrFail($id);

        return view('admin.material-category.edit', compact('material_category'));
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
        $material_category = MaterialCategory::find($id);
        $material_category->code = $request->input('code');
        $material_category->description = $request->input('description');
        $material_category->save();
        
        return redirect()->route('admin.material-category.index')->with('status', trans('cruds.material-category.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = MaterialCategory::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Material Category deleted successfully";
        } else {
            $success = true;
            $message = "Material Category not found";
        }

        // return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
