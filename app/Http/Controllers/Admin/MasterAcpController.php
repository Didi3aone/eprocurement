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
use App\Models\Vendor\QuotationApproval;
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
        if( $request->get('fromPr') == \App\Models\AcpTable::MaterialPr ) {
            $model = \App\Models\PurchaseRequestsDetail::where(function ($query) use ($request) {
                $query->where('material_id', 'like', '%' . $request->query('term') . '%')
                    ->orWhere('description', 'like', '%' . $request->query('term') . '%');
                })->select(
                    'material_id as code',
                    'description'
                )
                ->join('purchase_requests','purchase_requests.id','=','purchase_requests_details.request_id')
                ->where('purchase_requests.doc_type','like','%Z%')
                ->whereNotNull('material_id')
                ->orderBy('description', 'asc')
                ->limit(50)
                ->get();
        } else {
            $model = MasterMaterial::where(function ($query) use ($request) {
                    $query->where('code', 'like', '%' . $request->query('term') . '%')
                        ->orWhere('description', 'like', '%' . $request->query('term') . '%');
                    })->select(
                        'code',
                        'description'
                    )
                    ->groupBy('code','description')
                    ->orderBy('description', 'asc')
                    ->limit(50)
                    ->get();
        }
        $data = [];
        foreach ($model as $row) {
            array_push($data, [
                'id' => $row->code,
                'text' => $row->code.' - '.$row->description,
                'title' => $row->description
            ]);
        }

        return response()->json($data);
    }

    public function store (Request $request)
    {
        // dd($request);
        \DB::beginTransaction();
        $max = AcpTable::select(\DB::raw('count(id) as id'))->first()->id;
        $acp_no = 'ACP/' . date('m') . '/' . date('Y') . '/' . sprintf('%07d', ++$max);
        try {
            $acp = new AcpTable;
            $acp->acp_no      = $acp_no;
            $acp->is_project  = $request->get('is_project') ?? 0;
            $acp->is_from_pr  = $request->get('is_from_pr') ?? 0;
            $acp->start_date  = $request->get('start_date');
            $acp->end_date    = $request->get('end_date');
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
                    if(empty($max)) {
                        $max = 9000000;
                    } else {
                        $max = $max->purchasing_document;
                    }
                    $rfq = new MasterRfq;
                    $rfq->purchasing_document = (int) $max + 1;
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

                    
                    $filename = '';
                    if ($request['file_attachment_'.$value[$i]] ) {
                        dd('iya');
                        $path = public_path().'files/uploads/';
                        $file = $request['file_attachment_'.$value[$i]];
                        $filename = 'acp_' . strtolower($file->getClientOriginalName());

                        $file->move($path, $filename);
                    }
                    
                    $temp['purchasing_document'] = $rfq->purchasing_document ?? 0;
                    $temp['vendor'] = $value;
                    $temp['material'] = $row;
                    $temp['price'] = $request['price_' . $value][$i];
                    $temp['qty'] = $request['qty_' . $value][$i];
                    $temp['file_attachment'] = $filename;
                    $result[] = $temp;
                }
            }

            $isAcp = false;
            $price = 0;
            foreach ($result as $key => $val) {
                $material = new AcpTableMaterial;
                $material->master_acp_id = $acp->id;
                $material->master_acp_vendor_id = $val['vendor'];
                $material->material_id = $val['material'];
                $material->price = $val['price'];
                $material->qty = $val['qty'];
                $material->file_attachment = $val['file_attachment'];
                $material->save();

                if ($val['winner'] == 1) {
                    $price += $val['price'];
                    $isAcp = true;
                    // insert to rfq detail
                    $rfqDetail = new MasterRfqDetail;
                    $rfqDetail->purchasing_document = $val['purchasing_document'];
                    $rfqDetail->material = $val['material'];
                    $rfqDetail->net_order_price = $val['price'];
                    $rfqDetail->save();
                }
            }

            if( $isAcp ) {
                if( ($price < 25000000) ) {
                    $this->saveApprovals($acp->id, 'STAFF','ACP');
                } else if( ($price > 25000000) && ($price < 100000000) ) {
                    $this->saveApprovals($acp->id, 'CMO','ACP');
                } else if( ($price > 100000000) && ($price < 250000000) ) {
                    $this->saveApprovals($acp->id, 'CFO','ACP');
                } else if( ($price > 250000000) ) {
                    $this->saveApprovals($acp->id, 'COO','ACP');
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

    private function saveApprovals($quotation_id, $tingkat,$type)
    {

        if( $tingkat == 'STAFF' ) {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
        } else if ($tingkat == 'CMO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
        } else if ($tingkat == 'CFO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
            
            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 4,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
        } else if ($tingkat == 'COO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
            
            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 4,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 5,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type,
                'acp_id'                =>  $quotation_id
            ]);
        }
    }
}
