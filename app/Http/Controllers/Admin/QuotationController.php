<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Models\Vendor\QuotationApproval;
use App\Models\PurchaseOrder;
use App\Models\WorkFlowApproval;
use App\Models\Vendor;
use App\Mail\PurchaseOrderMail;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_if(Gate::denies('quotation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation = Quotation::orderBy('id', 'desc')
            ->groupBy('id', 'request_id')
            ->get();

        return view('admin.quotation.index', compact('quotation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quotation.create');
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:quotation', ['filename' => $real_filename]);

        return redirect('admin/quotation')->with('success', 'Quotation has been successfully imported');
    }

    public function online ()
    {
        $quotation = Quotation::where('status', 1)->orderBy('id', 'desc')->get();

        return view('admin.quotation.online', compact('quotation'));
    }

    public function repeat ()
    {
        $quotation = Quotation::where('status', 0)->orderBy('id', 'desc')->get();

        return view('admin.quotation.repeat', compact('quotation'));
    }

    public function direct ()
    {
        $quotation = Quotation::where('status', 2)->orderBy('id', 'desc')->get();

        return view('admin.quotation.direct', compact('quotation'));
    }

    public function saveOnline (Request $request)
    {
        if (empty($request->get('vendor_id')))
            return redirect()->route('admin.purchase-request-online', $request->get('id'))->with('status', 'No vendor chosen!');

        if (empty($request->get('target_price')))
            return redirect()->route('admin.purchase-request-online', $request->get('id'))->with('status', 'Target Price cannot be zero!');

        \DB::beginTransaction();

        try {
            $vendors = $request->get('vendor_id');
            if (!$vendors)
                return redirect()->route('admin.purchase-request-online', $request->get('id'))->with('status', 'Vendor is required');

            $quotation = new Quotation;
            $quotation->po_no = $request->get('PR_NO');
            $quotation->leadtime_type = $request->get('leadtime_type');
            $quotation->purchasing_leadtime = $request->get('purchasing_leadtime');
            $quotation->target_price = str_replace('.', '', $request->get('target_price'));
            $quotation->expired_date = $request->get('expired_date');
            $quotation->status = 1;
            $quotation->save();

            foreach ($vendors as $row) {
                $quotationDetail = new QuotationDetail;
                $quotationDetail->quotation_order_id = $quotation->id;
                $quotationDetail->vendor_id = $row;
                $quotationDetail->flag = 0;
                $quotationDetail->save();
            }

            $purchaseOrder = new PurchaseOrder;
            $purchaseOrder->bidding = 1;
            $purchaseOrder->po_no = $request->get('PR_NO');
            $purchaseOrder->po_date = date('Y-m-d');
            $purchaseOrder->request_id = $request->get('request_id');
            $purchaseOrder->status = 1;
            $purchaseOrder->save();

            \DB::commit();

            return redirect()->route('admin.quotation.online')->with('status', trans('cruds.purchase-order.alert_success_insert'));
        } catch (Exception $e) {
            \DB::rollBack();
    
            return redirect()->route('admin.quotation.online')->with('error', trans('cruds.purchase-order.alert_error_insert'));
        }
    }

    public function saveRepeat (Request $request)
    {
        if (empty($request->get('qty')))
            return redirect()->route('admin.purchase-request-repeat', $request->get('id'))->with('status', 'Quantity cannot be zero!');

        $qty = str_replace('.', '', $request->get('qty'));

        $quotation = new Quotation;
        $quotation->po_no = $request->get('PR_NO');
        $quotation->status = 0;
        $quotation->vendor_id = $request->get('vendor_id');
        $quotation->save();

        // send email
        $vendor = Vendor::find($request->get('vendor_id'));
        $data = [
            'vendor' => $vendor,
            'request_no' => $request->get('PR_NO'),
            'subject' => 'PO Repeat ' . $request->get('PR_NO')
        ];

        // \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

        return redirect()->route('admin.quotation.repeat')->with('status', 'PO Repeat has been successfully ordered!');
    }

    public function saveDirect (Request $request)
    {
        $filename = '';
            
        if ($request->file('upload_file')) {
            $path = 'quotation/';
            $file = $request->file('upload_file');
            
            $filename = $file->getClientOriginalName();
    
            $file->move($path, $filename);
    
            $real_filename = public_path($path . $filename);
        }

        $quotation = new Quotation;
        $quotation->po_no = $request->get('PR_NO');
        $quotation->notes = $request->get('notes');
        $quotation->upload_file = $filename;
        $quotation->status = 2;
        $quotation->vendor_id = $request->get('vendor_id');
        $quotation->save();

        $vendor = Vendor::find($request->get('vendor_id'));
        $data = [
            'vendor' => $vendor,
            'request_no' => $request->get('PR_NO'),
            'subject' => 'Penunjukkan langsung ' . $request->get('PR_NO')
        ];

        \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

        return redirect()->route('admin.quotation.direct')->with('status', 'Direct Order has been set!');
    }

    public function winner (Request $request)
    {
        $quotation = [];
        
        foreach ($request->get('id') as $id)
            $quotation[$id] = QuotationDetail::find($id);

        return view('admin.quotation.winner', compact('quotation'));
    }

    private function workflowApproval ($no, $quotation_id)
    {
        $workFlowAppr = WorkFlowApproval::where([
            'workflow_id' => $no
        ])->get();

        foreach( $workFlowAppr as $rows ) {
            $flag = 0;
            if( $rows->approval_position == 1 ) {
                $flag = 1;
            }

            $model = new QuotationApproval;
            $model->nik = $rows->nik;
            $model->approval_position = $rows->approval_position;
            $model->status = 0;
            $model->quotation_id = $quotation_id;
            $model->flag = $flag;
            $model->save();
        }
    }

    private function saveApproval($quotation_id, $tingkat)
    {
        $spv = \App\Models\OrangeHrm\SuperiorUser::where('employee_id', \Auth::user()->nik)
                ->where('valid_to','>=',date('Y-m-d'))
                ->first();

        $employee = getZigZagDepartment(\Auth::user()->nik);

        if( $tingkat == 'C_LEVEL' ) {
            QuotationApproval::create([
                'nik'                   => $spv->supervisor_id,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
            ]);

            QuotationApproval::create([
                'nik'                   => getCLevelByDept($employee->department)->nik,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
            ]);
        } else if ($tingkat == 'CFO') {
            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
            ]);
        } else if ($tingkat == 'COO') {
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 4,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
            ]);
        // } else if($tingkat == 'COO' ) {
        //     PurchaseRequestsApproval::create([
        //         'nik'                   => $spv->supervisor_id,
        //         'approval_position'     => PurchaseRequestsApproval::postionAtasanLangsung,
        //         'status'                => PurchaseRequestsApproval::waitingApproval,
        //         'quotation_id'          => $quotation_id,
        //         'flag'                  => 1,
        //     ]);
    
        //     PurchaseRequestsApproval::create([
        //         'nik'                   => getCLevelByDept($employee->department)->nik,
        //         'approval_position'     => postionAtasanLangsung::postionClevel,
        //         'status'                => PurchaseRequestsApproval::waitingApproval,
        //         'purchase_request_id'   => $pr_id,
        //         'flag'                  => 0,
        //     ]);

        //     PurchaseRequestsApproval::create([
        //         'nik'                   => \App\Models\Configuration::where('name','COO')->first()->value,
        //         'approval_position'     => postionAtasanLangsung::postionClevel,
        //         'status'                => PurchaseRequestsApproval::waitingApproval,
        //         'purchase_request_id'   => $pr_id,
        //         'flag'                  => 0,
        //     ]);
        // }else if( $tingkat == 'OWNER') {
        //     PurchaseRequestsApproval::create([
        //         'nik'                   => $spv->supervisor_id,
        //         'approval_position'     => PurchaseRequestsApproval::postionAtasanLangsung,
        //         'status'                => PurchaseRequestsApproval::waitingApproval,
        //         'purchase_request_id'   => $pr_id,
        //         'flag'                  => 1,
        //     ]);
    
        //     PurchaseRequestsApproval::create([
        //         'nik'                   => getCLevelByDept($employee->department)->nik,
        //         'approval_position'     => postionAtasanLangsung::postionClevel,
        //         'status'                => PurchaseRequestsApproval::waitingApproval,
        //         'purchase_request_id'   => $pr_id,
        //         'flag'                  => 0,
        //     ]);

        //     PurchaseRequestsApproval::create([
        //         'nik'                   => \App\Models\Configuration::where('name','COO')->first()->value,
        //         'approval_position'     => PurchaseRequestsApproval::postionAtasanLangsung,
        //         'status'                => PurchaseRequestsApproval::waitingApproval,
        //         'purchase_request_id'   => $pr_id,
        //         'flag'                  => 0,
        //     ]);
    
        //     PurchaseRequestsApproval::create([
        //         'nik'                   => \App\Models\Configuration::where('name','OWNER')->first()->value,
        //         'approval_position'     => postionAtasanLangsung::postionClevel,
        //         'status'                => PurchaseRequestsApproval::waitingApproval,
        //         'purchase_request_id'   => $pr_id,
        //         'flag'                  => 0,
        //     ]);
        } else {
            QuotationApproval::create([
                'nik'                   => $spv->supervisor_id,
                'approval_position'     => QuotationApproval::atasanLangsung,
                'status'                => QuotationApproval::waitingApproval,
                'purchase_request_id'   => $quotation_id,
                'flag'                  => 1,
            ]);
        }
    }

    public function toWinner (Request $request)
    {
        \DB::beginTransaction();

        try {
            foreach ($request->get('id') as $id => $val) {
                $vendor_price = $request->get('vendor_price')[$id];
                $qty = $request->get('qty')[$id];
                $qty = str_replace('.', '', $qty);
                
                $model = QuotationDetail::find((int) $val);
                $model->is_winner = 1;
                $model->qty = $qty;
                $model->save();
            }

            \DB::commit();

            return redirect()->route('admin.quotation.list-winner')->with('success', 'Winner has been set!');
        } catch (Exception $e) {
            \DB::rollBack();
         
            return redirect()->route('admin.quotation.index')->with('error', 'Winner has not been set!');
        }
    }

    public function listWinner ()
    {
        $quotation = Quotation::orderBy('quotation.created_at', 'desc')
            ->get();

        return view('admin.quotation.list-winner', compact('quotation'));
    }

    public function showWinner ($id)
    {
        $quotation = QuotationDetail::where('quotation_order_id', $id)->get();

        return view('admin.quotation.show-winner', compact('quotation', 'id'));
    }

    // public function listAcp ()
    // {
    //     $quotation = QuotationApproval::select(
    //         'quotation.id as id',
    //         'quotation.po_no as po_no',
    //         'vendors.name as name',
    //         'vendors.email as email',
    //         'quotation.target_price as target_price',
    //         'quotation.expired_date as expired_date',
    //         'quotation.vendor_leadtime as vendor_leadtime',
    //         'quotation.vendor_price as vendor_price',
    //         'quotation.qty as qty',
    //         'quotation_approvals.id as approval_id',
    //         'quotation_approvals.quotation_id as quotation_id',
    //     )
    //         ->join('quotation', 'quotation.id', '=', 'quotation_approvals.quotation_id')
    //         ->join('vendors', 'vendors.id', '=', 'quotation.vendor_id')
    //         ->where('quotation_approvals.nik', \Auth::user()->nik)
    //         ->where('quotation_approvals.flag', 1)
    //         ->where('quotation.is_winner', 1)
    //         ->distinct()
    //         ->get();

    //     return view('admin.quotation.list-winner', compact('quotation'));
    // }

    public function approve (Request $request, $id)
    {
        $model = Quotation::find($id);
        $vendor = Vendor::find($model->vendor_id);

        $po = new PurchaseOrder;
        $po->request_id = $id;
        $po->bidding = 0;
        $po->po_date = date('Y-m-d');
        $po->vendor_id = $model->vendor_id;
        $po->status = 0;
        $po->po_no = $model->po_no;
        $po->save();

        if ($model->status == 0) {
            $subject = 'PO Repeat Order ' . $model->po_no;
        } else if ($model->status == 2) {
            $subject = 'Penunjukkan Langsung ' . $model->po_no;
        }

        $data = [
            'vendor' => $model->vendor,
            'request_no' => $model->po_no,
            'subject' => 'Penunjukkan langsung ' . $request->get('request_no')
        ];

        \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

        return redirect()->route('admin.purchase-order.index')->with('success', 'Winner has been set!');
    }

    public function approveWinner (Request $request)
    {
        $id = $request->get('id');
        $quotation_id = $request->get('quotation_id');

        for ($i = 0; $i < count($id); $i++) {
            $id = $id[$i];

            $detail = QuotationDetail::find($id);
            $price = $detail->vendor_price;
            $vendor_id = $detail->vendor_id;
        
            \DB::beginTransaction();

            try {
                if( ($price >= 250000000) ) {
                    $this->saveApproval($quotation_id, 'COO');
                } else if( ($price <= 250000000) && ($price >= 100000000) ) {
                    $this->saveApproval($quotation_id, 'CFO');
                } else {
                    $this->saveApproval($quotation_id, 'No');
                }

                $quotation = Quotation::find($quotation_id);

                $po = new PurchaseOrder;
                $po->request_id = $quotation->request_id;
                $po->bidding = 1;
                $po->po_no = str_replace('PR', 'PO', $quotation->po_no);
                $po->notes = $detail->notes;
                $po->vendor_id = $vendor_id;
                $po->status = 1;
                $po->po_date = date('Y-m-d');
                $po->save();

                \DB::commit();

                return redirect()->route('admin.purchase-order.index')->with('success', 'Bidding has been approved successfully');
            } catch (\Exception $th) {
                \DB::rollback();

                return redirect()->route('admin.quotation.show-winner', $request->get('quotation_id'))->with('success', 'Bidding has been approved failed');
            }
        }
    }

    public function editOnline (Request $request, $id)
    {
        $quotation = Quotation::find($id);

        return view('admin.quotation.edit-online', compact('quotation'));
    }

    public function editRepeat (Request $request, $id)
    {
        $quotation = Quotation::find($id);

        return view('admin.quotation.edit-repeat', compact('quotation'));
    }

    public function editDirect (Request $request, $id)
    {
        $quotation = Quotation::find($id);

        return view('admin.quotation.edit-direct', compact('quotation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quotation = Quotation::create($request->all());

        return redirect()->route('admin.quotation.index')->with('status', trans('cruds.quotation.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);

        return view('admin.quotation.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);

        return view('admin.quotation.edit', compact('quotation'));
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
        $quotation = Quotation::find($id);
        
        if ($request->get('status') == 0) {
            $quotation->qty = $request->get('qty');

            $route = 'repeat';
        } else if ($request->get('status') == 2) {
            $quotation->notes = $request->get('notes');

            $filename = '';
            
            if ($request->file('upload_file')) {
                $path = 'quotation/';
                $file = $request->file('upload_file');
                
                $filename = $file->getClientOriginalName();
        
                $file->move($path, $filename);
        
                $real_filename = public_path($path . $filename);
            }
            
            $quotation->upload_file = $filename;

            $route = 'direct';
        } else {
            $quotation->vendor_leadtime = $request->input('vendor_leadtime');
            $quotation->vendor_price = $request->input('vendor_price');

            $route = 'online';
        }
    
        $quotation->save();
        
        return redirect()->route('admin.quotation.' . $route)->with('status', trans('cruds.quotation.alert_success_update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFromVendor(Request $request, $id)
    {
        $quotation = Quotation::find($id);
        $quotation->notes = $request->input('notes');
        $quotation->upload_file = $request->input('upload_file');
        $quotation->vendor_leadtime = $request->input('vendor_leadtime');
        $quotation->vendor_price = $request->input('vendor_price');
        $quotation->save();
        
        return redirect()->route('admin.quotation.index')->with('status', trans('cruds.quotation.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Quotation::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "quotation deleted successfully";
        } else {
            $success = true;
            $message = "quotation not found";
        }

        // return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
