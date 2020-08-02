<?php

namespace App\Http\Controllers\Admin;

use Artisan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MaterialSheet;
use App\Imports\MaterialImport;
use App\Imports\NewMaterialImport;
use App\Jobs\ImportMaterial;
use App\Models\Material;
use App\Models\MasterMaterial;
use App\Models\MaterialGroup;
use App\Models\MaterialType;
use App\Models\Plant;
use App\Models\PurchasingGroup;
use App\Models\ProfitCenter;
use App\Models\PurchaseOrderGr;
use DataTables;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('material_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.material.index');
    }
    
    public function list ()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');

        return DataTables::of(MasterMaterial::get())->make(true);
    }

    public function select2 (Request $request)
    {
        $term = $request->get('term');

        $poGR = PurchaseOrderGr::where('po_no', 'like', '%' . $term . '%')
            ->limit(20)
            ->get();

        $data = [];
        foreach ($poGR as $row) {
            $material_description = $row->material ? $row->material->description : '';

            $data[] = [
                'id' => $row->po_no,
                'text' => $row->po_no . ' - ' . $material_description
            ];
        }

        return response()->json($data);
    }

    public function select (Request $request)
    {
        $pg = PurchasingGroup::where('code', $request->input('code'))->first();
        $material = MasterMaterial::where('m_purchasing_id', $pg->id)->get();
        
        $data = [];
        foreach ($material as $row) {
            $data[$row->code] = $row->code . ' - ' . $row->description;
        }

        return response()->json($data);
    }

    public function import(Request $request)
    {
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:material', ['filename' => $real_filename]);

        return redirect('admin/material')->with('success', 'Materials has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('material_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialGroups = MaterialGroup::all();
        $materialTypes = MaterialType::all();
        $plants = Plant::all();
        $purchasingGroups = PurchasingGroup::all();
        $profitCenters = ProfitCenter::all();
        $unit = \App\Models\MasterUnit::all();
        $storage = \App\Models\StorageLocation::all();

        return view('admin.material.create', compact(
            'materialGroups',
            'materialTypes',
            'plants',
            'purchasingGroups',
            'profitCenters',
            'unit',
            'storage'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $material = MasterMaterial::create($request->all());

        return redirect()->route('admin.material.index')->with('status', trans('cruds.masterMaterial.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('material_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $material = MasterMaterial::findOrFail($id);

        return view('admin.material.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('material_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $material = MasterMaterial::findOrFail($id);

        $materialGroups = MaterialGroup::all();
        $materialTypes = MaterialType::all();
        $plants = Plant::all();
        $purchasingGroups = PurchasingGroup::all();
        $profitCenters = ProfitCenter::all();
        $unit = \App\Models\MasterUnit::all();

        return view('admin.material.edit', compact(
            'material',
            'materialGroups',
            'materialTypes',
            'plants',
            'purchasingGroups',
            'profitCenters',
            'unit'
        ));
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
        $material = MasterMaterial::findOrFail($id);
        
        $material->code = $request->get('code');
        $material->description = $request->get('description');
        $material->material_group_code = $request->get('material_group_code');
        $material->material_type_code = $request->get('material_type_code');
        $material->plant_code = $request->get('plant_code');
        $material->uom_code = $request->get('uom_code');
        $material->purchasing_group_code = $request->get('purchasing_group_code');
        $material->profit_center_code = $request->get('profit_center_code');

        $material->save();
        
        return redirect()->route('admin.material.index')->with('status', trans('cruds.masterMaterial.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = MasterMaterial::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Material deleted successfully";
        } else {
            $success = true;
            $message = "Material not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response\Json
     */
    public function getMaterial(Request $request)
    {
        $data = MasterMaterial::select(
                    'uom_code as uom',
                    'code as materialCode',
                    'description',
                    'purchasing_group_code as pg_code',
                    'storage_location_code as storeCode',
                    'material_group_code'
                )
                ->get();
        
        return \Response::json($data);
    }
}
