<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Models\Vendor\QuotationApproval;
use App\Models\AcpTable;
use App\Models\AcpTableDetail;
use App\Models\AcpTableMaterials;
use App\Mail\enesisApprovalAcpMail;

class AcpController extends Controller
{
    public function directAcp()
    {
        $quotation = QuotationApproval::where('nik', \Auth::user()->nik)
                    ->where('flag', QuotationApproval::NotYetApproval)
                    ->where('acp_type', 'DIRECT')
                    ->get();

        return view('admin.acp.direct', compact('quotation'));
    }

    public function acpApproval()
    {
        $quotation = QuotationApproval::where('nik', \Auth::user()->nik)
                    ->where('flag', QuotationApproval::NotYetApproval)
                    ->where('acp_type', 'ACP')
                    ->get();

        return view('admin.acp.acp', compact('quotation'));
    }

    public function listAcpApproval()
    {
        $quotation = QuotationApproval::where('nik', \Auth::user()->nik)
                    ->where('flag', QuotationApproval::alreadyApproval)
                    ->where('acp_type', 'ACP')
                    ->get();

        return view('admin.acp.list-data', compact('quotation'));
    }

    public function biddingAcp ()
    {
        $quotation = QuotationApproval::where('nik', \Auth::user()->nik)
                ->where('flag', QuotationApproval::NotYetApproval)
                ->where('acp_type', 'BIDDING')
                ->get();

        return view('admin.acp.bidding', compact('quotation'));
    }

    public function showDirect (Request $request, $id)
    {
        $model = Quotation::find($id);
        $acp   = AcpTable::find($model->acp_id);

        return view('admin.acp.show-direct', compact('model','acp'));
    }

    public function showBidding (Request $request, $id)
    {
        $quotation = Quotation::find($id);

        return view('admin.acp.show-bidding', compact('quotation'));
    }

    public function showAcpApproval($id)
    {
        $acp   = AcpTable::find($id);
        // dd($acp->detail);

        return view('admin.acp.show-acp-approval', compact('acp'));   
    }


    public function showAcpApprovalFinish($id)
    {
        $acp   = AcpTable::find($id);

        return view('admin.acp.show-acp-approval-finish', compact('acp'));   
    }

    /**
     * approval PR and send To Sap
     * @author didi
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    public function approvalDirectAcp(Request $request)
    {
        \DB::beginTransaction();
        try {
            //get data
            $posisi     = QuotationApproval::where('quotation_id',$request->quotation_id)->where('nik',\Auth::user()->nik)->first();
            $total      = QuotationApproval::where('quotation_id',$request->quotation_id)->count();
            $quotation  = Quotation::find($request->quotation_id);
 
            //check posisi approval
            if( (int) $posisi->approval_position == (int) $total ) {
                $quotation->approval_status = Quotation::Approved;
                $quotation->update();
                //current approval update
                QuotationApproval::where('quotation_id',$request->quotation_id)->where('nik',\Auth::user()->nik)->update([
                    'status'        => QuotationApproval::Approved,
                    'flag'          => QuotationApproval::alreadyApproval,
                    'approve_date'  => \Carbon\Carbon::now(),
                ]);
                //to SAP
            } else if( $posisi->approval_position < $total ) {
                $posisi = $posisi->approval_position + 1;

                //current approval update
                QuotationApproval::where('quotation_id',$request->quotation_id)->where('nik',\Auth::user()->nik)->update([
                    'status'        => QuotationApproval::Approved,
                    'flag'          => QuotationApproval::alreadyApproval,
                    'approve_date'  => \Carbon\Carbon::now(),
                ]);

                //next approval 
                QuotationApproval::where('quotation_id',$request->quotation_id)->where('approval_position', $posisi)->update([
                    'status' => QuotationApproval::waitingApproval,
                    'flag'   => QuotationApproval::NotYetApproval,
                ]);
                
                //kirim email next
                // $getNext    = PurchaseRequestsApproval::where('purchase_request_id',$request->pr_id)
                //             ->where('approval_position', $posisi)
                //             ->first();
                
                // Mail::to($email)->send(new enesisPurchaseRequest($pr, $name));
            }
            \DB::commit();
        } catch (\Exception $th) {
            \DB::rollback();
            throw $th;
        }

        // Return response
        return \redirect()->route('admin.acp-direct')->with('status','PO successfully approved');
    }

    public function approvalAcp(Request $request)
    {
        $configEnv = \configEmailNotification();
        \DB::beginTransaction();
        try {
            //get data
            $posisi     = QuotationApproval::where('quotation_id',$request->quotation_id)->where('nik',\Auth::user()->nik)->first();
            $total      = QuotationApproval::where('quotation_id',$request->quotation_id)->count();
            $acp        = AcpTable::find($request->quotation_id);
            //check posisi approval
            if( (int) $posisi->approval_position == (int) $total ) {
                $acp->status_approval = AcpTable::Approved;
                $acp->update();
                //current approval update
                QuotationApproval::where('quotation_id',$request->quotation_id)->where('nik',\Auth::user()->nik)->update([
                    'status'        => QuotationApproval::Approved,
                    'flag'          => QuotationApproval::alreadyApproval,
                    'approve_date'  => \Carbon\Carbon::now(),
                ]);
                //to SAP
            } else if( $posisi->approval_position < $total ) {
                $posisi = $posisi->approval_position + 1;
                //current approval update
                QuotationApproval::where('quotation_id',$request->quotation_id)->where('nik',\Auth::user()->nik)
                ->update([
                    'status'        => QuotationApproval::Approved,
                    'flag'          => QuotationApproval::alreadyApproval,
                    'approve_date'  => \Carbon\Carbon::now(),
                ]);

                //next approval 
                $next = QuotationApproval::where('quotation_id',$request->quotation_id)->where('approval_position', $posisi)->update([
                    'status' => QuotationApproval::waitingApproval,
                    'flag'   => QuotationApproval::NotYetApproval,
                ]);

                
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = $configEnv->value;
                    $name  = "Didi Ganteng";
                } else {
                    $email = \Auth::user()->email;
                    $name  = \Auth::user()->name;
                }
                
                \Mail::to($email)->send(new enesisApprovalAcpMail($acp, $name));
            }
            \DB::commit();
        } catch (\Exception $th) {
            \DB::rollback();
            throw $th;
        }

        // Return response
        return \redirect()->route('admin.acp-approval')->with('status','Acp has been approved');
    }

    public function acpApprovalReject(Request $request)
    {
        $update = QuotationApproval::where('quotation_id', $request->id)
            ->where('nik', \Auth::user()->nik)
            ->update([
                'status'        => 3,
                'reason_reject' => $request->reason,
                'flag'          => QuotationApproval::alreadyApproval,
                'approve_date'  => \Carbon\Carbon::now(),
            ]);

        $acp = AcpTable::find($request->id);
        $acp->status_approval = AcpTable::Rejected;
        $acp->update();

        \Session::flash('status','Acp has been rejected');
    }
} 
