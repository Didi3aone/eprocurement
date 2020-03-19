<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchasingGroup;
use App\Imports\PurchasingGroupImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PurchasingGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('purchasing_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchasingGroup = PurchasingGroup::all();

        return view('admin.purchasing_group.index', compact('purchasingGroup'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('purchasing_group_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new PurchasingGroupImport, public_path($path . $filename));

        return redirect('admin/purchasing_group')->with('success', 'Purchasing Group has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('purchasing_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.purchasing_group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchasingGroup = PurchasingGroup::create($request->all());

        return redirect()->route('admin.purchasing_group.index')->with('status', trans('cruds.purchasingGroup.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('purchasing_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchasingGroup = PurchasingGroup::findOrFail($id);

        return view('admin.purchasing_group.show', compact('purchasingGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('purchasing_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchasingGroup = PurchasingGroup::findOrFail($id);

        return view('admin.purchasing_group.edit', compact('purchasingGroup'));
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
        $purchasingGroup = PurchasingGroup::findOrFail($id);
        $purchasingGroup->code = $request->get('code');
        $purchasingGroup->description = $request->get('description');
        $purchasingGroup->save();
        
        return redirect()->route('admin.purchasing_group.index')->with('status', trans('cruds.purchasingGroup.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('purchasing_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = PurchasingGroup::where('id', $id)->delete();

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
