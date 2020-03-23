@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PR</a></li>
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
                                    <td>{{ $value->request_no }}</td>
                                    <td>{{ $value->notes }}</td>
                                    <td>{{ $value->request_date }}</td>
                                    <td>{{ $value->total }}</td>
                                    <td>
                                        <a class="open_modal_bidding btn btn-xs btn-success" href="javascript:;" data-id="{{ $value->id }}" data-target="#chooseBidding" data-toggle="modal">
                                            <i class="fa fa-truck"></i> Create PO
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

<!-- Modal -->
<div class="modal fade" id="chooseBidding" tabindex="-1" role="dialog" aria-labelledby="chooseBidding" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chooseBidding">Pilih Bidding atau Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('admin.purchase-order-make-quotation') }}" method="post">
                            @csrf
                            <input type="hidden" name="request_id" class="request_id" value="">
                            <button type="submit" class="float-left form-control btn btn-success btn-lg" style="color: white">Buat Quotation</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form action="{{ route('admin.purchase-order-make-bidding') }}" method="post">
                            @csrf
                            <input type="hidden" name="request_id" class="request_id" value="">
                            <button type="submit" class="float-left form-control btn btn-primary btn-lg" style="color: white">Bidding</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $('#chooseBidding').on('show.bs.modal', function (event) {
        var request = $(event.relatedTarget);
        var id = request.data('id');

        $('.request_id').val(id);
    });

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

        swal({
            title: "Approve?",
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
    });
</script>
@endsection