@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PR</a></li>
            <li class="breadcrumb-item active">Approval List</li>
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
@can('rn_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success float-rigth" href="{{ route("admin.request-note.create") }}">
                <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.request-note.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>
                                Request No.
                            </th>
                            <th>
                                Notes
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Total
                            </th>
                            <th>
                                &nbsp; 
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($pr as $key => $value)
                                <tr>
                                    <td>{{ $value->getPurchaseRequest['request_no'] }}</td>
                                    <td>{{ $value->getPurchaseRequest['notes'] }}</td>
                                    <td>{{ $value->getPurchaseRequest['request_date'] }}</td>
                                    <td>{{ $value->getPurchaseRequest['total'] }}</td>
                                    <td>
                                        
                                        <a class="btn btn-xs btn-success approve" data-req="{{ $value->getPurchaseRequest['id'] }}" data-id="{{ $value->id }}" href="#">
                                            <i class="fa fa-check"></i> Approve
                                        </a>
                                        <a class="btn btn-xs btn-danger" href="#">
                                            <i class="fa fa-times"></i> Reject
                                        </a>
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

    $(".approve").click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var no = $(this).data('req');
        var conf = confirm('are you sure');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        if( conf == true ) {
            $.ajax({
                type: 'PUT',
                url: "{{ route('admin.purchase-request-approval') }}",
                data: {
                    _token: CSRF_TOKEN,
                    id : id,
                    req_id : no
                },
                dataType: 'JSON',
                success: function (results) {
                    if (results.success === true) {
                        swal("Done!", results.message, "success");
                        location.reload();
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }
    });
</script>
@endsection