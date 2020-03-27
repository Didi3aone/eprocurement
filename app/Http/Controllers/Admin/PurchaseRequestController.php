<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail;
use App\Models\PurchaseRequestsApproval;
use App\Models\RequestNotes;
use App\Models\RequestNotesDetail;
use App\Models\WorkFlowApproval;
use App\Models\WorkFlow;
use DB,Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

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

        $pr = PurchaseRequest::where('status',0)->get();

        return view('admin.purchase-request.pr.index', compact('pr'));
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

    public function approvalPr(Request $request)
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
                        'flag' => 1,
                    ]);

                PurchaseRequest::where('id', $request->req_id)
                    ->update([
                        'approval_status' => 11
                    ]);
            }

            $updates = PurchaseRequestsApproval::where('id',$request->id)->update([
                'status' => 1,
                'flag' => 2,
                'approve_date' => date('Y-m-d H:i:s'),
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
        $prDetail = PurchaseRequestsDetail::where('purchase_id', $id)->get();
        $pr       = PurchaseRequest::find($id);
        $papproval = PurchaseRequestsApproval::where('purchase_request_id',$id)->orderBy('approval_position','asc')->get();

        return view('admin.purchase-request.pr.show-detail', compact('pr','prDetail','papproval'));
    }
}
