<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use App\Models\UserMap;
use App\Models\AcpTable;
use App\Models\MasterRfq;
use Illuminate\Http\Request;
use App\Models\AcpTableDetail;
use App\Models\MasterMaterial;
use App\Models\MasterRfqDetail;
use App\Models\Rfq;
use App\Models\RfqDetail;
use App\Models\AcpTableMaterial;
use App\Http\Controllers\Controller;
use App\Models\Vendor\QuotationApproval;

class MasterAcpController extends Controller
{
    public function index()
    {
        $model = AcpTable::orderBy('created_at', 'desc');

        if( \Auth::user()->roles[0]->title == 'Admin' ) {
            $model = $model;
        } else {
            $model = $model->where('created_by', \Auth::user()->nik);
        }

        $model = $model->get();

        return view('admin.master-acp.index', compact('model'));
    }

    public function create()
    {
        $vendor = Vendor::orderBy('name')->get();
        $material = MasterMaterial::orderBy('description')->get();
        $acpNo = AcpTable::get();
        $currency = \App\Models\Currency::get();
        $plant = \App\Models\Plant::all()->pluck('description','code');

        return view('admin.master-acp.create', compact('vendor', 'material', 'acpNo', 'currency','plant'));
    }

    public function getMaterial(Request $request)
    {
        if (\App\Models\AcpTable::MaterialPr == $request->get('fromPr')) {
            // dd('iya');
            $userMapping = UserMap::where('user_id', \Auth::user()->user_id)->first();
            $userMapping = explode(',', $userMapping->purchasing_group_code);
            // dd($userMapping);
            if( $request->query('q') != '' ) {
                $model = \App\Models\PurchaseRequestsDetail::where(function ($query) use ($request) {
                    $trims = $request->query('q');
                    $query->where('short_text', 'like', '%'.$request->query('q').'%')
                        ->orWhere('material_id', 'like', '%'.$trims.'%');
                        })->select(
                            \DB::raw(
                                "CASE
                                WHEN (material_id IS NULL OR material_id = '') THEN short_text 
                                ELSE material_id 
                                END AS code,
                                short_text as description"
                            )
                        )
                        ->join('purchase_requests','purchase_requests.id','=','purchase_requests_details.request_id')
                        ->where('qty', '>', '0.00')
                        ->whereIn('purchasing_group_code', $userMapping);

                if( 1 == $request->get('isProject') ) {
                    $model = $model->where('purchase_requests.is_project',1);
                }

                $model = $model->groupBy('material_id', 'short_text')
                        ->orderBy('short_text', 'asc')
                        ->limit(700)
                        ->get();
            } else {
                $model = \App\Models\PurchaseRequestsDetail::select(
                            \DB::raw(
                                "CASE
                                WHEN (material_id IS NULL OR material_id = '') THEN short_text 
                                ELSE material_id 
                                END AS code,
                                short_text as description"
                            )
                        )
                        ->join('purchase_requests','purchase_requests.id','=','purchase_requests_details.request_id')
                        ->where('qty', '>', 0)
                        ->whereIn('purchasing_group_code', $userMapping);
                       
                if( 1 == $request->get('isProject') ) {
                    $model = $model->where('purchase_requests.is_project',1);
                }

                $model = $model->groupBy('material_id', 'short_text')
                        ->orderBy('short_text', 'asc')
                        ->limit(700)
                        ->get();
            }
        } else {
            // dd('ngga');
            if( $request->query('q') != '' ) {
                $model = MasterMaterial::where(function ($query) use ($request) {
                    $query->where('code', 'like', '%'.$request->query('q').'%')
                            ->orWhere('description', 'like', '%'.$request->query('q').'%');
                })->select(
                            'code',
                            'description'
                        )
                        ->groupBy('code', 'description')
                        ->orderBy('description', 'asc')
                        ->limit(50)
                        ->get();
            } else {
                $model = MasterMaterial::select(
                            'code',
                            'description'
                        )
                        ->groupBy('code', 'description')
                        ->orderBy('description', 'asc')
                        ->limit(50)
                        ->get();
            }
        }
        $data = [];
        foreach ($model as $row) {
            array_push($data, [
                'id' => $row->code,
                'text' => $row->code.' - '.$row->description,
                'title' => $row->description,
            ]);
        }

        return response()->json($data);
    }

