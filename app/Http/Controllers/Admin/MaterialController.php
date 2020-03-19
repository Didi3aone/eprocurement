<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MaterialSheet;
use App\Imports\MaterialImport;
use App\Models\Material;
use App\Models\MaterialGroup;
use App\Models\MaterialType;
use App\Models\Plant;
use App\Models\PurchasingGroup;
use App\Models\ProfitCenter;
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

        $material = Material::all();

        return view('admin.material.index', compact('material'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new MaterialImport, public_path($path . $filename));

        // // Import CSV to Database
        // $filepath = public_path($path . $filename);
        
        // // Reading file
        // $file = fopen($filepath, "r");

        // $importData_arr = array();
        // $i = 0;

        // while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
        //     $num = count($filedata);
            
        //     // Skip first row (Remove below comment if you want to skip the first row)
        //     if($i == 0){
        //         $i++;
        //         continue; 
        //     }

        //     for ($c = 0; $c < $num; $c++) {
        //         $importData_arr[$i][] = $filedata[$c];
        //     }

        //     $i++;
        // }
        // fclose($file);

        // // Insert to MySQL database
        // $data = [];
        // foreach ($importData_arr as $importData) {
        //     $data[] = $importData;
        //     // $insertData = array(
        //     //     "username" => $importData[1],
        //     //     "name" => $importData[2],
        //     //     "gender" => $importData[3],
        //     //     "email" => $importData[4]
        //     // );

        //     // Page::insertData($insertData);
        // }

        // dd($data);
        // exit;

        // return redirect('admin/material')->with('success', 'Materials has been successfully imported');
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

        return view('admin.material.create', compact(
            'materialGroups',
            'materialTypes',
            'plants',
            'purchasingGroups',
            'profitCenters',
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
        $material = Material::create($request->all());

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

        $material = Material::findOrFail($id);

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

        $material = Material::findOrFail($id);

        $materialGroups = MaterialGroup::all();
        $materialTypes = MaterialType::all();
        $plants = Plant::all();
        $purchasingGroups = PurchasingGroup::all();
        $profitCenters = ProfitCenter::all();

        return view('admin.material.edit', compact(
            'material',
            'materialGroups',
            'materialTypes',
            'plants',
            'purchasingGroups',
            'profitCenters',
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
        $material = Material::findOrFail($id);
        
        $material->code = $request->get('code');
        $material->small_description = $request->get('small_description');
        $material->description = $request->get('description');
        $material->m_group_id = $request->get('m_group_id');
        $material->m_type_id = $request->get('m_type_id');
        $material->m_plant_id = $request->get('m_plant_id');
        $material->m_purchasing_id = $request->get('m_purchasing_id');
        $material->m_profit_id = $request->get('m_profit_id');

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

        $delete = Material::where('id', $id)->delete();

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
}
