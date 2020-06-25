<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\MasterMaterial;
use App\Models\AcpTable;
use App\Models\AcpTableDetail;
use App\Models\AcpTableMaterial;
use App\Models\MasterRfq;
use App\Models\MasterRfqDetail;

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
            $acp->acp_no      = $request->get('acp_no');
            $acp->is_project  = $request->get('is_project') ?? 0;
            $acp->is_approval = $request->get('is_approval') ?? 0;
            $acp->start_date  = $request->get('start_date');
            $acp->end_date    = $request->get('end_date');
            $acp->created_by  = \Auth::user()->name;
            $acp->updated_by  = \Auth::user()->name;
            $acp->deleted_by  = 'FALSE';
            $acp->save();

            $result = [];
            foreach ($request['vendor_id'] as $value) {
                $vendor = new AcpTableDetail;

                $isWinner = 0;
                if( $request['winner_' . $value])  {
                    $isWinner = 1;
                }

                $vendor->master_acp_id = $acp->id;
                $vendor->vendor_code   = $value;
                $vendor->is_winner     = $isWinner;
                $vendor->save();

                if ($request['winner_' . $value]) {
                    // create rfq
                    $max = MasterRfq::select('purchasing_document')
                        ->orderBy('id', 'desc')
                        ->limit(1)
                        ->first();
                    
                    $rfq = new MasterRfq;
                    $rfq->purchasing_document = (int) $max->purchasing_document + 1;
                    $rfq->company_code = '1200';
                    $rfq->vendor = $value;
                    $rfq->language_key = 'EN';
                    $rfq->acp_id = $acp->id ;
                    $rfq->save();                
                }

                foreach ($request['material_' . $value] as $i => $row) {
                    $temp['winner'] = 0;
                    if ($request['winner_' . $value])
                        $temp['winner'] = 1;

                    $temp['purchasing_document'] = $rfq->purchasing_document ?? 0;
                    $temp['vendor'] = $value;
                    $temp['material'] = $row;
                    $temp['price'] = $request['price_' . $value][$i];
                    $temp['qty'] = $request['qty_' . $value][$i];
                    $result[] = $temp;
                }
            }

            foreach ($result as $key => $val) {
                $material = new AcpTableMaterial;
                $material->master_acp_id = $acp->id;
                $material->master_acp_vendor_id = $val['vendor'];
                $material->material_id = $val['material'];
                $material->price = $val['price'];
                $material->qty = $val['qty'];
                $material->save();

                if ($val['winner'] == 1) {
                    // insert to rfq detail
                    $rfqDetail = new MasterRfqDetail;
                    $rfqDetail->purchasing_document = $val['purchasing_document'];
                    $rfqDetail->material = $val['material'];
                    $rfqDetail->net_order_price = $val['price'];
                    $rfqDetail->save();
                }
            }

            \DB::commit();

            return redirect()->route('admin.master-acp.index')->with('status', trans('cruds.master-acp.alert_success_insert'));
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }
    }

    public function edit ($id)
    {
        $model = AcpTable::find($id);
        $vendor = Vendor::join('master_acp_vendors', 'master_acp_vendors.vendor_code', '=', 'vendors.code')
            ->where('master_acp_vendors.master_acp_id', $id)
            ->first();

        $material = MasterMaterial::join('master_acp_materials', 'master_materials.code', '=', 'master_acp_materials.material_id')
            ->where('master_acp_materials.master_acp_id', $id)
            ->first();

        $vendors = Vendor::orderBy('name')->get();
        $materials = MasterMaterial::orderBy('description')->get();
        
        return view('admin.master-acp.edit', compact('model', 'vendor', 'material', 'vendors', 'materials'));
    }

    public function update (Request $request, $id)
    {

    }
}
