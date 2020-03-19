<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Plant;
use App\Imports\PlantImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('plant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plants = Plant::all();

        return view('admin.plant.index', compact('plants'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('plant_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new PlantImport, public_path($path . $filename));

        return redirect('admin/plant')->with('success', 'Plant has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('plant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.plant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plant = Plant::create($request->all());

        return redirect()->route('admin.plant.index')->with('status', trans('cruds.plant.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('plant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plant = Plant::findOrFail($id);

        return view('admin.plant.show', compact('plant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('plant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plant = Plant::findOrFail($id);

        return view('admin.plant.edit', compact('plant'));
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
        $plant = Plant::findOrFail($id);
        $plant->code = $request->get('code');
        $plant->description = $request->get('description');
        $plant->save();
        
        return redirect()->route('admin.plant.index')->with('status', trans('cruds.plant.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('plant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = Plant::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Plant deleted successfully";
        } else {
            $success = true;
            $message = "Plant not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