    public function getCurrency(Request $request)
    {
        $currency = \App\Models\Currency::where('currency', 'like', '%'.strtoupper($request->query('term')).'%')
                    ->where('iso_code','IDR')->get();

        $data = [];
        foreach ($currency as $row) {
            array_push($data, [
                'id' => $row->currency,
                'text' => $row->currency,
                'title' => $row->currency,
            ]);
        }

        return \Response::json($data);
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        $max = AcpTable::select('acp_no')
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();
        if (empty($max)) {
            $max = 10000000;
        } else {
            $max = $max->acp_no;
        }
        
        try {
            $file_upload = '';
            if ($request->upload_file) {
                $file_upload = $this->fileUpload($request);
            }

            $acp = new AcpTable();
            $acp->acp_no            = (int) $max + 1;
            $acp->is_project        = $request->get('is_project') ?? 0;
            $acp->is_from_pr        = $request->get('is_from_pr') ?? 0;
            $acp->start_date        = $request->get('start_date');
            $acp->end_date          = $request->get('end_date');
            $acp->description       = $request->get('description');
            $acp->reference_acp_no  = $request->get('reference_acp_no') ?? '';
            $acp->upload_file       = $file_upload;
            $acp->plant_id          = $request->get('plant_id');
            $acp->exchange_rate     = $request->get('exchange_rate');
            $acp->save();

            $result = [];
            foreach ($request['vendor_id'] as $value) {
                $vendor = new AcpTableDetail();

                $isWinner = 0;
                if ($request['winner_'.$value]) {
                    $isWinner = 1;
                }

                $vendor->master_acp_id = $acp->id;
                $vendor->vendor_code = $value;
                $vendor->is_winner = $isWinner;
                $vendor->save();

                if ($request['winner_'.$value]) {
                    // create rfq
                    $max = MasterRfq::select('purchasing_document')
                        ->orderBy('id', 'desc')
                        ->limit(1)
                        ->first();
                    if (empty($max)) {
                        $max = 9000000;
                    } else {
                        $max = $max->purchasing_document;
                    }
                    $rfq = new MasterRfq();
                    $rfq->purchasing_document = (int) $max + 1;
                    $rfq->company_code        = '1200';
                    $rfq->vendor              = $value;
                    $rfq->language_key        = 'EN';
                    $rfq->acp_id              = $acp->id;
                    $rfq->save();

                    $maxNumber = Rfq::max('rfq_number');
                    $rfqNew             = new Rfq;
                    $rfqNew->rfq_number = $maxNumber + 1;
                    $rfqNew->vendor_id  = $value;
                    $rfqNew->acp_id     = $acp->id;
                    $rfqNew->plant      = $request->get('plant_id');
                    $rfqNew->is_from_po = 2;

                    $rfqNew->save();

                }

                foreach ($request['material_'.$value] as $i => $row) {
                    $temp['winner'] = 0;
                    if ($request['winner_'.$value]) {
                        $temp['winner'] = 1;
                    }

                    $filename = '';
                    // if ($request['file_attachment_'.$value[$i]]) {
                    //     //dd('iya');
                    //     $path = public_path().'files/uploads/';
                    //     $file = $request['file_attachment_'.$value[$i]];
                    //     $filename = 'acp_'.strtolower($file->getClientOriginalName());

                    //     $file->move($path, $filename);
                    // }

                    $temp['purchasing_document']    = $rfq->purchasing_document ?? 0;
                    $temp['rfq_number']             = $rfqNew->rfq_number ?? 0;
                    $temp['vendor']                 = $value;
                    $temp['material']               = $row;
                    $temp['price']                  = $request['price_'.$value][$i];
                    $temp['qty']                    = $request['qty_'.$value][$i];
                    $temp['qty_pr']                 = $request['qty_pr_'.$value][$i];
                    $temp['currency']               = $request['currency_'.$value][$i];
                    $temp['file_attachment']        = $filename;
                    $result[] = $temp;
                    // dd($result);
                }
            }

            $isAcp = false;
            $price = 0;
            $assProc = '';
            foreach ($result as $key => $val) {
                $i = $key + 1;
                $poItem = (0+($i*10));
                // dd($val);
                //get material cmo
                $isCmo = false;
                $cMo = \App\Models\MasterMaterial::getMaterialCmo($val['material']);
                if( $cMo != null ) {
                    $units = $cMo->uom_code;
                    if( $cMo->purchasing_group_code == 'S03' ||
                         $cMo->purchasing_group_code == 'H09' ||
                         $cMo->purchasing_group_code == 'M09' ||
                         $cMo->purchasing_group_code == 'W03' ||
                         $cMo->purchasing_group_code == 'S09' ||
                         $cMo->purchasing_group_code == 'W09' ||
                         $cMo->purchasing_group_code == 'M03' ) {
                         $isCmo = true;
                     }
                 } else {
                    $cMo = \App\Models\PurchaseRequestsDetail::where('description',$val['material'])
                            ->orWhere('material_id', $val['material'])
                            ->orWhere('short_text', $val['material'])
                            ->first();
                    $units = $cMo->unit;
                             // dd($cMo);
                     if( $cMo->purchasing_group_code == 'S03' ||
                         $cMo->purchasing_group_code == 'H09' ||
                         $cMo->purchasing_group_code == 'M09' ||
                         $cMo->purchasing_group_code == 'W03' ||
                         $cMo->purchasing_group_code == 'S09' ||
                         $cMo->purchasing_group_code == 'W09' ||
                         $cMo->purchasing_group_code == 'M03' ) {
                             $isCmo = true;
                         }
                }

                $totalPrice = \removeComma($val['price'])/$val['qty'] * $val['qty_pr'];

                $priceForAcp = $totalPrice;
                if( 'IDR' != $val['currency'] )  {
                    $priceForAcp = ($request->get('exchange_rate') *  \removeComma($val['price']));
                }

                $assProc = \App\Models\UserMap::getAssProc($cMo->purchasing_group_code)->user_id;
                $material = new AcpTableMaterial();
                $material->master_acp_id            = $acp->id;
                $material->master_acp_vendor_id     = $val['vendor'];
                $material->material_id              = $val['material'];
                $material->price                    = \removeComma($val['price']);
                $material->qty                      = $val['qty'];
                $material->qty_pr                   = $val['qty_pr'];
                $material->total_price              = $totalPrice;
                $material->currency                 = $val['currency'] ?? 'IDR';
                $material->file_attachment          = $val['file_attachment'];
                $material->purchasing_group_code    = $cMo->purchasing_group_code;
                $material->unit                     = $units;
                $material->save();

                // if( $assProc == null ) {
                //     // \Session::flash('error','or this k no approval was found '.$cMo->purchasing_group_code)
                //     return redirect()->route('admin.master-acp.index');
                // }
                if (1 == $val['winner']) {
                    $price += $priceForAcp;//$val['price'];
                    $isAcp = true;
                    // insert to rfq detail
                    $rfqDetail = new MasterRfqDetail();
                    $rfqDetail->purchasing_document = $val['purchasing_document'];
                    $rfqDetail->material            = $val['material'];
                    $rfqDetail->net_order_price     = \removeComma($val['price']);
                    $rfqDetail->save();

                    $materialName = \App\Models\MasterMaterial::getMaterialName($val['material']);
                    // dd($materialName->uom_code);

                    if( $materialName == null ) {
                        $nonMaterial    =  \App\Models\PurchaseRequestsDetail::where('description',$val['material'])
                            ->orWhere('short_text', $val['material'])->first();
                        $desc           = $val['material'] ?? '';
                        $unit           = $nonMaterial->unit ?? '';
                        $storage        = $nonMaterial->storage_location_code ?? '';
                    } else {
                        $desc           = $materialName->description ?? '';
                        $unit           = $materialName->uom_code ?? '';
                        $storage        = $materialName->storage_location_code ?? '';
                    }

                    $rfqDetailNew = new RfqDetail;
                    $rfqDetailNew->material_id                  = $val['material'] ?? '';
                    $rfqDetailNew->short_text                   = $desc;
                    $rfqDetailNew->plant_code                   = $request->get('plant_id');
                    $rfqDetailNew->storage_location_code        = $storage;
                    $rfqDetailNew->qty                          = $val['qty_pr'];
                    $rfqDetailNew->per_unit                     = $val['qty'];
                    $rfqDetailNew->total_price                  = $totalPrice;
                    $rfqDetailNew->unit                         = $unit;
                    $rfqDetailNew->rfq_number                   = $val['rfq_number'];
                    $rfqDetailNew->po_item                      = $poItem;
                    $rfqDetailNew->net_price                    = \removeComma($val['price']);
                    $rfqDetailNew->is_from_po                   = 2;
                    $rfqDetailNew->po_number                    = 0;
                    $rfqDetailNew->purchasing_group_code        = $cMo->purchasing_group_code;
                    $rfqDetailNew->vendor_id                    = $val['vendor'];
                    $rfqDetailNew->save();
                }
            }

            if ($isAcp) {
                if ($price < 100000000 ) {
                    $isPlant = false;
                    if (1 == $request->get('is_project')) {
                        $isPlant = true;
                    }
                    \saveApprovals($assProc, $acp->id, 'STAFF', 'ACP', $isPlant,false);
                    // staff eproc
                } elseif ($price >= 100000000 && $price < 250000000 ) {
                    $isPlant = false;
                    if (1 == $request->get('is_project')) {
                        $isPlant = true;
                    }
                    \saveApprovals($assProc, $acp->id, 'CFO', 'ACP', $isPlant, $isCmo);
                    //CFO
                } elseif ($price > 250000000) {
                    $isPlant = false;
                    if (1 == $request->get('is_project')) {
                        $isPlant = true;
                    }
                    \saveApprovals($assProc, $acp->id, 'COO', 'ACP', $isPlant, $isCmo);
                    //COO
                } else {
                    //cadangan klo gagal approve staff aja
                    \saveApprovals($assProc, $acp->id, 'STAFF', 'ACP', false,false);
                }
            } 

            \DB::commit();

            return redirect()->route('admin.master-acp.index')->with('status', trans('cruds.master-acp.alert_success_insert'));
        } catch (Exception $e) {
            \DB::rollBack();
            // dd($e);
        }
    }

