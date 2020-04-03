<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterUnit;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('unit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = MasterUnit::all();

        return view('admin.unit.index', compact('units'));
    }

    public function select (Request $request)
    {
        $units = MasterUnit::all();
        
        $data = [];
        foreach ($units as $row) {
            $data[$row->uom] = $row->uom . ' - ' . $row->iso . ' - ' . $row->text;
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
        return view('admin.unit.create');
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:unit', ['filename' => $real_filename]);

        return redirect('admin/unit')->with('success', 'Units has been successfully imported');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unit = MasterUnit::create($request->all());

        return redirect()->route('admin.unit.index')->with('status', trans('cruds.unit.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = MasterUnit::findOrFail($id);

        return view('admin.unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = MasterUnit::findOrFail($id);

        return view('admin.unit.edit', compact('unit'));
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
        $unit = MasterUnit::find($id);
        $unit->uom = $request->input('uom');
        $unit->iso = $request->input('iso');
        $unit->text = $request->input('text');
        $unit->save();
        
        return redirect()->route('admin.unit.index')->with('status', trans('cruds.unit.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = MasterUnit::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Unit deleted successfully";
        } else {
            $success = true;
            $message = "Unit not found";
        }

        // return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
