<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;

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

        $pr = PurchaseRequest::with([
                'purchaseRequestDetail' => function ($q) {
                    $q->where('is_available_stock', 3);
                }
            ])
            ->get();

        return view('admin.purchase-request.index', compact('pr'));
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
        //
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

    public function save_from_rn (Request $request)
    {
        $purchaseRequest = new PurchaseRequest;
        $purchaseRequest->request_no = $request->input('request_no');
        $purchaseRequest->date = $request->input('date');
        $purchaseRequest->notes = $request->input('notes');
        
        $firstApproval = 10000000;
        $secondApproval = 100000000;
        $thirdApproval = 1000000000;

        if (0 <= $firstApproval) {
            $approvalPosition = 1;
            $rateFrom = 0;
            $rateTo = $firstApproval;
        } else if ($firstApproval <= $secondApproval) {
            $approvalPosition = 2;
            $rateFrom = $firstApproval;
            $rateTo = $secondApproval;
        } else if ($secondApproval <= $thirdApproval) {
            $approvalPosition = 3;
            $rateFrom = $secondApproval;
            $rateTo = $thirdApproval;
        }
        
        $purchaseRequest->rate_from = $rateFrom;
        $purchaseRequest->rate_to = $rateTo;
        $purchaseRequest->approval_position = $approvalPosition;
        $purchaseRequest->total = $request->input('total');
        $purchaseRequest->save();

        for ($i = 0; $i < count($request->input('price')); $i++) {
            $purchaseRequestDetail = new PurchaseRequestDetail;
            $purchaseRequestDetail->purchase_id = $purchaseRequest->id;
            $purchaseRequestDetail->description = $request->input('rn_description')[$i];
            $purchaseRequestDetail->qty = $request->input('rn_qty')[$i];
            $purchaseRequestDetail->unit = $request->input('rn_unit')[$i];
            $purchaseRequestDetail->notes = $request->input('rn_notes')[$i];
            $purchaseRequestDetail->price = $request->input('rn_price')[$i];
            $purchaseRequestDetail->save();
        }

        return redirect()->route('admin.purchase-request.index')->with('status', trans('cruds.purchase-request.alert_success_insert'));
    }
}
