<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Gate;
use App\Mail\SendMail;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Mail\PurchaseOrderMail;
use App\Models\Vendor\Quotation;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderInvoice;
use App\Models\PurchaseOrdersDetail;
use Illuminate\Support\Facades\Mail;
use App\Models\PurchaseRequestsDetail;
use App\Models\Vendor\QuotationDetail;
use App\Models\PurchaseOrderChangeHistory;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PurchaseOrderChangeHistoryDetail;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('purchase_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $po = PurchaseOrdersDetail::join('purchase_orders', 'purchase_orders.id', '=', 'purchase_orders_details.purchase_order_id')
                ->leftJoin('master_acps', 'master_acps.id', '=', 'purchase_orders_details.acp_id')
                ->leftJoin('vendors', 'vendors.code', '=', 'purchase_orders.vendor_id')
                ->where('purchase_orders.status_approval', PurchaseOrder::Approved)
                ->select(
                    'purchase_orders_details.purchasing_document',
                    'purchase_orders_details.PO_ITEM',
                    'purchase_orders_details.material_id',
                    'purchase_orders_details.short_text',
                    'purchase_orders_details.storage_location',
                    'purchase_orders_details.qty',
                    'purchase_orders_details.qty_gr',
                    'purchase_orders_details.qty_billing',
                    'purchase_orders_details.unit',
                    'purchase_orders_details.currency as original_currency',
                    'purchase_orders_details.original_price',
                    'purchase_orders.currency',
                    'purchase_orders_details.price',
                    'purchase_orders_details.tax_code',
                    'purchase_orders_details.id as detail_id',
                    'purchase_orders_details.request_no',
                    'purchase_orders_details.plant_code',
                    'purchase_orders_details.purchasing_group_code',
                    'purchase_orders.po_date',
                    'purchase_orders.PO_NUMBER',
                    'purchase_orders.id',
                    'purchase_orders.vendor_id',
                    'master_acps.acp_no',
                    'vendors.name as vendor'
                )
                ->orderBy('purchase_orders_details.created_at', 'desc')->get();

        return view('admin.purchase-order.index', compact('po'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalPoChange()
    {
        abort_if(Gate::denies('purchase_order_approval_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $po = PurchaseOrder::leftJoin('vendors', 'vendors.code', '=', 'purchase_orders.vendor_id')
                ->where('purchase_orders.approved_asspro', \Auth::user()->nik)
                ->where('status_approval', PurchaseOrder::Rejected)
                ->where('is_approve_head', PurchaseOrder::ApproveAss) 
                ->select(
                    'purchase_orders.po_date',
                    'purchase_orders.id',
                    'purchase_orders.created_at',
                    'purchase_orders.PO_NUMBER',
                    'purchase_orders.notes',
                    'vendors.name as vendor',
                )
                ->orderBy('purchase_orders.created_at', 'desc')->get();

        return view('admin.purchase-order.approval-po-change', compact('po'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalPoChangeHead()
    {
        abort_if(Gate::denies('purchase_order_approval_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $po = PurchaseOrder::leftJoin('vendors', 'vendors.code', '=', 'purchase_orders.vendor_id')
            // ->where('purchase_orders.approved_asspro', \Auth::user()->nik)
            ->where('status_approval', PurchaseOrder::Rejected)
            ->where('is_approve_head', PurchaseOrder::ApproveHead)
            ->select(
                'purchase_orders.po_date',
                'purchase_orders.id',
                'purchase_orders.created_at',
                'purchase_orders.PO_NUMBER',
                'purchase_orders.notes',
                'vendors.name as vendor',
            )
            ->orderBy('purchase_orders.created_at', 'desc')->get();

        return view('admin.purchase-order.approval-po-change-head', compact('po'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->get('vendor_id'))) {
            return redirect()->route('admin.purchase-order-create-po', $request->get('request_id'))->with('status', 'No vendor chosen!');
        }

        if (0 == $request->get('bidding')) { // po repeat
            // create Quotation
            if (empty($request->get('qty')[0])) {
                return redirect()->route('admin.purchase-order-create-po', $request->get('request_id'))->with('status', 'Quantity cannot be zero!');
            }

            $quotation = new Quotation();
            $quotation->po_no = $request->get('request_no');
            $quotation->request_id = $request->get('request_id');
            $qty = str_replace('.', '', $request->get('qty')[0]);
            $quotation->qty = $qty;
            $quotation->status = 0;
            $quotation->vendor_id = $request->get('vendor_id')[0];
            $quotation->save();

            // send email
            $vendor = Vendor::find($request->get('vendor_id')[0]);
            $data = [
                'vendor' => $request->get('vendor_id')[0],
                'request_no' => $request->get('request_no'),
                'subject' => 'PO Repeat '.$request->get('request_no'),
            ];

            \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

            return redirect()->route('admin.quotation.index')->with('status', 'PO Repeat!');
        } elseif (2 == $request->get('bidding')) {
            // penunjukan langsung
            $filename = '';

            if ($request->file('upload_file')) {
                $path = 'quotation/';
                $file = $request->file('upload_file');

                $filename = $file->getClientOriginalName();

                $file->move($path, $filename);

                $real_filename = public_path($path.$filename);
            }

            $quotation = new Quotation();
            $quotation->po_no = $request->get('request_no');
            $quotation->notes = $request->get('notes');
            $quotation->request_id = $request->get('request_id');
            $quotation->upload_file = $filename;
            $quotation->status = 2;
            $quotation->vendor_id = $request->get('vendor_id')[0];
            $quotation->save();

            $vendor = Vendor::find($request->get('vendor_id')[0]);
            $data = [
                'vendor' => $request->get('vendor_id')[0],
                'request_no' => $request->get('request_no'),
                'subject' => 'Penunjukkan langsung '.$request->get('request_no'),
            ];

            \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

            return redirect()->route('admin.quotation.index')->with('status', 'Penunjukkan Langsung!');
        }
        \DB::beginTransaction();

        if (0 == $request->get('online')) {
            // send email to each vendor
            $vendors = $request->get('vendor_id');

            foreach ($vendors as $row) {
                $row = Vendor::findOrFail($row);
                $data = [
                    'vendor' => $row,
                    'request_no' => $request->get('request_no'),
                    'subject' => 'Bidding PR no '.$request->get('request_no'),
                ];

                // send email
                \Mail::to($row->email)->send(new PurchaseOrderMail($data));
            }

            return redirect()->route('admin.purchase-order.index')->with('success', 'All vendors has been sent');
        }
        try {
            $vendors = $request->get('vendor_id');

            if (empty($vendors)) {
                return redirect()->route('admin.purchase-order.index')->with('error', 'Vendor has been required');
            }

            $quotation = new Quotation();
            $quotation->request_id = $request->get('request_id');
            $quotation->po_no = $request->get('request_no');
            $quotation->leadtime_type = $request->get('leadtime_type');
            $quotation->purchasing_leadtime = $request->get('purchasing_leadtime');
            $quotation->target_price = str_replace('.', '', $request->get('target_price'));
            $quotation->expired_date = $request->get('expired_date');
            $quotation->save();

            foreach ($vendors as $row) {
                $quotationDetail = new QuotationDetail();
                $quotationDetail->quotation_order_id = $quotation->id;
                $quotationDetail->vendor_id = $row;
                $quotationDetail->flag = 0;
                $quotationDetail->save();
            }

            $purchaseOrder = new PurchaseOrder();

            if (0 == $request->get('bidding')) {
                $purchaseOrder->bidding = 0;
            } else {
                $purchaseOrder->bidding = 1;
            }

            $purchaseOrder->po_no = $request->get('request_no');
            $purchaseOrder->po_date = date('Y-m-d');
            $purchaseOrder->request_id = $request->get('request_id');
            $purchaseOrder->status = 0;
            $purchaseOrder->save();

            // Alvin:: PO Invoice
            $purchase_order_invoice = [
                'purchase_order_id' => $request->get('purchase_order_id'),
                'request_id' => $request->get('request_id'),
                'payment_terms' => $request->get('payment_terms'),
                'payment_in_days_1' => $request->get('payment_in_days_1'),
                'payment_in_percent_1' => $request->get('payment_in_percent_1'),
                'payment_in_days_2' => $request->get('payment_in_days_2'),
                'payment_in_percent_2' => $request->get('payment_in_percent_2'),
                'payment_in_days_3' => $request->get('payment_in_days_3'),
                'payment_in_percent_3' => $request->get('payment_in_percent_3'),
                'currency' => $request->get('currency'),
                'exchange_rate' => $request->get('exchange_rate'),
                'sales_person' => $request->get('sales_person'),
                'phone' => $request->get('phone'),
                'language' => $request->get('language'),
                'your_reference' => $request->get('your_reference'),
                'our_reference' => $request->get('our_reference'),
            ];
            $purchase_order_invoice_id = $request->get('purchase_order_invoice_id');
            if ($purchase_order_invoice) {
                PurchaseOrderInvoice::where('id', $purchase_order_invoice_id)->update($purchase_order_invoice);
            } else {
                PurchaseOrderInvoice::save($purchase_order_invoice);
            }
            // END

            \DB::commit();

            return redirect()->route('admin.quotation.index')->with('status', trans('cruds.purchase-order.alert_success_insert'));
        } catch (Exception $e) {
            \DB::rollBack();

            return redirect()->route('admin.quotation.index')->with('error', trans('cruds.purchase-order.alert_error_insert'));
        }
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);

        return view('admin.purchase-order.show', compact('purchaseOrder'));
    }

    public function showApprovalAss($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        $history       = PurchaseOrderChangeHistory::where('po_id', $id)->first();

        return view('admin.purchase-order.show-change-ass', compact('purchaseOrder'));
    }

    public function showApprovalHead($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);

        return view('admin.purchase-order.show-change-head', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('purchase_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $currency = \App\Models\Currency::all();
        $top = \App\Models\PaymentTerm::all();
        $purchaseOrderDetail = PurchaseOrdersDetail::where('purchase_order_id', $id)->orderBy('PO_ITEM','asc')->get();

        return view('admin.purchase-order.edit', compact('purchaseOrder', 'currency', 'top', 'purchaseOrderDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        $poChangeHeader = new PurchaseOrderChangeHistory();
        $poChangeHeader->po_id          = $purchaseOrder->id;
        $poChangeHeader->vendor_old     = $purchaseOrder->vendor_id;
        $poChangeHeader->vendor_change  = $request->get('payment_term') ?? '';
        $poChangeHeader->notes_old      = $purchaseOrder->notes;
        $poChangeHeader->notes_change   = $request->get('notes');
        $poChangeHeader->save();

        $service        = '';
        $packageParent  = '000000000';
        $subpackgparent = '000000000';
        $noLine         = '';
        $sched          = '';
        $totalPrice     = 0;
        foreach ($request->idDetail as $key => $rows) {
            $totalPrice += $request->price[$key];
            $poDetail    = PurchaseOrdersDetail::find($rows);

            if ($poDetail->qty != $request->qty[$key]) {
                $prDetail               = PurchaseRequestsDetail::find($poDetail->request_detail_id);
                $prDetail->qty         += $poDetail->qty;
                $prDetail->qty_order    = 0;
                $prDetail->update();

                $prDetail->qty      -= $request->qty[$key];
                $prDetail->qty_order = $request->qty[$key];
                $prDetail->save();
            }

            //init variable
            $taxCode                                = $request->tax_code[$key] ?? "";
            $deliveryDate                           = $request->delivery_date[$key] ?? $poDetail->delivery_date;
            $deliveryComplete                       = $request->delivery_complete[$key] ?? "";
            $price                                  = $request->price[$key] ?? "";
            $qty                                    = $request->qty[$key] ?? "";

            //save to log history
            $poChangeDetail                         = new PurchaseOrderChangeHistoryDetail();
            $poChangeDetail->qty_old                = $poDetail->qty;
            $poChangeDetail->qty_change             = $qty;
            $poChangeDetail->po_detail_id           = $poDetail->id;
            $poChangeDetail->po_history_id          = $poChangeHeader->id;
            $poChangeDetail->price_old              = $poDetail->price;
            $poChangeDetail->delivery_date_old      = $poDetail->delivery_date;
            $poChangeDetail->delivery_date_change   = $request->delivery_date[$key] ?? $poDetail->delivery_date;
            $poChangeDetail->price_change           = $price;

            $poChangeDetail->save();

            // update po detail
            $poDetail->qty_old              = $poDetail->qty;
            $poDetail->delivery_date_old    = $poDetail->delivery_date;//yg old2 di update 
            $poDetail->qty                  = $qty;
            $poDetail->price                = $price;// ini harusanya yg baru 
            $poDetail->delivery_date        = $request->delivery_date[$key] ?? $poDetail->delivery_date;
            $poDetail->delivery_complete    = $deliveryComplete;
            $poDetail->tax_code             = 1 == $taxCode ? "V1" : "V0";

            $poDetail->update();

            \App\Models\PurchaseOrderDelivery::where('purchase_order_id', $id)
                ->where('po_item', $poDetail->PO_ITEM)
                ->update([
                    'delivery_date' => $request->delivery_date[$key] ?? $poDetail->delivery_date,
                    'qty'           => $qty,
                ]);
        }

        if ( $purchaseOrder->total_price != $totalPrice ) {
            $purchaseOrder->total_price     = $totalPrice;
            $purchaseOrder->status_approval = PurchaseOrder::Rejected;
            $purchaseOrder->is_approve_head = 1;//balik ke assproc lagi
            $purchaseOrder->approved_asspro = \App\Models\Vendor\Quotation::getQuotationById($purchaseOrder->quotation_id)->approved_asspro;
            $purchaseOrder->approved_head   = 'PROCUREMENT01';
            $purchaseOrder->save();

            return redirect()->route('admin.purchase-order.index')->with('status', 'Purchase order has been updated & waiting approval');
        } else {
            $poChange = \sapHelp::sendPOchangeToSap($purchaseOrder->PO_NUMBER);
            if ($poChange) {
                $purchaseOrder->status_approval = PurchaseOrder::Approved;
                $purchaseOrder->save();
                return redirect()->route('admin.purchase-order.index')->with('status', 'Purchase order has been updated');
            } else {
                \Session::flash('error', 'Internal server error');
            }
        }

        return redirect()->route('admin.purchase-order.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalChangeAss(Request $request)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($request->id);

        if (1 == $request->is_approve) {
            $purchaseOrder->is_approve_head = PurchaseOrder::ApproveHead;
            $purchaseOrder->save();

            \Session::flash('status', 'Po change Has been approved');

            return \redirect()->route('admin.purchase-order-change-ass');
        }
        $purchaseOrder->is_approve_head = PurchaseOrder::ApproveAss;
        $purchaseOrder->reject_reason = $request->reason;
        $purchaseOrder->status_approval = PurchaseOrder::Rejected;
        $purchaseOrder->save();
        \Session::flash('status', 'Po change Has been rejected');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function approvalChangeHead(Request $request)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($request->id);

        if (1 == $request->is_approve) {
            $purchaseOrder->is_approve_head = PurchaseOrder::ApproveHead;
            $purchaseOrder->status_approval = PurchaseOrder::Approved;
            $purchaseOrder->save();

            $poChange = \sapHelp::sendPOchangeToSap($purchaseOrder->PO_NUMBER);

            \Session::flash('status', 'Po change Has been approved');

            return \redirect()->route('admin.purchase-order-change-head');
        }
        $purchaseOrder->is_approve_head = PurchaseOrder::ApproveHead;
        $purchaseOrder->reject_reason = $request->reason;
        $purchaseOrder->status_approval = PurchaseOrder::Rejected;
        $purchaseOrder->save();
        \Session::flash('status', 'Po change Has been rejected');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = PurchaseOrder::where('id', $id)->delete();

        // check data deleted or not
        if (1 == $delete) {
            $success = true;
            $message = 'Profit Center deleted successfully';
        } else {
            $success = true;
            $message = 'Profit Center not found';
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyItem(Request $request)
    {
        // abort_if(Gate::denies('purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (isset($request->id)) {
            $checkGr = \App\Models\PurchaseOrdersDetail::find($request->id);

            if ($checkGr->is_gr == 1) {
                $success = false;
                $message = 'Material has been gr !!!';
            } else {
                $delete = PurchaseOrdersDetail::findOrFail($request->id);
                $delete->is_active = 0; //not active
                $delete->update();

                $success = true;
                $message = '';
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restoreItem(Request $request)
    {
        // abort_if(Gate::denies('purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (isset($request->id)) {

            $delete = PurchaseOrdersDetail::findOrFail($request->id);
            $delete->is_active = 1; //active
            $delete->update();

            $success = true;
            $message = '';

            return response()->json([
                'success' => $success,
                'message' => $message,
            ], 200);
        }
    }

    public function printPo($id)
    {
        $po = PurchaseOrder::find($id);
        $print = false;
        $pdf = PDF::loadview('print', \compact('po', 'print'))
            ->setPaper('A4', 'potrait')
            ->setOptions(['debugCss' => true, 'isPhpEnabled' => true])
            ->setWarnings(true);
        // $pdf->save(public_path("storage/{$id}_print.pdf"));
        // Mail::to('jul14n4v@gmail.com')->send(new SendMail($po));
        // $print = true;

        return $pdf->stream();

        // return view('admin.purchase-order.print', compact('po', 'print'));
    }
}
