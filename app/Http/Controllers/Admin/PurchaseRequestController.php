<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail; 
use App\Models\PurchaseRequestApprovalHistory;
use App\Models\MasterRfqDetail;
use App\Models\Plant;
use App\Models\DocumentType;
use App\Models\UserMap;
use App\Models\Vendor;
use DB,Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\enesisPurchaseRequestAdminDpj;
use App\Mail\enesisPurchaseRequestPurchasing;
use Illuminate\Support\Facades\Mail;

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

        $userMapping = UserMap::where('user_id', Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);
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
            ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
            ->where('purchase_requests_details.is_validate', PurchaseRequestsDetail::YesValidate)
            ->where('purchase_requests_details.qty', '>', 0)
            ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
            ->where(function ($query) {
                $query->where('purchase_requests_details.status_approval', PurchaseRequestsDetail::Approved)
                    ->orWhere('purchase_requests_details.status_approval', PurchaseRequestsDetail::ApprovedPurchasing);
            })
            ->where(function ($query) {
                $query->where('purchase_requests.status_approval', PurchaseRequest::ApprovedDept)
                    ->orWhere('purchase_requests.status_approval', PurchaseRequest::ApprovedProc);
            })
            ->orderBy('purchase_requests.created_at', 'asc')
            ->get();

        foreach ($materials as $row) {
            $row->uuid = $row->getAttributes()['id'];
        }

        return view('admin.purchase-request.index', compact('materials'));
    }

    /**
     * Display a listing of the resource.
     * approval pr project
     * @return \Illuminate\Http\Response
     */
    public function approvalProject()
    {
        $userMapping = UserMap::where('user_id', Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);

        $prProject = PurchaseRequestsDetail::join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
                    ->where('purchase_requests.status_approval', PurchaseRequest::ApprovedDept)
                    ->whereIn('purchase_requests_details.purchasing_group_code',$userMapping)
                    ->select(
                        'purchase_requests.request_no',
                        'purchase_requests.request_date',
                        'purchase_requests.is_urgent',
                        'purchase_requests.notes',
                        'purchase_requests.id',
                    )
                    ->get();
        return view('admin.purchase-request.approval-project', compact('prProject'));
    }

    public function show($id)
    {
        $prProject = PurchaseRequest::find($id);
        return view('admin.purchase-request.show', compact('prProject'));
    }

    /**
     * resource for create po
     * @return array
     */
    protected function createPrPo ($ids, $quantities = null)
    {
        $max = PurchaseRequest::select(\DB::raw('count(id) as id'))->first()->id;
        $po_no = 'PO/' . date('m') . '/' . date('Y') . '/' . sprintf('%07d', ++$max);
        $ids = explode(',', $ids);

        if ($quantities)
            $quantities = explode(',', $quantities);

        $data = [];
        foreach ($ids as $i => $id) {
            $pr = PurchaseRequestsDetail::select(
                'purchase_requests_details.*',
                'purchase_requests.request_no as pr_no',
                'purchase_requests.PR_NO',
                'purchase_requests.request_date as request_date'
            )
                ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
                ->where('purchase_requests_details.id', $id)
                ->first();

            if ($quantities[$i])
                $pr->qty = $quantities[$i];
                
            array_push($data, $pr);
        }

        $vendor = Vendor::orderBy('name')->get();

        return [
            'po_no' => $po_no,
            'data' => $data,
            'vendor' => $vendor,
            'top'    => \App\Models\PaymentTerm::all()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function online (Request $request, $ids, $quantities)
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
        
        return view('admin.purchase-request.online', compact('data', 'po_no', 'vendor', 'uri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function repeat (Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);
        
        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];
        $top = $return['top'];

        $docTypes = DocumentType::where('type','2')->get();

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities)
        ];
        
        return view('admin.purchase-request.repeat', compact('data', 'docTypes', 'po_no', 'vendor', 'uri','top'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function direct (Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);
        
        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];

        $docTypes = DocumentType::get();

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities)
        ];
        
        return view('admin.purchase-request.direct', compact('data', 'docTypes', 'po_no', 'vendor', 'uri'));
    }

    /**
     * approval PR user procurement
     * v.2
     * @author didi
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    public function approvalPrStaffPurchasing(Request $request)
    {
        DB::beginTransaction();
        try {
            $configEnv    = \configEmailNotification();
            $prHeader  = PurchaseRequest::find($request->pr_id);

            $isSendSap = false;
            foreach( $request->idDetail as $key => $value ) {

                $prDetail = PurchaseRequestsDetail::find($value);
                $status = PurchaseRequestsDetail::Approved;
                if( $prDetail->type_approval == PurchaseRequestsDetail::ApprovalPurchasing ) {
                    $status = PurchaseRequestsDetail::ApprovedPurchasing;
                }

                $leadTime = \App\Models\RekapLeadtime::getLeadTime(
                            $prDetail->material_id,
                            $prDetail->plant_code, 
                            $prDetail->purchasing_group_code);  
                
                if( $leadTime != null)  {
                    $today = \Carbon\Carbon::now();
                    $approveDate   = $today->toDateString();
                    $finalLeadTime = $leadTime->lead_time_pr_po + $leadTime->lead_time_po_gr;
                    
                    $prDetail->release_date        = date('Y-m-d', strtotime($approveDate. ' + '.$finalLeadTime.' days'));
                    $prDetail->delivery_date       = date('Y-m-d', strtotime($approveDate. ' + '.$finalLeadTime.' days'));
                }
                $prDetail->status_approval     = $status;
                $assetNo = "";
                if( $prDetail->is_assets == PurchaseRequestsDetail::Assets ) {
                    $assetNo = $prDetail->assets_no;
                } 

                //substr tracking no
                if( $prDetail->request_no == 'DIRECT' ) {
                    $trackNo1   = substr($prHeader->request_no,0,2);
                    $trackNo2   = substr($prHeader->request_no,9);
                    $TRACKINGNO = $trackNo1.$trackNo2;
                } else {
                    $trackNo1   = substr($prDetail->request_no,0,2);
                    $trackNo2   = substr($prDetail->request_no,9);
                    $TRACKINGNO = $trackNo1.$trackNo2;
                }

                if( $prDetail->is_validate == PurchaseRequestsDetail::YesValidate 
                    && $prHeader->is_validate == PurchaseRequestsDetail::YesValidate ) {
                    $isSendSap = true;
                    
                    //for sap
                    $param_sap[$key]['DOC_TYPE']      = $prHeader->doc_type;
                    $param_sap[$key]['PUR_GROUP']     = $prDetail->purchasing_group_code;
                    $param_sap[$key]['PREQ_NAME']     = strtoupper(split_name($prDetail->preq_name));
                    $param_sap[$key]['SHORT_TEXT']    = $prDetail->short_text ?? 'tes';
                    $param_sap[$key]['MATERIAL']      = $prDetail->material_id == '-' ? '' : $prDetail->material_id;
                    $param_sap[$key]['PLANT']         = $prDetail->plant_code;
                    $param_sap[$key]['STORE_LOC']     = $prDetail->storage_location ?? "";
                    $param_sap[$key]['TRACKINGNO']    = $TRACKINGNO;
                    $param_sap[$key]['MAT_GRP']       = $prDetail->material_group ?? "";
                    $param_sap[$key]['QUANTITY']      = $prDetail->qty;
                    $param_sap[$key]['UNIT']          = $prDetail->unit;
                    $param_sap[$key]['DELIV_DATE']    = $prDetail->delivery_date;
                    $param_sap[$key]['REL_DATE']      = $prDetail->release_date;
                    $param_sap[$key]['ACCTASSCAT']    = $prDetail->account_assignment;
                    $param_sap[$key]['GR_IND']        = $prDetail->gr_ind;
                    $param_sap[$key]['IR_IND']        = $prDetail->ir_ind;
                    $param_sap[$key]['TEXT_ID']       = 'PR';
                    $param_sap[$key]['TEXT_FORM']     = 'EN';
                    $param_sap[$key]['TEXT_LINE']     = $prDetail->text_line ?? 'test';
                    $param_sap[$key]['G_L_ACCT']      = $prDetail->gl_acct_code;
                    $param_sap[$key]['ASSET_NO']      = $assetNo;
                    $param_sap[$key]['CO_AREA']       = 'EGCA';
                    $param_sap[$key]['PROFIT_CTR']    = $prDetail->profit_center_code;
                    $param_sap[$key]['PREQ_ITEM']     = $prDetail->preq_item;
                    $param_sap[$key]['CATEGORY']      = $prDetail->category;
                    $param_sap[$key]['PACKAGE_NO']    = $prDetail->package_no;
                    $param_sap[$key]['SUBPACKAGE_NO'] = $prDetail->subpackage_no;
                    $param_sap[$key]['LINE_NO']       = $prDetail->line_no;
                    $param_sap[$key]['COST_CTR']      = $prDetail->cost_center_code;
                }

                $prDetail->update();
            }

            if( $isSendSap ) {
                $sap = \sapHelp::sendToSAP($param_sap); 
                if ( isset($sap->PRNO) && $sap->PRNO != "" ) {
                    \App\Models\employeeApps\SapLogSoap::create([
                        'log_type'            => 'PURCHASE REQUEST',
                        'log_type_id'         => $prHeader->id,
                        'log_params_employee' => \json_encode($param_sap),
                        'log_response_sap'    => $sap->PRNO,
                        'status'              => 'SUCCESS'
                    ]);
    
                    $prHeader->is_send_sap          = 'YES';
                    $prHeader->PR_NO                = $sap->PRNO;
                    $prHeader->status               = PurchaseRequest::Success;
    
                } else {
                    \App\Models\employeeApps\SapLogSoap::create([
                        'log_type'            => 'PURCHASE REQUEST',
                        'log_type_id'         => $prHeader->id,
                        'log_params_employee' => \json_encode($param_sap),
                        'log_response_sap'    => \json_encode($sap),
                        'status'              => 'FAILED'
                    ]);

                    return \redirect()->route('admin.purchase-request-show-approval', $prHeader->id)->with('error','Internal server error');
                }
            }

            $prHeader->status_approval      = PurchaseRequest::ApprovedProc;
            $prHeader->update();

            if( $configEnv->type == \App\Models\BaseModel::Development ) {
                $email    = $configEnv->value;
                $name     = \getEmailLocal($prHeader->created_by)->name;
            } else {
                $email    = \getEmailLocal($prHeader->created_by)->email;
                $name     = \getEmailLocal($prHeader->created_by)->name;
            }
            
            $pr = $prHeader;
            Mail::to($email)->send(new enesisPurchaseRequestAdminDpj($pr, $name));

            //insert to log
            PurchaseRequestApprovalHistory::create([
                'nik'           => \Auth::user()->nik,
                'action'        => 'Approved',
                'request_id'    => $request->pr_id,
                'reason'        => '-'
            ]);
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }

        // Return response
        return \redirect()->route('admin.purchase-request-project')->with('status','PR Project has been approved');
    }
}
