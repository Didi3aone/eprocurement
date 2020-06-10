<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PrPo;
use App\Models\PurchaseRequestsDetail;
use App\Models\PurchaseRequestsApproval;
use App\Models\RequestNotes;
use App\Models\RequestNotesDetail;
use App\Models\WorkFlowApproval;
use App\Models\WorkFlow;
use App\Models\Plant;
use App\Models\Vendor;
use DB,Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('purchase_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materials = PurchaseRequestsDetail::select(
            \DB::raw('purchase_requests_details.id as id'),
            'purchase_requests_details.request_id',
            'purchase_requests_details.description',
            'purchase_requests_details.qty',
            'purchase_requests_details.unit',
            'purchase_requests_details.notes',
            'purchase_requests_details.price',
            'purchase_requests_details.material_id',
            \DB::raw('purchase_requests_details.request_no as rn_no'),
            'purchase_requests_details.release_date',
            \DB::raw('purchase_requests.request_no as pr_no'),
            'purchase_requests.request_date',
            'purchase_requests.total'
        )
            ->leftJoin('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
            ->where('purchase_requests_details.is_validate', 1)
            ->where('qty', '>', 0)
            ->where('purchase_requests_details.status_approval', 704)
            ->orWhere('purchase_requests_details.status_approval', 705)
            ->orderBy('purchase_requests.created_at', 'desc')
            ->get();

        foreach ($materials as $row) {
            $row->uuid = $row->getAttributes()['id'];
        }

        return view('admin.purchase-request.index', compact('materials'));
    }

    protected function createPrPo ($ids, $quantities = null)
    {
        $po_no = sprintf('1%08d', time());
        $ids = explode(',', $ids);

        if ($quantities)
            $quantities = explode(',', $quantities);

        $data = [];
        $prs = [];

        foreach ($ids as $i => $id) {
            $pr = PurchaseRequestsDetail::select(
                    'purchase_requests_details.*',
                    'purchase_requests.request_no as pr_no',
                    'purchase_requests.request_date as request_date'
                )
                ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
                ->where('purchase_requests_details.id', $id)
                ->first();

            if ($quantities)
                $pr->qty = $quantities[$i];

            array_push($data, $pr);
        }

        $vendor = Vendor::where('status', 1)->orderBy('name')->get();

        return [
            'po_no' => $po_no,
            'data' => $data,
            'vendor' => $vendor
        ];
    }

    public function online (Request $request, $ids)
    {
        $ids = base64_decode($ids);
        $return = $this->createPrPo($ids);

        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];

        $uri = [
            'ids' => base64_encode($ids)
        ];
        
        return view('admin.purchase-request.online', compact('data', 'po_no', 'vendor', 'uri'));
    }

    public function repeat (Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);
        
        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities)
        ];
        
        return view('admin.purchase-request.repeat', compact('data', 'po_no', 'vendor', 'uri'));
    }

    public function direct (Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);
        
        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities)
        ];
        
        return view('admin.purchase-request.direct', compact('data', 'po_no', 'vendor', 'uri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pr = PurchaseRequestsDetail::where('purchase_id', $id)->get();

        return view('admin.purchase-request.pr.show', compact('pr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create purchase request from RN
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_from_rn($id)
    {
        $rn = RequestNotes::find($id);

        $rnDetail = RequestNotesDetail::where('request_id', $id)
            ->where('is_available_stock', 3)
            ->get();

        return view('admin.purchase-request.pr.create-from-rn', compact('rnDetail', 'rn'));
    }

    private function workflowApproval ($id, $pr_id)
    {
        $workFlowAppr = WorkFlowApproval::where('workflow_id', $id)->get();

        foreach( $workFlowAppr as $rows ) {
            $flag = 0;
            if( $rows->approval_position == 1 ) {
                $flag = 1;
            }

            PurchaseRequestsApproval::create([
                'nik'                   => $rows->nik,
                'approval_position'     => $rows->approval_position,
                'status'                => 0,
                'purchase_request_id'   => $pr_id,
                'flag'                  => $flag,
            ]);
        }
    }

    public function save_from_rn (Request $request)
    {
        try {
            DB::beginTransaction();
            $purchaseRequest = new PurchaseRequest;
            $purchaseRequest->request_no   = $request->input('request_no');
            $purchaseRequest->request_date = $request->input('date');
            $purchaseRequest->notes        = $request->input('notes');
            $purchaseRequest->total        = $request->input('total');
            $purchaseRequest->save();

            $total = $request->input('total');

            $workFlow = WorkFlow::get();

            // update table rn
            RequestNotes::where('request_no',$request->request_no)->update([
                'is_pr' => 1
            ]);

            if( ($total >= 0) && ($total <= 200000000) ) {
                $this->workflowApproval(1, $purchaseRequest->id);
            } else if( $total >= 200000000 && $total <= 1000000000) {
                $this->workflowApproval(2, $purchaseRequest->id);
            } else {
                $this->workflowApproval(3, $purchaseRequest->id);
            }

            for ($i = 0; $i < count($request->get('rn_description')); $i++) {
                $purchaseRequestDetail = new PurchaseRequestsDetail;
                $purchaseRequestDetail->purchase_id = $purchaseRequest->id;
                $purchaseRequestDetail->description = $request->input('rn_description')[$i];
                $purchaseRequestDetail->qty = $request->input('rn_qty')[$i];
                $purchaseRequestDetail->unit = $request->input('rn_unit')[$i];
                $purchaseRequestDetail->notes = $request->input('rn_notes')[$i];
                $purchaseRequestDetail->price = $request->input('rn_price')[$i];
                $purchaseRequestDetail->save();
            }

            DB::commit();

        } catch (\Throwable $th) {
            //throw $th;
            echo $th;
            DB::rollback();
            return redirect()->route('admin.purchase-request.index')->withInputs();
        }

        return redirect()->route('admin.purchase-request.index')->with('status', trans('cruds.purchase-request.alert_success_insert'));
    }

    public function listApproval()
    {
        abort_if(Gate::denies('purchase_request_approval_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $pr = PurchaseRequestsApproval::with('getPurchaseRequest')
            ->where('nik', Auth::user()->nik)
            ->where('flag', 1)
            ->get();

        return view('admin.purchase-request.pr.approval', compact('pr'));
    }

    public function listValidate()
    {
        abort_if(Gate::denies('purchase_request_approval_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $pr = PurchaseRequest::where('is_validate',0)->get();

        return view('admin.purchase-request.pr.validate', compact('pr'));
    }

    public function approvalPr(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $posisi = PurchaseRequestsApproval::where('id',$request->id)->first();

            $total = PurchaseRequestsApproval::where('purchase_request_id',$request->req_id)
                ->get();

            $dt = [];
            if( $posisi->approval_position == count($total) ) {
                PurchaseRequestsApproval::where('id',$request->id)->update([
                    'status' => 1,
                    'approve_date' => date('Y-m-d H:i:s'),
                    'flag' => 2
                ]);

                PurchaseRequest::where('id', $request->req_id)
                    ->update([
                        'approval_status' => 12
                    ]);
                
            } else if( $posisi->approval_position < count($total) ) {
                $posisi = $posisi->approval_position + 1;

                PurchaseRequestsApproval::where('purchase_request_id',$request->req_id)
                    ->where('approval_position', $posisi)
                        ->update([
                        'status' => 0,
                        'flag' => 1
                    ]);

                PurchaseRequest::where('id', $request->req_id)
                    ->update([
                        'approval_status' => 11
                    ]);
            }

            $updates = PurchaseRequestsApproval::where('id',$request->id)->update([
                'status' => 1,
                'flag' => 2,
                'approve_date' => date('Y-m-d H:i:s')
            ]);

            DB::commit();

            if ($updates == 1) {
                $success = true;
                $message = "Purchase request has been approved";
            } else {
                $success = false;
                $message = "Purchase not found";
            }
        } catch (\Exception $th) {
            //throw $th;
            $success = false;
            $message = "error db".$th;
            DB::rollback();
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function saveValidate(Request $request)
    {
        if( $request->has('purchase_id') ) {
            PurchaseRequest::where('id', $request->get('purchase_id'))
                ->update([
                    'is_validate' => 1
                ]);
            PurchaseRequestsDetail::where('purchase_id', $request->get('purchase_id'))->delete();

            for ($i = 0; $i < count($request->get('rn_description')); $i++) {
                $purchaseRequestDetail = new PurchaseRequestsDetail;
                $purchaseRequestDetail->purchase_id = $request->get('purchase_id');
                $purchaseRequestDetail->description = $request->input('rn_description')[$i];
                $purchaseRequestDetail->qty = $request->input('rn_qty')[$i];
                $purchaseRequestDetail->unit = $request->input('rn_unit')[$i];
                $purchaseRequestDetail->notes = $request->input('rn_notes')[$i];
                $purchaseRequestDetail->price = $request->input('rn_price')[$i];
                $purchaseRequestDetail->is_assets = $request->input('is_assets')[$i];
                $purchaseRequestDetail->save();
            }
        }

        return redirect()->route('admin.purchase-request-list-validate')->with('status', 'Validate successfuly saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDetail($id)
    {
        $prDetail = PurchaseRequestsDetail::where('request_id', $id)->get();
        $pr       = PurchaseRequest::find($id);
        $papproval = PurchaseRequestsApproval::where('purchase_request_id',$id)->orderBy('approval_position','asc')->get();

        return view('admin.purchase-request.pr.show-detail', compact('pr','prDetail','papproval'));
    }
}
