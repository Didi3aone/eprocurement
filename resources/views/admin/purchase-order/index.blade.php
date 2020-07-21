@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.purchase-order.title') }}</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                {{-- <th>Release Indicator</th> --}}
                                <th>Purchasing Document</th>
                                <th>Item Po Line</th>
                                <th>Rfq/ACP Document</th>
                                <th>Purchasing Group</th>
                                <th>Document Date</th>
                                <th>Material</th>
                                <th>Short Text</th>
                                <th>Supplier/Supplying Plant</th>
                                <th>Plant</th>
                                <th>Storage Location</th>
                                <th>Order Quantity</th>
                                <th>Order Unit</th>
                                <th>Still to be delivered (qty)</th>
                                <th>Still to be invoiced (qty)</th>
                                <th>Original Currency</th>
                                <th>Original Price</th>
                                <th>Currency</th>
                                <th>Net Price</th>
                                <th>Req Tracking Number</th>
                                <th>Still to be Delivered Value</th>
                                <th>Tax Code</th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($po as $key => $q)
                                <tr>
                                    {{-- <td>-</td> --}}
                                    <td>{{ $q->PO_NUMBER ?? 0 }}</td>
                                    <td>{{ $q->PO_ITEM }}</td>
                                    <td>{{ $q->acp_no ?? $q->purchasing_document }}</td>
                                    <td>{{ $q->purchasing_group_code }}</td>
                                    <td>{{ $q->po_date }}</td>
                                    <td>{{ $q->material_id }}</td>
                                    <td>{{ $q->short_text }}</td>
                                    <td>{{ $q->vendor_id." - ".$q->vendor }}</td>
                                    <td>{{ $q->plant_code }}</td>
                                    <td>{{ $q->storage_location }}</td>
                                    <td>{{ $q->qty }}</td>
                                    <td>{{ $q->unit }}</td>
                                    <td>{{ $q->qty - $q->qty_gr }}</td>
                                    <td>{{ $q->qty - $q->qty_billing }}</td>
                                    <td>{{ $q->original_currency }}</td>
                                    <td>{{ $q->original_price }}</td>
                                    <td>{{ $q->currency }}</td>
                                    <td>{{ $q->price }}</td>
                                    <td>{{ $q->request_no }}</td>
                                    <td>{{ '0' }}</td>
                                    <td>{{ $q->tax_code  }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.purchase-order.show', $q->id) }}">
                                            <i class="fa fa-eye"></i> {{ trans('global.view') }}
                                        </a>
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.purchase-order-print', $q->id) }}" target="_blank">
                                            <i class="fa fa-print"></i> {{ 'print' }}
                                        </a>
                                        @can('purchase_order_edit')
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.purchase-order.edit', $q->id) }}">
                                            <i class="fa fa-edit"></i> {{ trans('global.edit') }}
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection