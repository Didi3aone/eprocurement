@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchase Order</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary" href="{{ route('admin.purchase-order.index') }}">
                    <i class="fa fa-arrow-left"></i> Back To list
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('cruds.purchasing_group.fields.id') }}</th>
                            <td>{{ $purchaseOrder->id }}</td>
                        </tr>
                        <tr>
                            <th>PO Number</th>
                            <td>{{ $purchaseOrder->PO_NUMBER }}</td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td>{{ $purchaseOrder->notes }}</td>
                        </tr>
                        <tr>
                            <th>Vendor</th>
                            <td>{{ $purchaseOrder->vendor_id." - ".$purchaseOrder->vendors['name'] }}</td>
                        </tr>
                        <tr>
                            <th>Payment Term</th>
                            <td>{{ $purchaseOrder->payment_term }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrder->orderDetail as $key => $value)
                        <tr>
                            <td>{{ $value->material_id." - ".$value->short_text }}</td>
                            <td>{{ \getUomCode($value->unit) }}</td>
                            <td>{{ $value->qty }}</td>
                            <td>{{ $value->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>Material</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Debit Credit</th>
                            <th>Amount</th>
                            <th>Item GR</th>
                            <th>Doc Gr</th>
                            <th>Ref Doc</th>
                            <th>Delivery Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrder->orderGrDetail as $key => $value)
                        <tr>
                            <td>{{ $value->po_no }}</td>
                            <td>{{ $value->material_no }}</td>
                            <td>{{ $value->satuan }}</td>
                            <td>{{ $value->qty }}</td>
                            <td>{{ $value->debet_credit }}</td>
                            <td>{{ $value->amount }}</td>
                            <td>{{ $value->item_gr }}</td>
                            <td>{{ $value->doc_gr }}</td>
                            <td>{{ $value->reference_document }}</td>
                            <td>{{ $value->delivery_completed }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection