<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail;
use App\Models\Vendor;
use App\Models\Plant;
use App\Models\DocumentType;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\PurchaseOrderInvoice;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Imports\PurchaseOrderImport;
use App\Models\PurchaseOrderChangeHistoryDetail;
use App\Models\PurchaseOrderChangeHistory;
use App\Mail\PurchaseOrderMail;

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

        $po = PurchaseOrdersDetail::join('purchase_orders','purchase_orders.id','=','purchase_orders_details.purchase_order_id')
                ->leftJoin('master_acps','master_acps.id','=','purchase_orders_details.acp_id')
                ->leftJoin('vendors','vendors.code','=','purchase_orders.vendor_id')
                ->select(
                    'purchase_orders_details.purchasing_document',
                    'purchase_orders_details.PO_ITEM',
                    'purchase_orders_details.material_id',
                    'purchase_orders_details.short_text',
                    'purchase_orders_details.storage_location',
                    'purchase_orders_details.qty',
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
                    'purchase_orders.id',
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
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();

        $userMapping = explode(',', $userMapping->purchasing_group_code);

        $po = PurchaseOrdersDetail::join('purchase_orders','purchase_orders.id','=','purchase_orders_details.purchase_order_id')
                ->leftJoin('vendors','vendors.code','=','purchase_orders.vendor_id')
                ->whereIn('purchase_orders_details.purchasing_group_code', $userMapping)
                ->where('status_approval', PurchaseOrder::Rejected)
                ->where('is_approve_head', PurchaseOrder::ApproveAss)
                ->select(
                    'purchase_orders_details.purchasing_group_code',
                    'purchase_orders.po_date',
                    'purchase_orders.id',
                    'vendors.name as vendor'
                )
                ->orderBy('purchase_orders_details.created_at', 'desc')->get();

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
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();

        $userMapping = explode(',', $userMapping->purchasing_group_code);

        $po = PurchaseOrdersDetail::join('purchase_orders','purchase_orders.id','=','purchase_orders_details.purchase_order_id')
                ->leftJoin('vendors','vendors.code','=','purchase_orders.vendor_id')
                ->whereIn('purchase_orders_details.purchasing_group_code', $userMapping)
                ->where('is_approve_head', PurchaseOrder::ApproveHead)
                ->select(
                    'purchase_orders_details.purchasing_group_code',
                    'purchase_orders.po_date',
                    'purchase_orders.id',
                    'vendors.name as vendor'
                )
                ->orderBy('purchase_orders_details.created_at', 'desc')->get();

        return view('admin.purchase-order.approval-po-change-head', compact('po'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->get('vendor_id')))
            return redirect()->route('admin.purchase-order-create-po', $request->get('request_id'))->with('status', 'No vendor chosen!');

        if ($request->get('bidding') == 0) { // po repeat
            // create Quotation
            if (empty($request->get('qty')[0]))
                return redirect()->route('admin.purchase-order-create-po', $request->get('request_id'))->with('status', 'Quantity cannot be zero!');

            $quotation = new Quotation;
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
                'subject' => 'PO Repeat ' . $request->get('request_no')
            ];

            \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

            return redirect()->route('admin.quotation.index')->with('status', 'PO Repeat!');
        } elseif ($request->get('bidding') == 2) {
            // penunjukan langsung
            $filename = '';
            
            if ($request->file('upload_file')) {
                $path = 'quotation/';
                $file = $request->file('upload_file');
                
                $filename = $file->getClientOriginalName();
        
                $file->move($path, $filename);
        
                $real_filename = public_path($path . $filename);
            }

            $quotation = new Quotation;
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
                'subject' => 'Penunjukkan langsung ' . $request->get('request_no')
            ];

            \Mail::to($vendor->email)->send(new PurchaseOrderMail($data));

            return redirect()->route('admin.quotation.index')->with('status', 'Penunjukkan Langsung!');
        } else {
            \DB::beginTransaction();

            if ($request->get('online') == 0) {
                // send email to each vendor
                $vendors = $request->get('vendor_id');

                foreach ($vendors as $row) {
                    $row = Vendor::findOrFail($row);
                    $data = [
                        'vendor' => $row,
                        'request_no' => $request->get('request_no'),
                        'subject' => 'Bidding PR no ' . $request->get('request_no')
                    ];
                    
                    // send email
                    \Mail::to($row->email)->send(new PurchaseOrderMail($data));
                }

                return redirect()->route('admin.purchase-order.index')->with('success', 'All vendors has been sent');
            } else {
                try {
                    $vendors = $request->get('vendor_id');

                    if (empty($vendors))
                        return redirect()->route('admin.purchase-order.index')->with('error', 'Vendor has been required');
                    
                    $quotation = new Quotation;
                    $quotation->request_id = $request->get('request_id');
                    $quotation->po_no = $request->get('request_no');
                    $quotation->leadtime_type = $request->get('leadtime_type');
                    $quotation->purchasing_leadtime = $request->get('purchasing_leadtime');
                    $quotation->target_price = str_replace('.', '', $request->get('target_price'));
                    $quotation->expired_date = $request->get('expired_date');
                    $quotation->save();

                    foreach ($vendors as $row) {
                        $quotationDetail = new QuotationDetail;
                        $quotationDetail->quotation_order_id = $quotation->id;
                        $quotationDetail->vendor_id = $row;
                        $quotationDetail->flag = 0;
                        $quotationDetail->save();
                    }

                    $purchaseOrder = new PurchaseOrder;

                    if ($request->get('bidding') == 0)
                        $purchaseOrder->bidding = 0;
                    else
                        $purchaseOrder->bidding = 1;

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
                        'our_reference' => $request->get('our_reference')
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
        }
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);

        return view('admin.purchase-order.show',compact('purchaseOrder'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('purchase_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $currency = \App\Models\Currency::all();
        $top    = \App\Models\PaymentTerm::all();

        return view('admin.purchase-order.edit', compact('purchaseOrder','currency','top'));
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
        $purchaseOrder                 = PurchaseOrder::findOrFail($id);
        $purchaseOrder->notes          = $request->get('notes');
        $purchaseOrder->payment_term   = $request->get('payment_term');

        $poChangeHeader = new PurchaseOrderChangeHistory;
        $poChangeHeader->po_id                  = $purchaseOrder->id;
        $poChangeHeader->vendor_old             = $purchaseOrder->vendor_id;
        $poChangeHeader->vendor_change          = $request->get('payment_term') ?? '';
        $poChangeHeader->notes_old              = $purchaseOrder->notes;
        $poChangeHeader->notes_change           = $request->get('notes');
        $poChangeHeader->peyment_term_old       = $purchaseOrder->payment_term;
        $poChangeHeader->save();
        
        $service        = '';
        $packageParent  = '000000000';
        $subpackgparent = '000000000';
        $noLine         = '';
        $sched          = "";
        $totalPrice = 0;
        foreach ($request->idDetail as $key => $rows) {
            $totalPrice += $request->price[$key];
            $poDetail = PurchaseOrdersDetail::find($rows);
            // if( $poDetail !='' ) {
            if( $poDetail->qty != $request->qty[$key] ) {
                $prDetail = PurchaseRequestsDetail::find($poDetail->request_detail_id);
                $prDetail->qty      += $poDetail->qty;
                $prDetail->qty_order = 0;
                $prDetail->update();

                $prDetail->qty      -= $request->qty[$key];
                $prDetail->qty_order = $request->qty[$key];

                $prDetail->save();

            }
            $poDetail->qty                  = $request->qty[$key];
            $poDetail->price                = $request->price[$key];
            $poDetail->currency             = $request->currency[$key];
            $poDetail->delivery_date        = $request->delivery_date[$key];
            $poDetail->delivery_complete    = $request->delivery_complete[$key];
            $poDetail->tax_code             = $request->tax_code[$key] == 1 ? 'V1' : 'V0';
            
            $poChangeDetail = new PurchaseOrderChangeHistory;
            $poChangeDetail->qty_old        = $poDetail->qty;
            $poChangeDetail->qty_change     = $request->qty[$key];
            $poChangeDetail->po_detail_id   = $poDetail->id;
            $poChangeDetail->po_history_id  = $poChangeHeader->id;
            $poChangeDetail->price_old      = $poDetail->price;
            $poChangeDetail->price_change   = $request->price[$key];
            $poChangeDetail->save();

            $poDetail->update();
            // } else {
            //     $prDetail = PurchaseRequestsDetail::find($request->idPrDetail[$key]);
            //     $prDetail->qty       -= $request->qty[$key];
            //     $prDetail->qty_order  = $request->qty[$key];
                
            //     if( $prDetail->category == PurchaseOrdersDetail::SERVICE ) {
            //         //check position parent and child
            //         if( $key == 0 ) {
            //             $noLine = $lineNo;
            //         } else {
            //             if( $key == 1 ) {
            //                 $noLine = $lineNo - 1;
            //             } else {
            //                 $noLine = $lineNo - $key;
            //             }
            //         }
            //     }

            //     $poItem = PurchaseOrdersDetail::where('purchase_order_id',$id)->max('PO_ITEM');
            //     $poItem += 10; 

            //     $prDetail->update();
            //     $prHeader = PurchaseRequest::find($prDetail->request_id);
            //     PurchaseOrdersDetail::create([
            //         'purchase_order_id'         => $id,
            //         'description'               => $prDetail->description ?? '-',
            //         'qty'                       => $prDetail->qty,
            //         'unit'                      => $prDetail->unit,
            //         'notes'                     => $prDetail->notes ?? '-',
            //         'price'                     => $request->price[$key] ?? 0,
            //         'material_id'               => $prDetail->material,
            //         'assets_no'                 => $prDetail->assets_no,
            //         'material_group'            => $prDetail->material_group,
            //         'preq_item'                 => $prDetail->PREQ_ITEM,
            //         'purchasing_document'       => $prDetail->purchasing_document ?? 0,
            //         'PR_NO'                     => $prHeader->PR_NO,
            //         'assets_no'                 => $prDetail->assets_no,
            //         'acp_id'                    => $prDetail->acp_id ?? 0,
            //         'short_text'                => $prDetail->short_text,
            //         'text_id'                   => $prDetail->text_id,
            //         'text_form'                 => $prDetail->text_form,
            //         'text_line'                 => $prDetail->text_line,
            //         'delivery_date_category'    => $prDetail->delivery_date_category,
            //         'account_assignment'        => $prDetail->account_assignment,
            //         'purchasing_group_code'     => $prDetail->purchasing_group_code,
            //         'gl_acct_code'              => $prDetail->gl_acct_code,
            //         'cost_center_code'          => $prDetail->cost_center_code,
            //         'profit_center_code'        => $prDetail->profit_center_code,
            //         'storage_location'          => $prDetail->storage_location,
            //         'PO_ITEM'                   => "000".$poItem,
            //         'request_no'                => $prDetail->request_no,
            //         'original_price'            => $request->price[$key] ?? 0,
            //         'currency'                  => $prDetail->currency ?? 'IDR',
            //         'preq_name'                 => $prDetail->preq_name,
            //         'delivery_date'             => $request->delivery_date[$key],
            //         'item_category'             => $prDetail->category,
            //         'request_no'                => $prDetail->request_no,
            //         'plant_code'                => $prDetail->plant_code,
            //         'tax_code'                  => $request->tax_code[$key] == 1 ? 'V1' : 'V0',
            //         'package_no'                => $packageParent.$noLine,
            //         'subpackage_no'             => $subpackgparent.$noLine,
            //         'line_no'                   => '000000000'.$noLine,
            //         'SCHED_LINE'                => '000'.$key + 1,
            //         'request_detail_id'         => $prDetail->request_detail_id
            //     ]);
            // }
        }

        if( $purchaseOrder->total_price != $totalPrice ) {
            $purchaseOrder->status_approval = PurchaseOrder::Rejected;
            $purchaseOrder->save();
            return redirect()->route('admin.purchase-order.index')->with('status', 'Purchase order has been updated & waiting approval');
        } else {
            $poChange = \sapHelp::sendPOchangeToSap($purchaseOrder->PO_NUMBER);
            if( $poChange ) {
                $purchaseOrder->status_approval = PurchaseOrder::Approved;
                $purchaseOrder->save();
                return redirect()->route('admin.purchase-order.index')->with('status', 'Purchase order has been updated');
            } else {
                return redirect()->route('admin.purchase-order.index');
                \Session::flash('error','Internal server error');
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = PurchaseOrder::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Profit Center deleted successfully";
        } else {
            $success = true;
            $message = "Profit Center not found";
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyItem(Request $request)
    {
        // abort_if(Gate::denies('purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        
        if( isset($request->id) ) {
            $checkGr = \App\Models\PurchaseOrderGr::getPoItemGr($request->id);

            if( $checkGr > 0 ) {
                $success = false;
                $message = 'Material has been gr !!!';
            } else {
                $delete = PurchaseOrdersDetail::findOrFail($request->id);
                $delete->is_active = 0;//not active
                $delete->update();

                $success = true;
                $message = '';
            }

            return response()->json([
                'success' => $success,
                'message' => $message
            ], 200);
        }
    }

    public function printPo($id)
    {
        $po = PurchaseOrder::find($id);

        return view('admin.purchase-order.print',compact('po'));
    }
}
