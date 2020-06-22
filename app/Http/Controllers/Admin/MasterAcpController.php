<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\MasterMaterial;
use App\Models\AcpTable;
use App\Models\AcpTableDetail;
use App\Models\AcpTableMaterial;

class MasterAcpController extends Controller
{
    public function index ()
    {
        $model = AcpTable::get();

        return view('admin.master-acp.index', compact('model'));
    }

    public function create ()
    {
        $max = AcpTable::select(\DB::raw('count(id) as id'))->first()->id;
        $acp_no = 'ACP/' . date('m') . '/' . date('Y') . '/' . sprintf('%07d', ++$max);

        $vendor = Vendor::orderBy('name')->get();
        $material = MasterMaterial::orderBy('description')->get();

        return view('admin.master-acp.create', compact('acp_no', 'vendor', 'material'));
    }

    public function getMaterial (Request $request)
    {
        $model = MasterMaterial::where(function ($query) use ($request) {
            $query->where('code', 'like', '%' . $request->query('term') . '%')
                ->orWhere('description', 'like', '%' . $request->query('term') . '%');
        })
            ->orderBy('description', 'asc')
            ->limit(50)
            ->get();

        $data = [];
        foreach ($model as $row) {
            array_push($data, [
                'id' => $row->code,
                'text' => '
                    <div>
                        Code: <strong>' . $row->code . '</strong><br>
                        Plant: ' . $row->plant_code . '<br>
                        PG Code: ' . $row->purchasing_group_code . '<br>
                        Storeloc: ' . $row->storage_location_code . '<br>
                        Desc: ' . $row->description . '
                    </div>
                ',
                'title' => $row->code
            ]);
        }

        return response()->json($data);
    }

    public function store (Request $request)
    {
        \DB::beginTransaction();
        
        try {
            $acp = new AcpTable;
            $acp->acp_no = $request->get('acp_no');
            $acp->is_project = $request->get('is_project') ?? 0;
            $acp->is_approval = $request->get('is_approval') ?? 0;
            $acp->save();

            foreach ($request->get('vendor_id') as $v) {
                $vendor = new AcpTableDetail;
                $vendor->master_acp_id = $acp->id;
                $vendor->vendor_code = $v;
                $vendor->save();
            }

            foreach ($request->all() as $key => $val) {
                $pos = strpos($key, 'material_');
                if ($pos !== false) {
                    $materials = explode('_', $key);
                    $vendor = $materials[1];

                    for ($i = 0; $i < count($val); $i++) {
                        $material = new AcpTableMaterial;
                        $material->master_acp_id = $acp->id;
                        $material->master_acp_vendor_id = $vendor;
                        $material->material_id = $val[$i];
                        $material->save();
                    }
                }
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }
    }
}
