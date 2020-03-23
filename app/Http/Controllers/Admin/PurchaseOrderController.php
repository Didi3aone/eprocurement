<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail;
use App\Models\Vendor;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPo($id)
    {
        // abort_if(Gate::denies('purchase_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pr = PurchaseRequest::find($id);
        $prDetail = PurchaseRequestsDetail::where('purchase_id', $id)->get();
        $vendor   = Vendor::get();

        return view('admin.purchase-order.create',compact('pr','prDetail','vendor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchaseOrder = PurchaseOrder::create($request->all());

        if( $request->has('description') ) {
            foreach( $request->get('description') as $key => $row ) {
                PurchaseOrdersDetail::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'description'       => $row,
                    'qty'               => $request->get('qty')[$key],
                    'unit'              => $request->get('unit')[$key],
                    'notes'             => $request->get('notes_detail')[$key],
                    'price'             => $request->get('price')[$key]
                ]);
            }
        }

        return redirect()->route('admin.purchase-order.index')->with('status', trans('cruds.purchase_order.alert_success_insert'));
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
        $vendors = Vendor::all();

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
