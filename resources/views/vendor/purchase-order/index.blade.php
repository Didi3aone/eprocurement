@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchase Request</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
{{-- <div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success float-rigth" href="{{ route("vendor.purchase-order.create") }}">
            <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.purchase-order.title_singular') }}
        </a>
    </div>
</div> --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.id') }}
                                </th>
                                <th>
                                    PO No.
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.bidding') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.request_date') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchaseOrders as $key => $po)
                                <tr data-entry-id="{{ $po->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $po->id ?? '' }}</td>
                                    <td>{{ $po->po_no }}</td>
                                    <td>{{ $po->bidding == 1 ? 'Yes' : 'No' }}</td>
                                    <td>{{ $po->po_date ?? '' }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('vendor.purchase-order.bidding', $po->id, Auth::user()->id) }}">
                                            {{ trans('cruds.purchase-order.bidding') }}
                                        </a>
                                        @can('purchase_order_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('vendor.purchase-order.show', $po->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('purchase_order_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('vendor.purchase-order.edit', $po->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('purchase_order_delete')
                                            <form action="{{ route('vendor.purchase-order.destroy', $po->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
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
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    function deleteConfirmation(id) {
        swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('vendor.request-note.destroy') }}"+id ,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }
</script>
@endsection