    public function show($id)
    {
        $acp = AcpTable::find($id);
        $approval = QuotationApproval::where('acp_id', $id)
                    ->orderBy('approval_position', 'asc')->get();

        return view('admin.master-acp.show', compact('acp', 'approval'));
    }

    public function showApproval($acp_id)
    {
        $acp = AcpTable::find($acp_id);
        $approval = QuotationApproval::where('acp_id', $acp_id)
                    ->orderBy('approval_position', 'asc')->get();

        return view('admin.master-acp.show-app', compact('acp', 'approval'));
    }

    public function edit($id)
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

    public function update(Request $request, $id)
    {
    }

    public function fileUpload($request)
    {
        $data = [];
        if ($request->hasfile('upload_file')) {
            foreach ($request->file('upload_file') as $file) {
                $name = time().$file->getClientOriginalName();
                $file->move(public_path().'/files/uploads/', $name);
                $data[] = $name;
            }
        }

        return serialize($data);
    }

    public function confirmation(Request $request)
    {
        $data = $request->all();
        $images = [];
        $files = \Storage::disk('public')->allFiles('img_tmp');
        \Storage::disk('public')->delete($files);
        if ($request->hasfile('upload_file')) {
            foreach ($request->file('upload_file') as $file) {
                $path = $file->store('img_tmp', 'public');
                $images[] = asset('storage/'.$path);
            }
        }
        $vendors = Vendor::whereIn('code', $request->input('vendor_id'))->get();

        return view('admin.master-acp.preview', compact('data', 'images', 'vendors'));
    }

    public function getNetPrice(Request $request)
    {
        // $getRfq = \App\Models\AcpTableDetail::where('vendor_code',)
        $data = AcpTableMaterial::where('master_acp_id', $request->master_acp_id)
                ->where('master_acp_vendor_id',$request->vendor_id)
                ->where('material_id', $request->material)
                ->first();

        return response()->json($data, 200);
    }
}
