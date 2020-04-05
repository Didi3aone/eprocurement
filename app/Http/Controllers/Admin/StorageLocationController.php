<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StorageLocation;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;

class StorageLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('storage_location_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $storageLocation = StorageLocation::all();

        return view('admin.storage-location.index', compact('storageLocation'));
    }

    public function select (Request $request)
    {
        $storageLocation = StorageLocation::all();
        
        $data = [];
        foreach ($storageLocation as $row) {
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
        return view('admin.storage-location.create');
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:storage_location', ['filename' => $real_filename]);

        return redirect('admin/storage-location')->with('success', 'Storage Location has been successfully imported');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storageLocation = StorageLocation::create($request->all());

        return redirect()->route('admin.storage-location.index')->with('status', trans('cruds.storage-location.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $storageLocation = StorageLocation::findOrFail($id);

        return view('admin.storage-location.show', compact('storageLocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storageLocation = StorageLocation::findOrFail($id);

        return view('admin.storage-location.edit', compact('storageLocation'));
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
        $storageLocation = StorageLocation::find($id);
        $storageLocation->code = $request->input('code');
        $storageLocation->status = $request->input('status');
        $storageLocation->description = $request->input('description');
        $storageLocation->save();
        
        return redirect()->route('admin.storage-location.index')->with('status', trans('cruds.storage-location.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = StorageLocation::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Storage Location deleted successfully";
        } else {
            $success = true;
            $message = "Storage Location not found";
        }

        // return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
