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
use App\Models\PurchaseRequestsDetail;
use App\Models\PurchaseRequestHistory;
use App\Models\PurchaseOrder;
use App\Models\MasterRfq;
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

    public function online ()
    {
        $quotation = Quotation::where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.quotation.online', compact('quotation'));
    }

    public function repeat ()
    {
        $quotation = Quotation::where('status', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.quotation.repeat', compact('quotation'));
    }

    public function saveOnline (Request $request)
    {
        if ($request->get('search-vendor') == '-- Select --')
            return redirect()->route('admin.purchase-request-online', [$request->get('id'), $request->get('quantities')])->with('status', 'No vendor chosen!');

        $vendors = $request->get('vendor_id');

        if (empty($vendors))
            return redirect()->route('admin.purchase-request-online', [$request->get('id'), $request->get('quantities')])->with('status', 'No vendors selected!');

        \DB::beginTransaction();

        try {
            $net_price = $request->get('net_price');
            if ($request->input('model') == 0)
                for ($i = 0; $i < count($net_price); $i++)
                    if (empty($net_price[$i]))
                        return redirect()->route('admin.purchase-request-online', [$request->get('id'), $request->get('quantities')])->with('status', 'Net price cannot be zero!');
                        
            $quotation = new Quotation;
            $quotation->po_no               = $request->get('PR_NO');
            $quotation->model               = $request->get('model');
            $quotation->leadtime_type       = $request->get('leadtime_type');
            $quotation->purchasing_leadtime = $request->get('purchasing_leadtime');
            $quotation->start_date          = $request->get('start_date');
            $quotation->expired_date        = $request->get('expired_date');
            $quotation->status              = 1;
            $quotation->save();
            
            $quotation_ids = [];
            foreach ($vendors as $key => $val) {
                $quotationDetail = new QuotationDetail;
                $quotationDetail->quotation_order_id = $quotation->id;
                $quotationDetail->vendor_id = $val;
                $quotationDetail->flag = 0;
                $quotationDetail->save();

                array_push($quotation_ids, $quotationDetail->id);
            }

            for ($i = 0; $i < count($net_price); $i++) {
                if ($net_price[$i]) {
                    $detail = QuotationDetail::find($quotation_ids[$i]);
                    $detail->price = $net_price[$i];
                    $detail->save();
                }
            }
                        
            // if( $price <= 25000000 ) {
            //     $tingkat = 'STAFF';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // } else if( $price > 25000000 && $price < 100000000) {
            //     $tingkat = 'CMO';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // } else if( $price > 100000000 && $price <= 250000000) {
            //     $tingkat = 'CFO';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // } else if( $price > 250000000) {
            //     $tingkat = 'COO';
            //     $this->saveApprovals($quotation->id,$tingkat,'BIDDING');
            // }

            \DB::commit();

            return redirect()->route('admin.quotation.online')->with('status', trans('cruds.purchase-order.alert_success_insert'));
        } catch (Exception $e) {
            \DB::rollBack();
    
            return redirect()->route('admin.quotation.online')->with('error', trans('cruds.purchase-order.alert_error_insert'));
        }
    }


    public function saveRepeat (Request $request)
    {
        $qty = 0;
        $price = 0;
        $details = [];
        for ($i = 0; $i < count($request->get('qty')); $i++) {
            $qy = str_replace('.', '', $request->get('qty')[$i]);
            $qty += $qy;

            // update material qty
            $material = PurchaseRequestsDetail::where('id', $request->id[$i])->first();

            // insert to pr history
            $data = [
                'request_no'                => $request->get('rn_no')[$i],
                'pr_id'                     => $request->get('pr_no')[$i],
                'rn_no'                     => $request->get('rn_no')[$i],
                'material_id'               => $request->get('material_id')[$i],
                'unit'                      => $request->get('unit')[$i],
                'vendor_id'                 => $request->get('vendor_id'),
                'plant_code'                => $request->get('plant_code')[$i],
                'price'                     => $request->get('price')[$i],
                'qty'                       => $request->get('qty')[$i],
                'qty_pr'                    => $material->qty,
                'is_assets'                 => $request->get('is_assets')[$i],
                'assets_no'                 => $request->get('assets_no')[$i],
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
                'PR_NO'                     => $request->get('PR_NO')[$i]
            ];

            array_push($details, $data);
            $this->savePRHistory($data);

            $material->qty -= $request->get('qty')[$i];
            $material->save();
        }

        \DB::beginTransaction();

        try {
            $quotation = new Quotation;
            $quotation->po_no           = $request->get('po_no');
            $quotation->notes           = $request->get('notes');
            $quotation->doc_type        = $request->get('doc_type');
            $quotation->upload_file     = $request->get('upload_files');
            $quotation->currency        = $request->get('currency');
            $quotation->payment_term    = $request->get('payment_term');
            $quotation->vendor_id       = $request->vendor_id;
            $quotation->status          = 0;

            $quotation->save();
            foreach ($details as $detail) {
                $quotationDetail = new QuotationDetail;
                $quotationDetail->quotation_order_id        = $quotation->id;
                $quotationDetail->qty                       = $detail['qty'];
                $quotationDetail->unit                      = $detail['unit'];
                $quotationDetail->material                  = $detail['material_id'];
                $quotationDetail->plant_code                = $detail['plant_code'];
                $quotationDetail->vendor_price              = $detail['price'];
                $quotationDetail->vendor_id                 = $detail['vendor_id'];
                $quotationDetail->is_assets                 = $detail['is_assets'];
                $quotationDetail->assets_no                 = $detail['assets_no'];
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
                $quotationDetail->preq_item                 = $detail['preq_item'];
                $quotationDetail->PR_NO                     = $detail['PR_NO'];
                $quotationDetail->vendor_id                 = $request->vendor_id;

                $quotationDetail->save();
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('admin.quotation.index')->with('status', 'Repeat Order has been successfully ordered!');
    }

    public function saveDirect (Request $request)
    {
        $qty = 0;
        $price = 0;
        $details = [];

        for ($i = 0; $i < count($request->get('qty')); $i++) {
            $qy = str_replace('.', '', $request->get('qty')[$i]);
            $qty += $qy;
            // update material qty
            $material = PurchaseRequestsDetail::where('id', $request->id[$i])->first();

            // insert to pr history
            $data = [
                'request_no'        => $request->get('rn_no')[$i],
                'pr_id'             => $request->get('pr_no')[$i],
                'material_id'       => $request->get('material_id')[$i],
                'rn_no'             => $request->get('rn_no')[$i],
                'unit'              => $request->get('unit')[$i],
                'vendor_id'         => $request->get('vendor_id'),
                'plant_code'        => $request->get('plant_code')[$i],
                'price'             => $request->get('price')[$i],
                'qty'               => $request->get('qty')[$i],
                'qty_pr'            => $material->qty,
            ];

            array_push($details, $data);

            $this->savePRHistory($data);

            $material->qty -= $request->get('qty')[$i];
            $material->save();
        }

        \DB::beginTransaction();

        try {
            $quotation = new Quotation;
            $quotation->po_no = $request->get('po_no');
            $quotation->notes = $request->get('notes');
            $quotation->doc_type = $request->get('doc_type');
            $quotation->upload_file = $request->get('upload_files');
            $quotation->status = 2;
            $quotation->save();

            $price = 0;
            foreach ($details as $detail) {
                $price += $detail['price'];

                $quotationDetail = new QuotationDetail;
                $quotationDetail->quotation_order_id = $quotation->id;
                $quotationDetail->qty = $detail['qty'];
                $quotationDetail->unit = $detail['unit'];
                $quotationDetail->material = $detail['material_id'];
                $quotationDetail->plant_code = $detail['plant_code'];
                $quotationDetail->vendor_price = $detail['price'];
                $quotationDetail->vendor_id = $detail['vendor_id'];
                $quotationDetail->save();
            }

            if( $price <= 25000000 ) {
                $tingkat = 'STAFF';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            } else if( $price > 25000000 && $price < 100000000) {
                $tingkat = 'CMO';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            } else if( $price > 100000000 && $price <= 250000000) {
                $tingkat = 'CFO';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            } else if( $price > 250000000) {
                $tingkat = 'COO';
                $this->saveApprovals($quotation->id,$tingkat,'DIRECT');
            }
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        // send email
        $vendor = Vendor::where('code', $request->get('vendor'))->first();
        $files = explode(', ', $request->get('upload_files'));
        $attachments = [];
        $data = [
            'vendor' => $vendor,
            'request_no' => $request->get('po_no'),
            'attachments' => $attachments,
            'subject' => 'PO Repeat ' . $request->get('po_no')
        ];

        $mail_sent = '';
        if (!empty($vendor->email))
            \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));
        else
            $mail_sent = '<br>But Email cannot be send, because vendor doesnot have an email address';

        return redirect()->route('admin.quotation.direct')->with('status', 'Direct Order has been successfully ordered!' . $mail_sent);
    }

    public function showOnline (Request $request, $id)
    {
        $model = Quotation::find($id);

        return view('admin.quotation.show-online', compact('model'));
    }

    public function showRepeat (Request $request, $id)
    {
        $model = Quotation::find($id);

        return view('admin.quotation.show-repeat', compact('model'));
    }

    public function approveRepeat (Request $request)
    {
        if (empty($request->get('id')))
            return redirect()->route('admin.quotation-show-repeat', $request->get('quotation_id'))->with('error', 'Please check your material!');

        \DB::beginTransaction();

        try {
            foreach ($request->get('id') as $id) {
                $quotationDetail = QuotationDetail::find($id);

                $model = $quotationDetail->quotation;
                $model->approval_status = 1;
                $model->save();
            }

            // send email
            $vendor = Vendor::where('code', $request->get('vendor_code'))->first();
            $files = explode(', ', $request->get('upload_files'));
            $attachments = [];
            $data = [
                'vendor' => $vendor,
                'request_no' => $request->get('po_no'),
                'attachments' => $attachments,
                'subject' => 'Repeat Order ' . $request->get('po_no')
            ];

            $mail_sent = '';
            if (!empty($vendor->email))
                // \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));
                \Mail::to('diditriawan13@gmail.com')->send(new PurchaseOrderMail($data));
            else
                \Mail::to('diditriawan13@gmail.com')->send(new PurchaseOrderMail($data));
                $mail_sent = '<br>But Email cannot be send, because vendor doesnot have an email address';

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('admin.quotation.repeat')->with('status', 'Repeat Order has been approval!' . $mail_sent);
    }

    public function winner (Request $request)
    {
        $quotation = [];
        
        foreach ($request->get('id') as $id)
            $quotation[$id] = QuotationDetail::find($id);

        return view('admin.quotation.winner', compact('quotation'));
    }

    private function saveApprovals($quotation_id, $tingkat,$type)
    {

        if( $tingkat == 'STAFF' ) {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
        } else if ($tingkat == 'CMO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
        } else if ($tingkat == 'CMO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            
            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 4,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
        } else if ($tingkat == 'COO') {
            QuotationApproval::create([
                'nik'                   => 190256,
                'approval_position'     => 1,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 1,
                'acp_type'              => $type
            ]);

            QuotationApproval::create([
                'nik'                   => 190089,
                'approval_position'     => 2,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            
            QuotationApproval::create([
                'nik'                   => 180095,
                'approval_position'     => 3,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 4,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
            ]);
            QuotationApproval::create([
                'nik'                   => 180178,
                'approval_position'     => 5,
                'status'                => QuotationApproval::waitingApproval,
                'quotation_id'          => $quotation_id,
                'flag'                  => 0,
                'acp_type'              => $type
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
        $quotation = Quotation::where('status', 1)
            ->orderBy('quotation.created_at', 'desc')
            ->get();

        return view('admin.quotation.list-winner', compact('quotation'));
    }

    public function showWinner ($id)
    {
        $quotation = QuotationDetail::where('quotation_order_id', $id)->get();

        return view('admin.quotation.show-winner', compact('quotation', 'id'));
    }

    public function approve (Request $request, $id)
    {
        $model = QuotationDetail::find($id);
        $vendor = Vendor::find($model->vendor_id);

        $po = new PurchaseOrder;
        $po->request_id = $id;
        $po->bidding = 0;
        $po->po_date = date('Y-m-d');
        $po->vendor_id = $model->vendor_id;
        $po->status = 0;
        $po->po_no = $model->po_no;
        $po->save();

        $subject = '';
        if ($model->status == 0) {
            $subject = 'PO Repeat Order ' . $model->po_no;
        } else if ($model->status == 2) {
            $subject = 'Penunjukkan Langsung ' . $model->po_no;
        }

        $data = [
            'vendor' => $model->vendor,
            'request_no' => $model->po_no,
            'subject' => $subject
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
        $detail = QuotationDetail::where('quotation_order_id', $id)->get();

        return view('admin.quotation.show', compact('quotation', 'detail'));
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

    protected function savePRHistory ($data)
    {
        // insert to purchase_request_history
        $prHistory = new PurchaseRequestHistory;
        $prHistory->pr_id       = $data['pr_id'];
        $prHistory->request_no  = $data['rn_no'];
        $prHistory->material_id = $data['material_id'];
        $prHistory->vendor_id   = $data['vendor_id'];
        $prHistory->qty         = $data['qty_pr'];
        $prHistory->qty_po          = $data['qty'] ?? 0;
        $prHistory->qty_outstanding = $data['qty_pr'] - $data['qty'];
        $prHistory->save();
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
}
