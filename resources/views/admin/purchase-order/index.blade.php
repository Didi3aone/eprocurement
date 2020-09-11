@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.purchase-order.title') }}</a></li>
            <li class="breadcrumb-item active">List</li>
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
                                <th>
                                    &nbsp;
                                </th>
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
                            </tr>
                        </thead>
                        <tbody>
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
<script id="hidden_action" type="text/x-custom-template">
    <a class="btn btn-xs btn-primary" href="{{ route('admin.purchase-order.show', "REPLACE") }}">
        <i class="fa fa-eye"></i> {{ trans('global.view') }}
    </a>
    <a class="btn btn-xs btn-info" href="{{ route('admin.purchase-order-print', "REPLACE") }}" target="_blank">
        <i class="fa fa-print"></i> {{ 'print' }}
    </a>
    @can('purchase_order_edit')
    <a class="btn btn-xs btn-success" href="{{ route('admin.purchase-order.edit', "REPLACE") }}">
        <i class="fa fa-edit"></i> {{ trans('global.edit') }}
    </a>
    @endcan
    <a class="btn btn-xs btn-warning" href="{{ route('admin.purchase-order-delivery', "REPLACE") }}">
        <i class="fa fa-truck"></i> Delivery Complete
    </a>
</script>
<script>
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    processing: true,
    serverSide: true,
    pageLength: 50,
    ajax: "/admin/purchase-order",
    "createdRow": function( row, data, dataIndex ) {
        var tp1 = $('#hidden_action').html()
        tp1 = tp1.replace(/REPLACE/g, data[0][0])
        $tp1 = $(row).children('td')[0]
        $($tp1).html(tp1)
    },
    searchDelay: 750,
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection