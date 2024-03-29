<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\PurchaseRequestHistory;
use Gate, Artisan, Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Models\Vendor\QuotationServiceChild;
use App\Models\Vendor\QuotationApproval;
use App\Models\Vendor\QuotationDelivery;
use PDF;
use App\Mail\SendMail;
use App\Mail\poApprovalAssproc;
use App\Mail\poApprovalHead;

class QuotationRepeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();
        // $userMapping = explode(',', $userMapping->purchasing_group_code);
        $quotation = QuotationDetail::join('quotation','quotation.id','=','quotation_details.quotation_order_id')
                    ->join('vendors','vendors.code','=','quotation.vendor_id')
                    ->where('quotation.status', '=', Quotation::QuotationRepeat)
                    ->where(function ($query){

                        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();
                        $userMapping = explode(',', $userMapping->purchasing_group_code);

                        $query->where('quotation.approval_status',Quotation::Waiting);
                        $query->orWhere('quotation.approval_status', Quotation::ApprovalAss);
                        $query->orWhere('quotation.approval_status', Quotation::Rejected);
                        $query->whereIn('quotation_details.purchasing_group_code', $userMapping);
                    })
                    ->select(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.vendor_id',
                        'quotation.approval_status',
                        'vendors.company_name',
                        'quotation.status',
                    )
                    ->groupBy(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.vendor_id',
                        'quotation.approval_status',
                        'vendors.company_name',
                        'quotation.status',
                    )
                    ->orderBy('id', 'desc');
        
        if( \Auth::user()->roles[0]->title == 'Admin' ) {
            $quotation = $quotation;
        } else {
            $quotation = $quotation->where('created_by', \Auth::user()->nik);
        }

        $quotation = $quotation->get();
        return view('admin.quotation.repeat.index', compact('quotation'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalListAss()
    {
        abort_if(Gate::denies('approval_po_repeat_assproc'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();

        $userMapping = explode(',', $userMapping->purchasing_group_code);
        $quotation = QuotationDetail::join('quotation','quotation.id','=','quotation_details.quotation_order_id')
                    ->leftJoin('vendors','vendors.code','=','quotation.vendor_id')
                    ->where('quotation.status',Quotation::QuotationRepeat)
                    ->where('quotation.approval_status',Quotation::Waiting)
                    ->whereIn('quotation_details.purchasing_group_code', $userMapping)
                    ->select(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.approval_status',
                        'vendors.company_name',
                        'vendors.email',
                        'quotation.status',
                        \DB::raw('sum(quotation_details.price) as totalValue')
                    )
                    ->groupBy(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.approval_status',
                        'vendors.company_name',
                        'vendors.email',
                        'quotation.status',
                    )
                    ->orderBy('id', 'desc')
                    ->get();
        return view('admin.quotation.repeat.index-approval', compact('quotation'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalListHead()
    {
        abort_if(Gate::denies('approval_po_repeat_prochead'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = QuotationDetail::join('quotation','quotation.id','=','quotation_details.quotation_order_id')
                    ->leftJoin('vendors','vendors.code','=','quotation.vendor_id')
                    ->where('quotation.status',Quotation::QuotationRepeat)
                    ->where('quotation.approval_status',Quotation::ApprovalAss)
                    ->where('quotation.approved_head','PROCUREMENT01')
                    ->select(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.approval_status',
                        'quotation.created_at',
                        'vendors.name',
                        'quotation_details.id as detailId',
                        'quotation_details.short_text',
                        'quotation_details.material',
                        'quotation_details.purchasing_group_code',
                        'quotation_details.plant_code',
                        'quotation_details.price',
                        'quotation_details.orginal_price',
                        'quotation_details.total_price',
                        'quotation_details.currency',
                        'quotation_details.tax_code',
                        'quotation_details.qty',
                        'quotation_details.PO_ITEM',
                        'quotation_details.delivery_date',
                        'quotation_details.PR_NO',
                        'quotation_details.purchasing_document',
                        'quotation_details.storage_location',
                        'quotation_details.preq_name',
                        'quotation_details.material_group',
                        'quotation_details.PREQ_ITEM',
                        'quotation_details.acp_id',
                        'quotation.status',
                    )
                    ->orderBy('id', 'desc')
                    ->get();
        $quotation = [];
        foreach( $data as $key => $rows ) {
            $quotation[$rows->po_no][] = $rows;
        }

        return view('admin.quotation.repeat.index-approval-head', compact('quotation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'ship_id' => 'required',
                'notes' => 'required'
            ]);
            $qty = 0;
            $price = 0;
            $details = [];
            for ($i = 0; $i < count($request->get('qty')); $i++) {
                $qy = str_replace('.', '', $request->get('qty')[$i]);
                $qty += $qy;
    
                // update material qty
                $material = PurchaseRequestsDetail::where('id', $request->idDetail[$i])->first();
                $material->qty_requested = $material->qty;
                // insert to pr history
                $requestNo = '';
                if( $request->get('rn_no')[$i] == 'DIRECT') {
                    $requestNo = $request->get('pr_no')[$i];
                } else {
                    $requestNo = $request->get('rn_no')[$i];
                }
    
                // insert to pr history
                $data = [
                    'request_detail_id'         => $request->idDetail[$i],
                    'request_no'                => $request->get('rn_no')[$i],
                    'pr_id'                     => $request->get('pr_no')[$i],
                    'rn_no'                     => $request->get('rn_no')[$i],
                    'material_id'               => $request->get('material_id')[$i],
                    'description'               => $request->get('description')[$i],
                    'unit'                      => $request->get('unit')[$i],
                    'vendor_id'                 => $request->get('vendor_id'),
                    'plant_code'                => $request->get('plant_code')[$i],
                    'price'                     => $request->get('price')[$i],
                    'original_price'            => $request->get('original_price')[$i],
                    'original_currency'         => $request->get('original_currency')[$i],
                    'qty'                       => $request->get('qty')[$i],
                    'qty_pr'                    => $material->qty,
                    'is_assets'                 => $request->get('is_assets')[$i],
                    'assets_no'                 => $request->get('assets_no')[$i],
                    'short_text'                => $request->get('short_text')[$i],
                    'text_id'                   => $request->get('text_id')[$i],
                    'text_form'                 => $request->get('text_form')[$i],
                    'text_line'                 => $request->get('text_line')[$i],
                    'delivery_date_category'    => $request->get('delivery_date_category')[$i],
                    'account_assignment'        => $request->get('account_assignment')[$i],
                    'purchasing_group_code'     => $request->get('purchasing_group_code')[$i],
                    'preq_name'                 => $request->get('preq_name')[$i],
                    'gl_acct_code'              => $request->get('gl_acct_code')[$i],
                    'cost_center_code'          => $request->get('cost_center_code')[$i],
                    'profit_center_code'        => $request->get('profit_center_code')[$i],
                    'storage_location'          => $request->get('storage_location')[$i],
                    'material_group'            => $request->get('material_group')[$i],
                    'preq_item'                 => $request->get('preq_item')[$i],
                    'PR_NO'                     => $request->get('PR_NO')[$i],
                    'delivery_date'             => $request->get('delivery_date')[$i],
                    'delivery_date_new'         => $request->get('delivery_date_new')[$i],
                    'rfq'                       => $request->get('rfq')[$i],
                    'tax_code'                  => $request->get('tax_code')[$i] ?? "",
                    'vendor_id'                 => $request->vendor_id,
                    'request_no'                => $requestNo,
                    'acp_id'                    => $request->get('acp_id')[$i],
                    'item_category'             => $request->get('category')[$i],
                    'notes'                     => $request->get('notes_detail')[$i],
                    'is_free_item'              => $request->get('is_free_item')[$i] ?? 0
                ];
    
                array_push($details, $data);
                PurchaseRequestHistory::insertHistory($data);
    
                $material->qty      -= $request->get('qty')[$i];
                $material->qty_order = $request->get('qty')[$i];
                $material->save();
            }

            $file_upload = "";
            if ($request->upload_file) {
                $file_upload = $this->fileUpload($request);
            }
            $max  = Quotation::select(\DB::raw('count(id) as id'))->first()->id;
            $poNo = 'PO/' . date('m') . '/' . date('Y') . '/' . sprintf('%07d', ++$max);

            $payVendor = \App\Models\Vendor::where('code', $request->vendor_id)
                ->first()->payment_terms;
            $quotation = new Quotation;
            $quotation->po_no           = $poNo;
            $quotation->notes           = $request->get('notes');
            $quotation->doc_type        = $request->get('doc_type');
            $quotation->upload_file     = $file_upload;
            $quotation->currency        = $request->get('currency');
            $quotation->exchange_rate   = $request->get('exchange_rate');
            $quotation->payment_term    = $request->get('payment_term') ?? $payVendor;
            $quotation->vendor_id       = $request->vendor_id;
            $quotation->status          = Quotation::QuotationRepeat;
            $quotation->exchange_rate   = $request->exchange_rate;
            $quotation->ship_id         = $request->ship_id;
            $quotation->approval_status = Quotation::Waiting;

            $quotation->save();

             //insert ITEM
            $detail = $this->_insert_details($details, $quotation->id);
            // dd($detail);
            if( true == $detail['is_error'] ) {
                \Session::flash('notif', $detail['error']); 
                //rollback if error send sap
                \DB::rollBack();
                //ini rollback ga jalan jadi pake cara orang awam
                Quotation::where('id', $quotation->id)->delete();
                QuotationDetail::where('quotation_order_id', $quotation->id)->delete();

                //balikin qty
                for ($i = 0; $i < count($request->get('qty')); $i++) {
                    $qy = str_replace('.', '', $request->get('qty')[$i]);
                    $qty += $qy;
                    // update material qty
                    $material = PurchaseRequestsDetail::where('id', $request->id[$i])->first();
                    $material->qty_requested = $material->qty;
                    $material->qty       += $request->get('qty')[$i];
                    $material->qty_order -= $request->get('qty')[$i];
                    $material->save();
                }

                return redirect()->route('admin.purchase-request.index');
            } else {
                //done process
                return redirect()->route('admin.quotation-repeat.index')->with('status', 'Direct Order has been successfully ordered!');
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('admin.quotation-repeat.index')->with('status', 'Repeat Order has been successfully ordered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::find($id);

        return view('admin.quotation.repeat.show',compact('quotation'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showApproval($id)
    {
        $quotation = Quotation::find($id);

        return view('admin.quotation.repeat.show-approval',compact('quotation'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showApprovalHead($id)
    {
        $quotation = Quotation::find($id);

        return view('admin.quotation.repeat.show-approval-head',compact('quotation'));
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
        $quotationDetail = QuotationDetail::where('quotation_order_id', $id)
                        ->get();
        //update lagi qty ke awal 
        foreach( $quotationDetail as $key => $rows ) {
            $poDetail = PurchaseRequestsDetail::where('id', $rows->request_detail_id)->first();
            // dd($poDetail);
            if( $poDetail != null ) {
                $poDetail->qty += $rows->qty;
                $poDetail->update();
            }
        }
        
        $quotation = Quotation::find($id);
        $quotation->delete();

        QuotationDetail::where('quotation_order_id', $id)->delete();
        QuotationDelivery::where('quotation_id', $id)->delete();
        $service = QuotationServiceChild::where('quotation_id', $id)->first();
        if( null != $service ) {
            $service->delete();
        }

        
        return redirect()->route('admin.quotation-repeat.index')->with('status', 'Direct Order has been successfully deleted !');
    }

     /**
     * multiple approve po.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function repeatpproveAss($ids)
    {
        try {
            $ids = base64_decode($ids);
            $ids = explode(',', $ids);

            foreach( $ids as $id ) {
                $quotation = Quotation::find($id);
                $quotation->approval_status    = Quotation::ApprovalAss;
                $quotation->approved_asspro    = \Auth::user()->user_id;
                $quotation->approved_date_ass  = date('Y-m-d');
                $quotation->save();

                $configEnv = \configEmailNotification();
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = $configEnv->value;
                    $name  = "Didi Ganteng";
                } else {
                    $head = \App\Models\User::where('user_id', 'PROCUREMENT01')->first();
                    $email = $head->email;
                    $name  = $head->name;
                }

                \Mail::to($email)->send(new poApprovalHead($quotation,$name));
            }

            return redirect()->route('admin.quotation-repeat-approval-ass')->with('status', 'Direct Order has been approved!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * multiple approve po.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function repeatApproveHead($ids)
    {
        try {
            $ids = base64_decode($ids);
            $ids = explode(',', $ids);
            // dd($ids);
            foreach( $ids as $id ) {
                $quotation = Quotation::where('po_no',$id)->first();
                // dd($quotation);
                $quotationDetail = QuotationDetail::where('quotation_order_id', $quotation->id)->get();
                $quotationDeliveryDate = QuotationDelivery::where('quotation_id', $quotation->id)->get();
                // dd($quotationDetail);
                // $sendSap = true;
                $sendSap = \sapHelp::sendPoToSap($quotation, $quotationDetail,$quotationDeliveryDate);
                if( $sendSap ) {
                    $this->_clone_purchase_orders($quotation, $quotationDetail, $sendSap);
                    $quotation->approval_status     = Quotation::ApprovalHead;
                    $quotation->approved_head       = \Auth::user()->user_id;
                    $quotation->approved_date_head  = date('Y-m-d');
                    $quotation->save();
                } else {
                    return redirect()->route('admin.quotation-repeat-approval-head')->with('error', 'Internal server error');
                }
            }

            return redirect()->route('admin.quotation-repeat-approval-head')->with('status', 'Direct Order has been approved!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

     /**
     * multiple approve po.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function repeatRejected(Request $request)
    {
        $quotation = Quotation::find($request->id);
        $quotation->approval_status     = Quotation::Rejected;
        $quotation->approved_asspro     = \Auth::user()->user_id;
        $quotation->approved_date_ass   = date('Y-m-d');
        $quotation->reason_reject       = $request->reason;
        $quotation->save();

        $quotationDetail = QuotationDetail::where('quotation_order_id', $quotation->id)
                        ->get();
        //update lagi qty ke awal 
        foreach( $quotationDetail as $key => $rows ) {
            $poDetail = PurchaseRequestsDetail::where('id', $rows->request_detail_id)->first();
            // dd($poDetail);
            if( $poDetail != null ) {
                $poDetail->qty += $rows->qty;
                $poDetail->update();
            }
        }

        \Session::flash('status','PO repeat has been rejected');
    }

    /**
     * multiple approve po.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function repeatRejectedHead(Request $request)
    {
        $quotation = Quotation::find($request->id);
        $quotation->approval_status     = Quotation::Rejected;
        $quotation->approved_head       = \Auth::user()->user_id;
        $quotation->reason_reject       = $request->reason;
        $quotation->approved_date_head  = date('Y-m-d');
        $quotation->save();

        $quotationDetail = QuotationDetail::where('quotation_order_id', $quotation->id)
                        ->get();
        //update lagi qty ke awal 
        foreach( $quotationDetail as $key => $rows ) {
            $poDetail = PurchaseRequestsDetail::where('id', $rows->request_detail_id)->first();
            if( $poDetail != null ) {
                $poDetail->qty += $rows->qty;
                $poDetail->update();
            }
        }

        \Session::flash('status','PO repeat has been rejected');
    }

    /**
     * clone resource from quotation to table po
     *
     * @param  array $header
     * @param  array $detail
     * @return \Illuminate\Http\Response
     */
    private function _clone_purchase_orders($header, $detail, $poNumber)
    {
        if( $poNumber != 'ORDERFULLY' ) {
            $configEnv = \configEmailNotification();
            $poId = PurchaseOrder::create([
                'quotation_id' => $header->id,
                'notes'        => $header->notes,
                'po_date'      => \Carbon\Carbon::now(),
                'vendor_id'    => $header->vendor_id,
                'status'       => Quotation::QuotationRepeat,
                'payment_term' => $header->payment_term,
                'currency'     => $header->currency,
                'PO_NUMBER'    => $poNumber ?? 0,
                'doc_type'     => $header->doc_type,
                'total_price'  => $header->total_price,
                'created_by'   => $header->created_by,
                'updated_by'   => $header->updated_by,
                'ship_id'      => $header->ship_id
            ]);

            $po = $poId;

            foreach ($detail as $rows) {
                $sched = QuotationDelivery::where('quotation_detail_id', $rows->id)->first();
                $detail = PurchaseOrdersDetail::create([
                    'purchase_order_id'         => $poId->id,
                    'description'               => $rows->description ?? '-',
                    'qty'                       => $rows->qty,
                    'unit'                      => $rows->unit,
                    'notes'                     => $rows->notes ?? '-',
                    'price'                     => $rows->price ?? 0,
                    'material_id'               => $rows->material,
                    'assets_no'                 => $rows->assets_no,
                    'material_group'            => $rows->material_group,
                    'preq_item'                 => $rows->PREQ_ITEM,
                    'purchasing_document'       => $rows->purchasing_document ?? 0,
                    'PR_NO'                     => $rows->PR_NO,
                    'assets_no'                 => $rows->assets_no,
                    'acp_id'                    => $rows->acp_id ?? 0,
                    'short_text'                => $rows->short_text,
                    'text_id'                   => $rows->text_id,
                    'text_form'                 => $rows->text_form,
                    'text_line'                 => $rows->text_line,
                    'delivery_date_category'    => $rows->delivery_date_category,
                    'account_assignment'        => $rows->account_assignment,
                    'purchasing_group_code'     => $rows->purchasing_group_code,
                    'gl_acct_code'              => $rows->gl_acct_code,
                    'cost_center_code'          => $rows->cost_center_code,
                    'profit_center_code'        => $rows->profit_center_code,
                    'storage_location'          => $rows->storage_location,
                    'PO_ITEM'                   => $rows->PO_ITEM,
                    'request_no'                => $rows->request_no,
                    'original_price'            => $rows->orginal_price,
                    'currency'                  => $rows->currency,
                    'preq_name'                 => $rows->preq_name,
                    'delivery_date'             => $rows->delivery_date,
                    'item_category'             => $rows->item_category,
                    'request_no'                => $rows->request_no,
                    'plant_code'                => $rows->plant_code,
                    'tax_code'                  => $rows->tax_code,
                    'package_no'                => $rows->package_no,
                    'subpackage_no'             => $rows->subpackage_no,
                    'line_no'                   => $rows->line_no,
                    'SCHED_LINE'                => $sched->SCHED_LINE,
                    'request_detail_id'         => $rows->request_detail_id,
                    'is_free_item'              => $rows->is_free_item ?? 0
                ]);

                if( $rows->item_category == QuotationDetail::SERVICE ) {
                    $service = QuotationServiceChild::where('quotation_id', $header->id)->get();

                    foreach($service as $key => $value ) {
                        $poServiceChild = new \App\Models\PurchaseOrderServiceChild;
                        $poServiceChild->purchase_order_id          = $poId->id;
                        $poServiceChild->purchase_order_detail_id   = $detail->id;
                        $poServiceChild->preq_item                  = $value->preq_item;
                        $poServiceChild->po_item                    = $value->po_item;
                        $poServiceChild->package_no                 = $value->package_no;
                        $poServiceChild->subpackage_no              = $value->subpackage_no;
                        $poServiceChild->short_text                 = $value->short_text;

                        $poServiceChild->save();
                    }
                }

            }
            
            $quotDelivery = QuotationDelivery::where('quotation_id', $header->id)->get();

            foreach( $quotDelivery as $rec ) {
                $poDel = new \App\Models\PurchaseOrderDelivery;
                $poDel->purchase_order_id = $po->id;
                $poDel->purchase_order_detail_id = $detail->id;
                $poDel->sched_line = $rec->SCHED_LINE;
                $poDel->po_item = $rec->PO_ITEM;
                $poDel->delivery_date = $rec->DELIVERY_DATE;
                $poDel->preq_no = $rec->PREQ_NO;
                $poDel->preq_item = $rec->PREQ_ITEM;
                $poDel->qty = $rec->QUANTITY;
                $poDel->save();
            }

            $print = false;
            $pdf = PDF::loadview('print', \compact('po', 'print'))
                ->setPaper('A4', 'potrait')
                ->setOptions(['debugCss' => true, 'isPhpEnabled' => true])
                ->setWarnings(true);
            $pdf->save(public_path("storage/{$po->id}_print.pdf"));
            if (\App\Models\BaseModel::Development == $configEnv->type) {
                $email = $configEnv->value;
            } else {
                $email = $po->vendors['email'] ?? 'diditriawan13@gmail.com';
            }
            \Mail::to($email)->send(new SendMail($po));
            \Mail::to('farid.hidayat@enesis.com')->send(new SendMail($po));
            \Mail::to('diditriawan13@gmail.com')->send(new SendMail($po));
            $print = true;
        } else {
            $quotation = Quotation::find($header->id);
            $quotation->approval_status     = Quotation::ApprovalHead;
            $quotation->approved_head       = \Auth::user()->user_id;
            $quotation->approved_date_head  = date('Y-m-d');
            $quotation->save();
        }
    }

    private function _insert_details($details, $id)
    {
        $configEnv = \configEmailNotification();

        $i = 0;
        $lineNo = 1;
        $totalPrice = 0;
        $assProc    = "";
        foreach ($details as $detail) {
            $totalPrice += \removeComma($detail['price']);
            $schedLine  = sprintf('%05d', (1+$i));
            $poItem     =  ('000'.(10+($i*10)));

            if( $poItem > '00090' ) {
                $poItem = substr($poItem,1);
            }
            
            //khusus service 
            //insert anak2ny
            $child  = new QuotationServiceChild;
            $childs = new QuotationServiceChild;

            $service                = '';
            $packageParent          = '000000000';
            $subpackgparent         = '000000000';
            $childPackageParent     = '000000000';
            $noLine                 = '';
            $lineNumber             = '000000000';
            if( $detail['item_category'] == QuotationDetail::SERVICE ) {
                
                $lineNumber        .= $i + 1;
                $subpackgparent    .= (2+($i*2));
                if( $i % 2 == 0 ) {
                    //anak genap
                    $ke3 =  $i+1;
                    $packageParent                  .= ($i + $ke3);
                    $child->quotation_id            = $id;
                    $child->preq_item               = $detail['preq_item'];
                    $child->po_item                 = $poItem;
                    $child->package_no              = $packageParent;
                    $child->subpackage_no           = $subpackgparent;
                    $child->short_text              = $detail['short_text'];
                } else {
                    //anak ganjil
                    $packageParent                  .= ($i + 2);
                    $child->quotation_id            = $id;
                    $child->preq_item               = $detail['preq_item'];
                    $child->po_item                 = $poItem;
                    $child->package_no              = $packageParent;
                    $child->subpackage_no           = $subpackgparent;
                    $child->short_text              = $detail['short_text'];
                }
            }
            
            if( $detail['is_free_item'] == 1 ){
                $price_v2 = 0 ;
            }else {
                $price_v2 = $detail['price'] ;
            }

            //rumus 
            // qty order/per * price
            //$totalPrice = \removeComma($val['price'])/$val['qty'] * $val['qty_pr'];
            // $totalPrices = (\removeComma($detail['price']) * $detail['qty']);
            $totalPrices = (\removeComma($price_v2) * $detail['qty']);
            $getRfq= \App\Models\RfqDetail::where('rfq_number',$detail['rfq'] )->first();
            // dd($detail['price']/$getRfq->per_unit);
            // if( !empty($getRfq) ) {
            //     $totalPrices = (\removeComma($detail['price'])/$getRfq->per_unit) * $detail['qty'];
            // }

            $totalPrices = 0;

            $quotationDetail = new QuotationDetail;
            $quotationDetail->quotation_order_id        = $id;
            $quotationDetail->qty                       = $detail['qty'];
            $quotationDetail->unit                      = $detail['unit'];
            $quotationDetail->material                  = $detail['material_id'];
            $quotationDetail->description               = $detail['description'];
            $quotationDetail->notes                     = $detail['notes'];
            $quotationDetail->plant_code                = $detail['plant_code'];
            // $quotationDetail->price                     = \removeComma($detail['price']);
            $quotationDetail->price                     = \removeComma($price_v2);
            $quotationDetail->orginal_price             = \removeComma($detail['original_price']);
            $quotationDetail->is_assets                 = $detail['is_assets'];
            $quotationDetail->assets_no                 = $detail['assets_no'];
            $quotationDetail->short_text                = $detail['short_text'];
            $quotationDetail->text_id                   = $detail['text_id'];
            $quotationDetail->text_form                 = $detail['text_form'];
            $quotationDetail->text_line                 = $detail['text_line'];
            $quotationDetail->delivery_date_category    = $detail['delivery_date_category'];
            $quotationDetail->account_assignment        = $detail['account_assignment'];
            $quotationDetail->purchasing_group_code     = $detail['purchasing_group_code'];
            $quotationDetail->preq_name                 = $detail['preq_name'];
            $quotationDetail->gl_acct_code              = $detail['gl_acct_code'];
            $quotationDetail->cost_center_code          = $detail['cost_center_code'];
            $quotationDetail->profit_center_code        = $detail['profit_center_code'];
            $quotationDetail->storage_location          = $detail['storage_location'];
            $quotationDetail->material_group            = $detail['material_group'];
            $quotationDetail->PREQ_ITEM                 = $detail['preq_item'];
            $quotationDetail->PR_NO                     = $detail['PR_NO'];
            $quotationDetail->PO_ITEM                   = $poItem;
            $quotationDetail->total_price               = $totalPrices;
            $quotationDetail->purchasing_document       = $detail['rfq'];
            $quotationDetail->acp_id                    = $detail['acp_id'];
            // $quotationDetail->delivery_date             = $detail['delivery_date'];
            $quotationDetail->delivery_date             = $detail['delivery_date_new'] ?? $detail['delivery_date'];
            $quotationDetail->currency                  = $detail['original_currency'];
            $quotationDetail->request_no                = $detail['request_no'];
            $quotationDetail->item_category             = $detail['item_category'];
            $quotationDetail->tax_code                  = $detail['tax_code'] == 1 ? "V1" : "V0";
            $quotationDetail->package_no                = $packageParent;
            $quotationDetail->subpackage_no             = $subpackgparent;
            $quotationDetail->line_no                   = $lineNumber;
            $quotationDetail->request_detail_id         = $detail['request_detail_id'];
            $quotationDetail->rfq_number                = $detail['rfq'];
            $quotationDetail->is_free_item              = $detail['is_free_item'] ?? 0;
            $quotationDetail->save();

            if( $detail['item_category'] == QuotationDetail::SERVICE ) {
                $child->quotation_detail_id  = $quotationDetail->id;
                $child->save();

                // $packageParents              = $i +;
                $childs->quotation_detail_id = $quotationDetail->id;

                //anak genap
                $childs->quotation_id    = $id;
                $childs->preq_item       = $detail['preq_item'];
                $childs->po_item         = $poItem;
                $childs->package_no      = $subpackgparent;
                $childs->subpackage_no   = '000000000';
                $childs->short_text      = $detail['short_text'];
                $childs->save();

                $childs->quotation_id    = $id;
                $childs->preq_item       = $detail['preq_item'];
                $childs->po_item         = $poItem;
                $childs->package_no      = $subpackgparent;
                $childs->subpackage_no   = '000000000';
                $childs->short_text      = $detail['short_text'];
                $childs->save();
            }

            QuotationDelivery::create([
                'quotation_id'          => $id,
                'quotation_detail_id'   => $quotationDetail->id,
                'SCHED_LINE'            => $schedLine,
                'PO_ITEM'               => $poItem,
                'DELIVERY_DATE'         => $detail['delivery_date_new'] ?? $detail['delivery_date'] ,
                'PREQ_NO'               => $detail['PR_NO'],
                'PREQ_ITEM'             => $detail['preq_item'],
                'QUANTITY'              => $detail['qty']
            ]);

            $assProc = \App\Models\UserMap::getAssProc($detail['purchasing_group_code']);

            $i++;
        }
        
        if (\App\Models\BaseModel::Development == $configEnv->type) {
            $email = $configEnv->value;
            $name  = "Didi Ganteng";
        } else {
            $assProcs = \App\Models\User::where('user_id', $assProc->user_id)->first();
            // $email = 'yunan.yazid@enesis.com';
            $email = $assProcs->email;
            $name  = $assProcs->name;
        }

        $quotation = Quotation::find($id);
        $quotation->total_price     = $totalPrice;
        $quotation->approved_asspro = $assProc->user_id;
        $quotation->approved_head   = 'PROCUREMENT01';
        $quotation->save();

        \Mail::to($email)->send(new poApprovalAssproc($quotation,$name));

        $quotationDetail        = QuotationDetail::where('quotation_order_id', $id)->get();
        $quotationDeliveryDate  = QuotationDelivery::where('quotation_id', $id)->get();
        
        $sendSap = \sapHelp::sendPoTesRun($quotation, $quotationDetail,$quotationDeliveryDate);
        // dd($sendSap['is_error']);
        if( $sendSap['is_error'] ) {
            \Mail::to($email)->send(new poApprovalAssproc($quotation,$name));
            return $sendSap;
            // return redirect()->route('admin.quotation-repeat.index')->with('status', 'Repeat Order has been successfully ordered!'); 
        } else {
            // \DB::rollBack();
            return $sendSap;
        }
    }

    public function fileUpload($request)
    {
        $data = [];
        if ($request->hasfile('upload_file')) {
            foreach ($request->file('upload_file') as $file) {
                $name = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/files/uploads/', $name);
                $data[] = $name;
            }
        }

        return serialize($data);
    }

    public function getCurrency(Request $request)
    {
        $currency = \App\Models\Currency::get();

        $data = [];
        foreach( $currency as $rows ) {
            $data[$rows->currency] = $rows->currency;
        }

        return \Response::json($data);
    }

    public function getPaymentTerm(Request $request)
    {
        $paymentTerm = \App\Models\PaymentTerm::get();

        $data = [];
        foreach( $paymentTerm as $rows ) {
            $data[$rows->payment_terms] = $rows->own_explanation;
        }
        return \Response::json($data);
    }
}
