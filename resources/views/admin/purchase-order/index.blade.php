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
                <div class="col-lg-3" style="padding-top: 20px;">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="text" class="mdate form-control form-control-line {{ $errors->has('start_date') ? 'is-invalid' : '' }}" name="start_date" id="start_date" value="{{ date('Y-m-d') }}"> 
                        @if($errors->has('start_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="text" class="mdate form-control form-control-line {{ $errors->has('end_date') ? 'is-invalid' : '' }}" name="end_date" id="end_date" value="{{ date('Y-m-d') }}" > 
                        @if($errors->has('end_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_date') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
                        <button type="button" name="reset" id="reset" class="btn btn-warning">Reset</button>
                    </div>
                </div>
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    &nbsp;
                                </th>
                                <th>PO Number</th>
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
    <a class="btn btn-xs btn-secondary" href="{{ route('admin.purchase-order-resend', "REPLACE") }}">
        <i class="fa fa-envelope"></i> Resend
    </a>
</script>
<!-- <script type="text/javascript">
$(document).ready(function(){

    fill_datatable();

    function fill_datatable(start_date = '', end_date = '')
    {
        var dataTable = $('#datatables-run').DataTable({
            processing: true,
            serverSide: true,
            processing: true,
            pageLength: 50,
            ajax:{
                url: "/admin/purchase-order",
                data:{start_date:start_date, end_date:end_date}
            },
            columns: [
                {
                    data:'po_no',
                    name:'po_no'
                },
                {
                    data:'PO_NUMBER',
                    name:'PO_NUMBER'
                },
                {
                    data:'PO_ITEM',
                    name:'PO_ITEM'
                },
                {
                    data:'acp_no',
                    name:'acp_no'
                },
                {
                    data:'purchasing_group_code',
                    name:'purchasing_group_code'
                },
                {
                    data:'po_date',
                    name:'po_date'
                },
                {
                    data:'material_id',
                    name:'material_id'
                },
                {
                    data:'short_text',
                    name:'short_text'
                },
                {
                    data:'vendor_id',
                    name:'vendor_id'
                },
                {
                    data:'plant_code',
                    name:'plant_code'
                },
                {
                    data:'storage_location',
                    name:'storage_location'
                },
                {
                    data:'qty',
                    name:'qty'
                },
                {
                    data:'unit',
                    name:'unit'
                },
                {
                    data:'qty',
                    name:'qty'
                },
                {
                    data:'qty',
                    name:'qty'
                },
                {
                    data:'original_currency',
                    name:'original_currency'
                },
                {
                    data:'original_price',
                    name:'original_price'
                },
                {
                    data:'currency',
                    name:'currency'
                },
                {
                    data:'price',
                    name:'price'
                },
                {
                    data:'request_no',
                    name:'request_no'
                },
                {
                    data:'po_no',
                    name:'po_no'
                },
                {
                    data:'tax_code',
                    name:'tax_code'
                }
            ]
        });
    }

    $('#filter').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(start_date != '' &&  end_date != '')
        {
            $('#datatables-run').DataTable().destroy();
            fill_datatable(start_date, end_date);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#start_date').val('');
        $('#end_date').val('');
        $('#datatables-run').DataTable().destroy();
        fill_datatable();
    });

});
</script> -->
<script type="text/javascript">
$(document).ready(function(){

    fill_datatable();

    function fill_datatable(start_date = '', end_date = '')
    {
        var dataTable = $('#datatables-run').DataTable({
            dom: 'Bfrtip',
            processing: true,
            serverSide: true,
            processing: true,
            pageLength: 10,
            ajax:{
                url: "/admin/purchase-order",
                data:{start_date:start_date, end_date:end_date}
            },
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
    }

    $('#filter').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(start_date != '' &&  end_date != '')
        {
            $('#datatables-run').DataTable().destroy();
            fill_datatable(start_date, end_date);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#start_date').val('');
        $('#end_date').val('');
        $('#datatables-run').DataTable().destroy();
        fill_datatable();
    });

});
// $('#datatables-run').DataTable({
//     dom: 'Bfrtip',
//     processing: true,
//     serverSide: true,
//     pageLength: 50,
//     //ajax: "/admin/purchase-order",
//     ajax:{
//         url: "/admin/purchase-order",
//         data:{start_date:start_date, end_date:end_date}
//     },
//     "createdRow": function( row, data, dataIndex ) {
//         var tp1 = $('#hidden_action').html()
//         tp1 = tp1.replace(/REPLACE/g, data[0][0])
//         $tp1 = $(row).children('td')[0]
//         $($tp1).html(tp1)
//     },
//     searchDelay: 750,
//     order: [[0, 'desc']],
//     buttons: [
//         'copy', 'csv', 'excel', 'pdf', 'print'
//     ]
// });
</script>
@endsection