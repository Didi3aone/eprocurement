<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use Gate;
use App\Models\Vendor;
use App\Models\UserMap;
use App\Models\Currency;
use App\Models\PaymentTerm;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\Vendor\Quotation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\PurchaseRequestsDetail;
use App\Mail\enesisPurchaseRequestAdminDpj;
use App\Models\PurchaseRequestApprovalHistory;
use Symfony\Component\HttpFoundation\Response;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userMapping = UserMap::where('user_id', Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);
        // dd($userMapping);
        $materials = PurchaseRequestsDetail::select(
            \DB::raw('purchase_requests_details.id as id'),
            'purchase_requests_details.request_id',
            'purchase_requests_details.description',
            'purchase_requests_details.qty',
            'purchase_requests_details.unit',
            'purchase_requests_details.notes',
            'purchase_requests_details.price',
            'purchase_requests_details.preq_item',
            'purchase_requests_details.preq_name',
            'purchase_requests_details.plant_code',
            'purchase_requests_details.short_text',
            'purchase_requests_details.storage_location',
            'purchase_requests_details.material_group',
            'purchase_requests_details.purchasing_group_code',
            'purchase_requests_details.material_id',
            'purchase_requests_details.delivery_date',
            \DB::raw('purchase_requests_details.request_no as rn_no'),
            'purchase_requests_details.release_date',
            \DB::raw('purchase_requests.request_no as pr_no'),
            'purchase_requests.request_date',
            'purchase_requests.PR_NO',
            'purchase_requests.total',
            'purchase_requests.doc_type',
            'purchase_requests.id as uuid'
        )
            ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
            ->whereNotNull('purchase_requests.PR_NO')
            ->where('purchase_requests_details.qty', '>', 0)
            ->where('purchase_requests_details.is_validate', PurchaseRequestsDetail::YesValidate)
            ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
            ->whereIn('purchase_requests_details.status_approval', [PurchaseRequestsDetail::Approved, PurchaseRequestsDetail::ApprovedPurchasing])
            // ->where('purchase_requests_details.line_no', '0000000001')
            //     ->orWhere('purchase_requests_details.line_no', '000000000')
            // ->where(function ($query) {
            //     $query->where('purchase_requests_details.status_approval', PurchaseRequestsDetail::Approved)
            //         ->orWhere('purchase_requests_details.status_approval', PurchaseRequestsDetail::ApprovedPurchasing);
            // })
            ->whereIn('purchase_requests.status_approval', [PurchaseRequest::ApprovedDept, PurchaseRequest::ApprovedProc]);
        // ->where(function ($query) {
        //     $query->where('purchase_requests.status_approval', PurchaseRequest::ApprovedDept)
        //         ->orWhere('purchase_requests.status_approval', PurchaseRequest::ApprovedProc);
        // });
        // ->orderBy('purchase_requests.created_at', 'asc');
        if (\request()->ajax()) {
            $q = \collect($request->all())->forget('draw')->forget('_')->toJson();
            $result = \Cache::remember($q.\Auth::user()->user_id, 60, function () use ($request, $materials, $q) {
                $columns = [
                    0 => 'id',
                    1 => 'PR_NO',
                    2 => 'preq_item',
                    3 => 'release_date',
                    4 => 'material_id',
                    5 => 'short_text',
                    9 => 'plant_code',
                    15 => 'purchasing_group_code',
                    18 => 'request_no',
                    18 => 'pr_no',
                    19 => 'delivery_date',
                    10 => 'storage_location',
                    12 => 'qty_order',
                    11 => 'qty',
                    16 => 'preq_name',
                    14 => 'material_group'

                ];
                $totalData = $materials->count();

                $totalFiltered = $materials
                    ->when($request->input('search.value'), function ($q) use ($request) {
                        $search = $request->input('search.value');
                        $q->where(function ($q) use ($search) {
                            $q->where('PR_NO', 'ILIKE', "%{$search}%")
                                ->orWhere('material_id', 'ILIKE', "%{$search}%")
                                ->orWhere('short_text', 'ILIKE', "%{$search}%")
                                ->orWhere('purchasing_group_code', 'ILIKE', "%{$search}%");
                        });
                    })->count();

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                $items = $materials
                    ->when($request->input('search.value'), function ($q) use ($request) {
                        $search = $request->input('search.value');
                        $q->where(function ($q) use ($search) {
                            $q->where('PR_NO', 'ILIKE', "%{$search}%")
                            // ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
                                ->orWhere('material_id', 'ILIKE', "%{$search}%")
                                ->orWhere('doc_type', 'ILIKE', "%{$search}%")
                                ->orWhere('short_text', 'ILIKE', "%{$search}%")
                                ->orWhere('purchasing_group_code', 'ILIKE', "%{$search}%");
                        });
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                // $paginate = $materials->paginate(10,['*'],'draw');
                // $paginate = $materials->paginate(10,['*'],'draw');
                $result = [
                    'draw' => (int) \request()->get('draw'),
                    'recordsTotal' => $totalData,
                    'recordsFiltered' => $totalFiltered,
                    'request' => \collect($request->all())->forget('draw')->forget('_'),
                    'q' => $q,
                    'data' => \collect($items)->map(function ($value, $key) use ($start) {
                        if ('' != $value->material_id) {
                            $getLast = '';
                            if (null != \App\Models\RfqDetail::getLastPo($value->material_id)) {
                                $getLast = \App\Models\RfqDetail::getLastPo($value->material_id)->po_number;
                            }
                        } else {
                            $getLast = '';
                            if (null != \App\Models\RfqDetail::getLastPo($value->short_text)) {
                                $getLast = \App\Models\RfqDetail::getLastPo($value->short_text)->po_number;
                            }
                        }
                        // dd($getLast);

                        $other = \App\Models\PurchaseRequestApprovalHistory::getHistoryApproval($value->uuid);
                        $other = $other->map(function ($row) {
                            return [
                                $row->nik.(\App\Models\employeeApps\User::getUser($row->nik)->name ?? ''),
                                $row->action,
                                \Carbon\Carbon::parse($row->created_at)->format('d-m-Y'),
                            ];
                        });

                        // $getHistPo = [];
                        // if( $value->material_id != '' ) {
                        // }
                        $unit = $value->unit;
                        if (null != \App\Models\UomConvert::where('uom_1', $value->unit)->first()) {
                            $unit = \App\Models\UomConvert::where('uom_1', $value->unit)->first()->uom_2;
                        }

                        return [
                            ($key + 1) + $start, //0
                            $value->PR_NO, //1
                            $value->doc_type, //2
                            $value->preq_item, //3
                            $value->release_date, //4
                            $value->material_id ?? '-', //5
                            $value->short_text, //6
                            $value->qty, //7
                            $unit, //8
                            $value->plant_code, //9
                            $value->storage_location, //10
                            $value->qty, //11
                            $value->qty - $value->qty_order, //12
                            'D', //13
                            $value->material_group, //14
                            $value->purchasing_group_code, //15
                            $value->preq_name, //16
                            $getLast, //17
                            $value->request_no ?? $value->pr_no, //18
                            $value->delivery_date, //19
                            // '0000',
                            [
                                $value->id,
                                $value->qty,
                                $value->doc_type,
                                $value->purchasing_group_code,
                            ], //19
                            $other,
                        ];
                    }),
                ];

                return $result;
            });
            $result['draw'] = (int) \request()->get('draw');

            return \response()->json($result);
        }

        return view('admin.purchase-request.index');
    }

    /**
     * Display a listing of the resource.
     * approval pr project.
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalProject()
    {
        $userMapping = UserMap::where('user_id', Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);

        $prProject = PurchaseRequestsDetail::join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
                    ->where('purchase_requests.status_approval', PurchaseRequest::ApprovedDept)
                    ->where('purchase_requests.is_approve_procurement', PurchaseRequest::ApprovalProc)
                    ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
                    ->where('purchase_requests.doc_type', 'like', 'Z%')
                    ->select(
                        'purchase_requests.request_no',
                        'purchase_requests.request_date',
                        'purchase_requests.is_urgent',
                        'purchase_requests.notes',
                        'purchase_requests.id',
                    )
                    ->groupBy('purchase_requests.id')
                    ->get();

        return view('admin.purchase-request.approval-project', compact('prProject'));
    }

    public function show($id)
    {
        $prProject = PurchaseRequest::find($id);

        return view('admin.purchase-request.show', compact('prProject'));
    }

    /**
     * resource for create po.
     *
     * @param mixed      $ids
     * @param mixed|null $quantities
     *
     * @return array
     */
    protected function createPrPo($ids, $quantities = null)
    {
        $max = PurchaseRequest::select(\DB::raw('count(id) as id'))->first()->id;
        $po_no = 'PO/'.date('m').'/'.date('Y').'/'.sprintf('%07d', ++$max);
        $ids = explode(',', $ids);

        $quantities = explode(',', $quantities);

        $data = [];
        foreach ($ids as $i => $id) {
            $pr = PurchaseRequestsDetail::select(
                'purchase_requests_details.*',
                'purchase_requests.request_no as pr_no',
                'purchase_requests.PR_NO',
                'purchase_requests.doc_type',
                'purchase_requests.request_date as request_date',
                'purchase_requests.upload_file',
            )
                ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
                ->where('purchase_requests_details.id', $id)
                ->first();

            if ($quantities[$i]) {
                $pr->qty = $quantities[$i];
            }

            array_push($data, $pr);
        }

        $vendor = Vendor::orderBy('name')->get();

        return [
            'po_no' => $po_no,
            'data' => $data,
            'vendor' => $vendor,
            'top' => \App\Models\PaymentTerm::all(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $ids
     * @param mixed $quantities
     *
     * @return \Illuminate\Http\Response
     */
    public function online(Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);

        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities),
        ];

        return view('admin.purchase-request.online', compact('data', 'po_no', 'vendor', 'uri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $ids
     * @param mixed $quantities
     * @param mixed $docs
     * @param mixed $groups
     *
     * @return \Illuminate\Http\Response
     */
    public function repeat(Request $request, $ids, $quantities)
    {
        $qty = explode(',', $quantities);
        // dd(count($qty));
        ini_set('memory_limit', '20000M');
        //ini_set('memory_limit', '-1');
        set_time_limit(0);
        $ids = base64_decode($ids);

        $groups = PurchaseRequestsDetail::select(
                    'purchase_requests_details.purchasing_group_code',
                )
                ->whereIn('purchase_requests_details.id', explode(',',$ids))
                ->get()
                ->toArray();

        $docs = PurchaseRequestsDetail::select(
                    'purchase_requests.doc_type',
                )
                ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
                ->whereIn('purchase_requests_details.id', explode(',',$ids))
                ->get()
                ->toArray();
        $checkDoc   = \checkArraySame($docs);
        $checkGroup = \checkArraySame($groups);
        if (false == $checkDoc) {
            return redirect()->route('admin.purchase-request.index')->with('error', 'Doc type. must be the same');
        }

        if (false == $checkGroup) {
            return redirect()->route('admin.purchase-request.index')->with('error', 'Purchasing group. must be the same');
        }

        $return = $this->createPrPo($ids, $quantities);

        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];
        $top = $return['top'];

        $docType = $docs[0]['doc_type'];
        $type = '';
        if ('SY01' == $docType || 'SY02' == $docType || 'Z102' == $docType) {
            $type = 'Z300';
        } elseif ('Z100' == $docType) {
            $type = 'Z301';
        } elseif ('Z104' == $docType) {
            $type = 'Z302';
        } elseif ('Z101' == $docType) {
            $type = 'Z303';
        } elseif ('Z107' == $docType) {
            $type = 'Z304';
        }

        $docTypes = DocumentType::where('type', '2')
                ->where('code', $type)
                ->get();
        $shipTo   = \App\Models\MasterShipToAdress::all()->pluck('name','id');

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities),
        ];

        return view('admin.purchase-request.repeat', compact(
            'data',
            'docTypes',
            'po_no',
            'vendor',
            'uri',
            'top',
            'shipTo'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $ids
     * @param mixed $quantities
     * @param mixed $docs
     * @param mixed $groups
     *
     * @return \Illuminate\Http\Response
     */
    public function direct(Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);

       
        $groups = PurchaseRequestsDetail::select(
                'purchase_requests_details.purchasing_group_code',
            )
            ->whereIn('purchase_requests_details.id', explode(',',$ids))
            ->get()
            ->toArray();

        $docs = PurchaseRequestsDetail::select(
            'purchase_requests.doc_type',
        )
            ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
            ->whereIn('purchase_requests_details.id', explode(',',$ids))
            ->get()
            ->toArray();
        $checkDoc = checkArraySame($docs);
        $checkGroup = \checkArraySame($groups);

        if (false == $checkDoc) {
            return redirect()->route('admin.purchase-request.index')->with('error', 'Doc type. must be the same');
        }

        if (false == $checkGroup) {
            return redirect()->route('admin.purchase-request.index')->with('error', 'Purchasing group. must be the same');
        }

        $return = $this->createPrPo($ids, $quantities);

        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];
        $top = $return['top'];

        $docType = $docs[0]['doc_type'];
        $type = '';
        if ('SY01' == $docType || 'SY02' == $docType || 'Z102' == $docType) {
            $type = 'Z300';
        } elseif ('Z100' == $docType) {
            $type = 'Z301';
        } elseif ('Z104' == $docType) {
            $type = 'Z302';
        } elseif ('Z101' == $docType) {
            $type = 'Z303';
        } elseif ('Z107' == $docType) {
            $type = 'Z304';
        }

        // dd($docs);
        $docTypes = DocumentType::where('type', '2')
                ->where('code', $type)
                ->get();

        $shipTo   = \App\Models\MasterShipToAdress::all()->pluck('name','id');

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities),
        ];

        return view('admin.purchase-request.direct', compact(
            'data',
            'docTypes',
            'po_no',
            'vendor',
            'uri',
            'top',
            'shipTo'
        ));
    }

    /**
     * approval PR user procurement
     * v.2.
     *
     * @author didi
     *
     * @param array $request
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalPrStaffPurchasing(Request $request)
    {
        DB::beginTransaction();
        try {
            $configEnv = \configEmailNotification();
            $prHeader = PurchaseRequest::find($request->pr_id);

            $isSendSap = false;
            foreach ($request->idDetail as $key => $value) {
                $prDetail = PurchaseRequestsDetail::find($value);
                $status = PurchaseRequestsDetail::Approved;
                if (PurchaseRequestsDetail::ApprovalPurchasing == $prDetail->type_approval) {
                    $status = PurchaseRequestsDetail::ApprovedPurchasing;
                }

                $leadTime = \App\Models\RekapLeadtime::calculateLeadTime(
                        $prDetail->material_id,
                        $prDetail->plant_code
                    );

                if( $prHeader->is_project == PurchaseRequest::Project ) {
                    if( PurchaseRequestsDetail::MaterialText 
                        OR PurchaseRequestsDetail::Service ) {
                            $grProccess = $prDetail->gr_processing_time;
                            $delivPlan  = $prDetail->deliv_plan_processing_time;
                            $finalLeadTime = ($grProccess + $delivPlan + 30 + 1);
                            $delivery_date = date('Y-m-d', strtotime('+'.$finalLeadTime.' weekday'));
                        }
                } else {
                    if( PurchaseRequestsDetail::MaterialText 
                        OR PurchaseRequestsDetail::Service ) {
                            $grProccess    = $prDetail->gr_processing_time;
                            $delivPlan     = $prDetail->deliv_plan_processing_time;
                            $finalLeadTime = ($grProccess + $delivPlan + 14 + 1);
                            $delivery_date = date('Y-m-d', strtotime('+'.$finalLeadTime.' weekday'));
                        }
                }

                //echo $delivery_date;die;
                if (null != $leadTime) {
                    $today = \Carbon\Carbon::now();
                    $approveDate = $today->toDateString();
                    $finalLeadTime = $leadTime->planned_deliv_time + $leadTime->gr_processing_time;

                    $prDetail->release_date = date('Y-m-d');
                    $prDetail->delivery_date = date('Y-m-d', strtotime($approveDate.' + '.$finalLeadTime.' weekday'));
                    if (PurchaseRequest::Project == $prHeader->is_project) {
                        $delivery_date = date('Y-m-d', strtotime('+30 weekday'));
                    } else {
                        $delivery_date = date('Y-m-d', strtotime($approveDate.' + '.$finalLeadTime.' weekday'));
                    }
                }
                $prDetail->delivery_date = $delivery_date;

                $prDetail->status_approval = $status;
                $assetNo = '';
                if (PurchaseRequestsDetail::Assets == $prDetail->is_assets) {
                    $assetNo = $prDetail->assets_no;
                }

                //substr tracking no
                if ('DIRECT' == $prDetail->request_no) {
                    $trackNo1 = substr($prHeader->request_no, 0, 2);
                    $trackNo2 = substr($prHeader->request_no, 9);
                    $TRACKINGNO = $trackNo1.$trackNo2;
                    $TRACKINGNO = str_replace('PR','PRJ',$TRACKINGNO);
                } else {
                    $trackNo1 = substr($prDetail->request_no, 0, 2);
                    $trackNo2 = substr($prDetail->request_no, 9);
                    $TRACKINGNO = $trackNo1.$trackNo2;
                    $TRACKINGNO = str_replace('RN','PRJ',$TRACKINGNO);
                }

                if (PurchaseRequestsDetail::YesValidate == $prDetail->is_validate
                    && PurchaseRequestsDetail::YesValidate == $prHeader->is_validate) {
                    $isSendSap = true;

                    //for sap
                    $param_sap[$key]['DOC_TYPE'] = $prHeader->doc_type;
                    $param_sap[$key]['HEADER_ID'] = $prHeader->id;
                    $param_sap[$key]['PUR_GROUP'] = $prDetail->purchasing_group_code;
                    $param_sap[$key]['PREQ_NAME'] = strtoupper(split_name($prDetail->preq_name));
                    $param_sap[$key]['SHORT_TEXT'] = $prDetail->short_text ?? 'tes';
                    $param_sap[$key]['MATERIAL'] = '-' == $prDetail->material_id ? '' : $prDetail->material_id;
                    $param_sap[$key]['PLANT'] = $prDetail->plant_code;
                    $param_sap[$key]['STORE_LOC'] = $prDetail->storage_location ?? '';
                    $param_sap[$key]['TRACKINGNO'] = $TRACKINGNO;
                    $param_sap[$key]['MAT_GRP'] = $prDetail->material_group ?? '';
                    $param_sap[$key]['QUANTITY'] = $prDetail->qty;
                    $param_sap[$key]['UNIT'] = $prDetail->unit;
                    $param_sap[$key]['DELIV_DATE'] = $delivery_date;
                    $param_sap[$key]['REL_DATE'] = $prDetail->release_date;
                    $param_sap[$key]['ACCTASSCAT'] = $prDetail->account_assignment;
                    $param_sap[$key]['GR_IND'] = $prDetail->gr_ind;
                    $param_sap[$key]['IR_IND'] = $prDetail->ir_ind;
                    $param_sap[$key]['TEXT_ID'] = 'PR';
                    $param_sap[$key]['TEXT_FORM'] = 'EN';
                    $param_sap[$key]['TEXT_LINE'] = $prDetail->text_line ?? 'test';
                    $param_sap[$key]['G_L_ACCT'] = $prDetail->gl_acct_code;
                    $param_sap[$key]['ASSET_NO'] = $assetNo;
                    $param_sap[$key]['CO_AREA'] = 'EGCA';
                    $param_sap[$key]['PROFIT_CTR'] = $prDetail->profit_center_code;
                    $param_sap[$key]['PREQ_ITEM'] = $prDetail->preq_item;
                    $param_sap[$key]['CATEGORY'] = $prDetail->category;
                    $param_sap[$key]['PACKAGE_NO'] = $prDetail->package_no;
                    $param_sap[$key]['SUBPACKAGE_NO'] = $prDetail->subpackage_no;
                    $param_sap[$key]['LINE_NO'] = $prDetail->line_no;
                    $param_sap[$key]['COST_CTR'] = $prDetail->cost_center_code;
                }

                $prDetail->update();
            }

            if ($isSendSap) {
                $sap = \sapHelp::sendToSAP($param_sap);
                if (isset($sap->PRNO) && '' != $sap->PRNO) {
                    \App\Models\employeeApps\SapLogSoap::create([
                        'log_type' => 'PURCHASE REQUEST',
                        'log_type_id' => $prHeader->id,
                        'log_params_employee' => \json_encode($param_sap),
                        'log_response_sap' => $sap->PRNO,
                        'status' => 'SUCCESS',
                    ]);

                    $prHeader->is_send_sap = 'YES';
                    $prHeader->PR_NO = $sap->PRNO;
                    $prHeader->status = PurchaseRequest::Success;
                } else {
                    \Session::flash('notif_error',$sap->RETURN->item);
                    // dd($sap->RETURN->item->MESSAGE);
                    \App\Models\employeeApps\SapLogSoap::create([
                        'log_type' => 'PURCHASE REQUEST',
                        'log_type_id' => $prHeader->id,
                        'log_params_employee' => \json_encode($param_sap),
                        'log_response_sap' => \json_encode($sap),
                        'status' => 'FAILED',
                    ]);

                    return \redirect()->route('admin.purchase-request.show', $prHeader->id);//->with('error', $sap->RETURN->item->MESSAGE);
                }
            }

            $prHeader->status_approval = PurchaseRequest::ApprovedProc;
            $prHeader->approved_proc_by = \Auth::user()->nik;
            $prHeader->update();

            if (\App\Models\BaseModel::Development == $configEnv->type) {
                $email = $configEnv->value;
                $name = \getEmailLocal($prHeader->created_by)->name;
            } else {
                $email = \getEmailLocal($prHeader->created_by)->email;
                $name = \getEmailLocal($prHeader->created_by)->name;
            }

            $pr = $prHeader;
            Mail::to($email)->send(new enesisPurchaseRequestAdminDpj($pr, $name));

            //insert to log
            PurchaseRequestApprovalHistory::create([
                'nik' => \Auth::user()->nik,
                'action' => 'Approved',
                'request_id' => $request->pr_id,
                'reason' => '-',
            ]);
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }

        // Return response
        return \redirect()->route('admin.purchase-request-project')->with('status', 'PR Project has been approved');
    }

    /**
     * rejected pr proccess.
     *
     * @author didi
     *
     * @param array $request
     *
     * @return \Illuminate\Http\Response
     */
    public function rejectedPr(Request $request)
    {
        $message['is_error'] = true;
        $message['error_msg'] = '';

        if ($request) {
            $prUpdate = PurchaseRequest::find($request->id);
            $prUpdate->status = PurchaseRequest::Rejected;
            $prUpdate->status_approval = PurchaseRequest::Rejected;
            $prUpdate->reject_reason = $request->reason;
            $prUpdate->update();

            PurchaseRequestsDetail::where('request_id', $request->id)->update([
                'status_approval' => PurchaseRequestsDetail::Rejected,
            ]);

            \Session::flash('status', 'Purchase request has been rejected');
            $configEnv = \configEmailNotification();
            if (\App\Models\BaseModel::Development == $configEnv->type) {
                $email = $configEnv->value;
                $name = \getEmailLocal($prUpdate->created_by)->name;
            } else {
                $email = \getEmailLocal($prUpdate->created_by)->email;
                $name = \getEmailLocal($prUpdate->created_by)->name;
            }

            $pr = $prUpdate;
            Mail::to($email)->send(new enesisPurchaseRequestAdminDpj($pr, $name));
            PurchaseRequestApprovalHistory::create([
                'nik' => \Auth::user()->nik,
                'action' => 'Rejected',
                'request_id' => $request->id,
                'reason' => '-',
            ]);
            $message['is_error'] = false;
        } else {
            $message['is_error'] = true;
            $message['error_msg'] = 'Failed update database';
        }

        return response()->json($message);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response\Json
     */
    public function getMaterialPr(Request $request)
    {
        $data = PurchaseRequestsDetail::where(function ($query) use ($request) {
            $query->where('material_id', 'like', '%'.$request->query('q').'%')
                ->orWhere('description', 'like', '%'.$request->query('q').'%');
        })->select(
                'id',
                'material_id as code',
                'description',
                'unit',
                'qty',
                'gl_acct_code',
                'cost_center_code',
                'profit_center_code',
                'storage_location',
                'short_text',
                'purchasing_group_code',
                'plant_code',
            )
            ->get();

        return \Response::json($data);
    }

    public function confirmation(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // dd($data['plant_code'][0]);
        // dd($data);
        $docType = DocumentType::where('code', $request->input('doc_type'))->first();
        $paymentTerm = PaymentTerm::where('payment_terms', $request->input('payment_term'))->first();
        $max = Quotation::select(\DB::raw('count(id) as id'))->first()->id;
        $poNo = 'PO/'.date('m').'/'.date('Y').'/'.sprintf('%07d', ++$max);
        $vendor = Vendor::where('code', $request->input('vendor_id'))->first();
        $title = 'Purchase Order';
        $ship = \App\Models\MasterShipToAdress::find($request->ship_id);
        $print = false;
        // dd($request->all());
        $pdf = PDF::loadview('prints/purchase-order', \compact('data', 'poNo', 'vendor', 'docType', 'paymentTerm', 'title', 'print','ship'))
            ->setPaper('A4', 'potrait')
            ->setOptions(['debugCss' => true, 'isPhpEnabled' => true])
            ->setWarnings(true);
        // $pdf->save(public_path("storage/{$id}_print.pdf"));
        // Mail::to('jul14n4v@gmail.com')->send(new SendMail($po));
        // $print = true;
        return $pdf->stream();
    }
}
