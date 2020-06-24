<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, Artisan, Exception;
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

class QuotationDirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.quotation.direct.index');
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
            $quotation->po_no       = $request->get('po_no');
            $quotation->notes       = $request->get('notes');
            $quotation->doc_type    = $request->get('doc_type');
            $quotation->upload_file = $request->get('upload_files');
            $quotation->status       = 2;
            $quotation->currency     = $request->get('currency');
            $quotation->payment_term = $request->get('payment_term');
            $quotation->vendor_id    = $request->vendor_id;
            $quotation->acp_id       = $request->acp_id;
            $quotation->save();

            $price = 0;
            foreach ($details as $detail) {
                $price += $detail['price'];

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

        return redirect()->route('admin.quotation-direct')->with('status', 'Direct Order has been successfully ordered!' . $mail_sent);
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
        } else if ($tingkat == 'CFO') {
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
}
