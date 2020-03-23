@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Bidding</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Bidding</a></li>
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
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success float-rigth" href="{{ route("vendor.bidding.create") }}">
            <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.bidding.title_singular') }}
        </a>
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
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.bidding.fields.id') }}
                                </th>
                                <th>
                                    PO No.
                                </th>
                                <th>
                                    {{ trans('cruds.bidding.fields.bidding') }}
                                </th>
                                <th>
                                    {{ trans('cruds.bidding.fields.request_date') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($biddings as $key => $bid)
                                <tr data-entry-id="{{ $bid->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $bid->id ?? '' }}</td>
                                    <td>{{ $bid->po_no }}</td>
                                    <td>{{ $bid->bidding == 1 ? 'Yes' : 'No' }}</td>
                                    <td>{{ $bid->po_date ?? '' }}</td>
                                    <td>
                                        @can('purchase_order_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.bidding.show', $bid->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('purchase_order_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.bidding.edit', $bid->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('purchase_order_delete')
                                            <form action="{{ route('admin.bidding.destroy', $bid->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                    url: "{{ url('admin.request-note.destroy') }}"+id ,
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