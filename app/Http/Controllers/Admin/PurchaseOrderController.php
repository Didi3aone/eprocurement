<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail;
use App\Models\Vendor;
use App\Models\Plant;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Imports\PurchaseOrderImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

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

        $purchaseOrders = PurchaseOrder::all();

        return view('admin.purchase-order.index', compact('purchaseOrders'));
    }

    /**
     * Display a listing of the quotation resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quotation ($id)
    {
        $quotations = Quotation::where('request_id', $id)->get();
        $is_expired = '#67757c';

        return view('admin.purchase-order.quotation', compact('quotations', 'is_expired'));
    }

    public function viewQuotation ($id)
    {
        $quotation = Quotation::find($id);
        $quotationDetail = QuotationDetail::where('quotation_order_id', $id)->get();

        return view('admin.purchase-order.view-quotation', compact('quotation', 'quotationDetail'));
    }

    public function approveQuotation (Request $request, $id)
    {
        \DB::beginTransaction();

        try {
            $quotation = Quotation::find($id);
            $quotation->status = 1;
            $quotation->save();

            // approval each items
            if ($request->has('description')) {
                foreach ($request->get('description') as $key => $value) {
                    $quotationDetail = QuotationDetail::find($key);

                    if ($value->flag == 1)
                        $quotationDetail->flag = 1;

                    $quotationDetail->save();
                }
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
        }

        return redirect()->route('admin.purchase-order.quotation')->with('success', trans('cruds.purchase-order.alert_quotation_approval'));
    }

    /**
     * Approval Purchase Order
     */
    public function approvalPo ($id)
    {
        $po = PurchaseOrder::find($id);
        $po->status = 1;

        if ($po->save()) {
            // send to WSDL
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPo($id)
    {
        // abort_if(Gate::denies('purchase_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pr         = PurchaseRequest::find($id);
        $prDetail   = PurchaseRequestsDetail::where('purchase_id', $id)->get();
        $plant      = Plant::get();
        $vendor     = Vendor::where('status', 1)->orderBy('name')->get();

        return view('admin.purchase-order.create',compact('pr', 'prDetail', 'plant', 'vendor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('bidding') == 0) {
        } else {
            \DB::beginTransaction();

            if ($request->get('online') == 0) {
                // send email to each vendor
                $vendors = $request->get('vendor_id');

                foreach ($vendors as $row) {
                    $row = Vendor::findOrFail($vendor);
                    
                    // send email
                    dd($row);
                }    
            } else {
                try {
                    $vendors = $request->get('vendor_id');

                    if (empty($vendors))
                        return redirect()->route('admin.purchase-order.index')->with('error', 'Vendor has been required');
                    
                    foreach ($vendors as $row) {
                        $quotation = new Quotation;
                        $quotation->request_id = $request->get('request_id');
                        $quotation->vendor_id = $row;
                        $quotation->po_no = $request->get('request_no');
                        $quotation->leadtime_type = $request->get('leadtime_type');
                        $quotation->purchasing_leadtime = $request->get('purchasing_leadtime');
                        $quotation->target_price = $request->get('target_price');
                        $quotation->expired_date = $request->get('expired_date');
                        $quotation->save();
                    }

                    $purchaseOrder = new PurchaseOrder;

                    if ($request->get('bidding') == 0) {
                        $purchaseOrder->bidding = 0;
                        // $purchaseOrder->vendor_id = $request->get('vendor_id');
                    } else {
                        $purchaseOrder->bidding = 1;
                        // $purchaseOrder->vendor_id = null;
                    }

                    $purchaseOrder->po_no = str_replace($request->get('request_no'));
                    $purchaseOrder->po_date = date('Y-m-d');
                    // $purchaseOrder->notes = str_replace($request->get('notes'));
                    $purchaseOrder->request_id = $request->get('request_id');
                    $purchaseOrder->status = 0;
                    $purchaseOrder->save();

                    // if( $request->has('description') ) {
                    //     foreach( $request->get('description') as $key => $row ) {
                    //         $model = new PurchaseOrdersDetail;
                    //         $model->purchase_order_id = $purchaseOrder->id;
                    //         $model->description       = $row;
                    //         $model->qty               = $request->get('qty')[$key];
                    //         $model->unit              = $request->get('unit')[$key];
                    //         $model->notes             = $request->get('notes_detail')[$key];
                    //         $model->price             = $request->get('price')[$key];
                    //         $model->save();
                    //     }
                    // }

                    \DB::commit();

                    return redirect()->route('admin.purchase-order.index')->with('status', trans('cruds.purchase-order.alert_success_insert'));
                } catch (Exception $e) {
                    \DB::rollBack();
            
                    return redirect()->route('admin.quotation.index')->with('error', trans('cruds.purchase-order.alert_error_insert'));
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        return view('admin.purchase-order.show', compact('purchaseOrder'));
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

        return view('admin.purchase-order.edit', compact('profitCenter'));
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
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->code = $request->get('code');
        $purchaseOrder->name = $request->get('name');
        $purchaseOrder->small_description = $request->get('small_description');
        $purchaseOrder->description = $request->get('description');
        $purchaseOrder->save();
        
        return redirect()->route('admin.purchase-order.index')->with('status', trans('cruds.purchase_order.alert_success_update'));
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

    public function makeQuotation (Request $request)
    {
        $purchaseRequest = PurchaseRequest::find($request->input('request_id'));
        $vendors = Vendor::where([
            'status' => 1,
            'bidding' => 0
        ])->get();

        return view('admin.purchase-order.quotation', compact('purchaseRequest', 'vendors'));
    }

    public function makeBidding (Request $request)
    {
        $order = new PurchaseOrder;
        $order->request_id = $request->input('request_id');
        $order->bidding = 1;
        $order->notes = 'make bidding';
        $order->request_date = date('Y-m-d');
        $order->status = 1;
        $order->save();

        return redirect()->route('admin.purchase-order.index')->with('status', trans('cruds.purchase_order.alert_success_update'));
    }
}
