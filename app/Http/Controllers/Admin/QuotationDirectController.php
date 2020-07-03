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
use App\Models\Vendor\QuotationDelivery;
use App\Models\PurchaseRequestsDetail;
use App\Models\PurchaseRequestHistory;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
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
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);
        $quotation = QuotationDetail::join('quotation','quotation.id','=','quotation_details.quotation_order_id')
                    ->join('vendors','vendors.code','=','quotation.vendor_id')
                    ->where('quotation.status',2)
                    ->whereIn('quotation_details.purchasing_group_code', $userMapping)
                    ->select(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.approval_status',
                        'vendors.name'
                    )
                    ->groupBy('quotation.id','vendors.name')
                    ->orderBy('id', 'desc')
                    ->get();

        return view('admin.quotation.direct.index', compact('quotation'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalListAss()
    {
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();

        $userMapping = explode(',', $userMapping->purchasing_group_code);
        $quotation = QuotationDetail::join('quotation','quotation.id','=','quotation_details.quotation_order_id')
                    ->join('vendors','vendors.code','=','quotation.vendor_id')
                    ->where('quotation.status',Quotation::QuotationDirect)
                    ->where('quotation.approval_status',Quotation::Waiting)
                    ->whereIn('quotation_details.purchasing_group_code', $userMapping)
                    ->select(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.approval_status',
                        'vendors.name'
                    )
                    ->groupBy('quotation.id','vendors.name')
                    ->orderBy('id', 'desc')
                    ->get();

        return view('admin.quotation.direct.index-approval', compact('quotation'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalListHead()
    {
        $quotation = QuotationDetail::join('quotation','quotation.id','=','quotation_details.quotation_order_id')
                    ->join('vendors','vendors.code','=','quotation.vendor_id')
                    ->where('quotation.status',Quotation::QuotationDirect)
                    ->where('quotation.approval_status',Quotation::ApprovalAss)
                    ->select(
                        'quotation.id',
                        'quotation.po_no',
                        'quotation.approval_status',
                        'vendors.name'
                    )
                    ->groupBy('quotation.id','vendors.name')
                    ->orderBy('id', 'desc')
                    ->get();

        return view('admin.quotation.direct.index-approval-head', compact('quotation'));
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
            $requestNo = '';
            if( $request->get('rn_no')[$i] == 'DIRECT') {
                $requestNo = $request->get('pr_no')[$i];
            } else {
                $requestNo = $request->get('rn_no')[$i];
            }

            $data = [
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
                'qty'                       => \removeTitik($request->get('qty')[$i]),
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
                'tax_code'                  => $request->get('tax_code')[$i],
                'vendor_id'                 => $request->vendor_id,
                'request_no'                => $requestNo,
                'acp_id'                    => $request->get('acp_id')[$i],
                'item_category'             => $request->get('category')[$i],
                'notes'                     => $request->get('notes_detail')[$i],
            ];

            array_push($details, $data);

            PurchaseRequestHistory::insertHistory($data);
            $material->qty      -= \removeTitik($request->get('qty')[$i]);
            $material->qty_order = \removeTitik($request->get('qty')[$i]);
            $material->save();
        }

        \DB::beginTransaction();

        try {
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
            $quotation->status          = Quotation::QuotationDirect;
            $quotation->currency        = $request->get('currency');
            $quotation->payment_term    = $request->get('payment_term') ?? $payVendor;
            $quotation->vendor_id       = $request->vendor_id;
            $quotation->acp_id          = $request->acp_id[0];
            $quotation->approval_status = Quotation::Waiting;
            $quotation->save();

            $this->_insert_details($details, $quotation->id);
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return redirect()->route('admin.quotation-direct.index')->with('status', 'Direct Order has been successfully ordered!');
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
     * multiple approve po.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function directApproveAss($ids)
    {
        try {
            $ids = base64_decode($ids);
            $ids = explode(',', $ids);

            foreach( $ids as $id ) {
                $quotation = Quotation::find($id);
                $quotation->approval_status = Quotation::ApprovalAss;
                $quotation->approved_asspro = \Auth::user()->user_id;
                $quotation->save();
            }

            return redirect()->route('admin.quotation-direct-approval-ass')->with('status', 'Direct Order has been approved!');
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
    public function directApproveHead($ids)
    {
        try {
            $ids = base64_decode($ids);
            $ids = explode(',', $ids);

            foreach( $ids as $id ) {
                $quotation = Quotation::find($id);
                $quotation->approval_status = Quotation::ApprovalHead;
                $quotation->approved_head   = \Auth::user()->user_id;
                $quotation->save();

                $quotationDetail = QuotationDetail::where('quotation_order_id', $id)->get();
                $quotationDeliveryDate = QuotationDelivery::where('quotation_id', $id)->get();

                $sendSap = \sapHelp::sendPoToSap($quotation, $quotationDetail,$quotationDeliveryDate);
                // $sendSap = true;

                if( $sendSap ) {
                    $this->_clone_purchase_orders($quotation, $quotationDetail,$sendSap);
                }

            }
            return redirect()->route('admin.quotation-direct-approval-head')->with('status', 'Direct Order has been approved!');
        } catch (\Throwable $th) {
            throw $th;
        }
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
        $poId = PurchaseOrder::create([
                'quotation_id' => $header->id,
                'notes'        => $header->notes,
                'po_date'      => \Carbon\Carbon::now(),
                'vendor_id'    => $header->vendor_id,
                'status'       => 1,
                'payment_term' => $header->payment_term,
                'currency'     => $header->currency,
                'PO_NUMBER'    => $poNumber ?? 0,
                'doc_type'     => $header->doc_type
            ]);

            $service        = '';
            $packageParent  = '000000000';
            $subpackgparent = '000000000';
            $noLine         = '';
            foreach ($detail as $rows) {
                $deliveryDate = QuotationDelivery::where('quotation_detail_id',$rows->id)->first()->DELIVERY_DATE;
                if( $detail['item_category'] == PurchaseOrdersDetail::SERVICE ) {
                    //check position parent and child
                    if( $i == 0 ) {
                        $noLine = $lineNo;
                    } else {
                        if( $i == 1 ) {
                            $noLine = $lineNo - 1;
                        } else {
                            $noLine = $lineNo - $i;
                        }
                    }
                }
                PurchaseOrdersDetail::create([
                    'purchase_order_id'         => $poId->id,
                    'description'               => $rows->description ?? '-',
                    'qty'                       => $rows->qty,
                    'unit'                      => $rows->unit,
                    'notes'                     => $rows->notes ?? '-',
                    'price'                     => $rows->price ?? 0,
                    'material_id'               => $rows->material,
                    'assets_no'                 => $rows->assets_no,
                    'material_group'            => $rows->material_group,
                    'preq_item'                 => $rows->preq_item,
                    'purchasing_document'       => $rows->purchasing_document ?? 0,
                    'PR_NO'                     => $rows->PR_NO,
                    'assets_no'                 => $rows->assets_no,
                    'acp_id'                    => $rows->acp_id,
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
                    'request_no'                => $rows->request_no,
                    'original_price'            => $rows->original_price,
                    'currency'                  => $rows->currency,
                    'preq_name'                 => $rows->preq_name,
                    'delivery_date'             => $deliveryDate,
                    'item_category'             => $rows->item_category,
                    'request_no'                => $rows->request_no,
                    'plant_code'                => $rows->plant_code,
                    'tax_code'                  => $rows->tax_code == 1 ? 'V1' : 'V0',
                    'package_no'                => $packageParent,
                    'subpackage_no'             => $subpackgparent,
                    'line_no'                   => '000000000'.$noLine,
                ]);
            }
    }

    private function _insert_details($details, $id)
    {
        $i = 0;
        $lineNo = 1;
        foreach ($details as $detail) {
            $schedLine  = sprintf('%05d', (10+$i));
            $indexes    = $i+1;
            $poItem     = sprintf('%05d', (10*$indexes));;
            
            $service        = '';
            $packageParent  = '000000000';
            $subpackgparent = '000000000';
            $noLine         = '';
            if( $detail['item_category'] == QuotationDetail::SERVICE ) {
                //check position parent and child
                if( $i == 0 ) {
                    $noLine = $lineNo;
                } else {
                    if( $i == 1 ) {
                        $noLine = $lineNo - 1;
                    } else {
                        $noLine = $lineNo - $i;
                    }
                }
            }

            $quotationDetail = new QuotationDetail;
            $quotationDetail->quotation_order_id        = $id;
            $quotationDetail->qty                       = $detail['qty'];
            $quotationDetail->unit                      = $detail['unit'];
            $quotationDetail->material                  = $detail['material_id'];
            $quotationDetail->description               = $detail['description'];
            $quotationDetail->notes                     = $detail['notes'];
            $quotationDetail->plant_code                = $detail['plant_code'];
            $quotationDetail->price                     = $detail['price'];
            $quotationDetail->orginal_price             = $detail['original_price'];
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
            $quotationDetail->purchasing_document       = $detail['rfq'];
            $quotationDetail->acp_id                    = $detail['acp_id'];
            $quotationDetail->delivery_date             = $detail['delivery_date'];
            $quotationDetail->currency                  = $detail['original_currency'];
            $quotationDetail->request_no                = $detail['request_no'];
            $quotationDetail->item_category             = $detail['item_category'];
            $quotationDetail->tax_code                  = $detail['tax_code'] == 1 ? 'V1' : 'V0';
            $quotationDetail->package_no                = $packageParent;
            $quotationDetail->subpackage_no             = $subpackgparent;
            $quotationDetail->line_no                   = '000000000'.$noLine;

            $quotationDetail->save();

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

            $i++;
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
}
