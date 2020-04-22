<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationApproval;
use App\Models\WorkFlowApproval;
use App\Models\Vendor;

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

        $quotation = Quotation::orderBy('id', 'desc')->get();

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

    public function winner (Request $request)
    {
        $quotation = [];
        
        foreach ($request->get('id') as $id)
            $quotation[$id] = Quotation::find($id);

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

    public function toWinner (Request $request)
    {
        \DB::beginTransaction();

        try {
            foreach ($request->get('id') as $id => $val) {
                $vendor_price = $request->get('vendor_price')[$id];
                $qty = $request->get('qty')[$id];
                
                $total = $vendor_price * $qty;

                if( ($total >= 0) && ($total <= 100000000) ) {
                    $this->workflowApproval(2, $val);
                } else if( $total >= 100000000 && $total <= 250000000) {
                    $this->workflowApproval(3, $val);
                } else {
                    $this->workflowApproval(4, $val);
                }

                $model = Quotation::find((int) $val);
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
        $quotation = QuotationApproval::select(
            'quotation.id as id',
            'quotation.po_no as po_no',
            'vendors.name as name',
            'vendors.email as email',
            'quotation.target_price as target_price',
            'quotation.expired_date as expired_date',
            'quotation.vendor_leadtime as vendor_leadtime',
            'quotation.vendor_price as vendor_price',
            'quotation.qty as qty',
            'quotation_approvals.id as approval_id',
            'quotation_approvals.quotation_id as quotation_id',
        )
            ->join('quotation', 'quotation.id', '=', 'quotation_approvals.quotation_id')
            ->join('vendors', 'vendors.id', '=', 'quotation.vendor_id')
            ->where('quotation_approvals.nik', \Auth::user()->nik)
            ->where('quotation_approvals.flag', 1)
            ->where('quotation.is_winner', 1)
            ->distinct()
            ->get();

        return view('admin.quotation.list-winner', compact('quotation'));
    }

    public function approveWinner (Request $request)
    {
        \DB::beginTransaction();

        $qa_id = $request->get('id');
        $id = $request->get('req_id');

        try {
            $posisi = QuotationApproval::where('id', $qa_id)->first();

            $total = QuotationApproval::where('quotation_id', $id)
                ->get();

            $dt = [];
            if( $posisi->approval_position == count($total) ) {
                $qa = QuotationApproval::find($qa_id);
                $qa->status = 1;
                $qa->approve_date = date('Y-m-d H:i:s');
                $qa->flag = 2;
                $qa->save();

                $model = Quotation::find($id);
                $model->approval_status = 12;
                $model->save();
            } else if( $posisi->approval_position < count($total) ) {
                $posisi = $posisi->approval_position + 1;

                QuotationApproval::where('quotation_id', $id)
                    ->where('approval_position', $posisi)
                    ->update([
                        'status' => 0,
                        'flag' => 1,
                    ]);

                $model = Quotation::find($id);
                $model->approval_status = 11;
                $model->save();
            }

            $updates = QuotationApproval::find($qa_id);
            $updates->status = 1;
            $updates->flag = 2;
            $updates->approve_date = date('Y-m-d H:i:s');

            if ($updates->save()) {
                $success = true;
                $message = "Quotation has been approved";
            } else {
                $success = false;
                $message = "Quotation not found";
            }

            \DB::commit();
        } catch (\Exception $th) {
            //throw $th;
            $success = false;
            $message = "error db" . $th;

            \DB::rollback();
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
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
        $quotation->notes = $request->input('notes');
        $quotation->upload_file = $request->input('upload_file');
        $quotation->vendor_leadtime = $request->input('vendor_leadtime');
        $quotation->vendor_price = $request->input('vendor_price');
        $quotation->save();
        
        return redirect()->route('admin.quotation.index')->with('status', trans('cruds.quotation.alert_success_update'));
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
