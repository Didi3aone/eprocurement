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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Request No.</th>
                                <th>Notes</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pr as $key => $value)
                                <tr>
                                    <td>{{ $value->PR_NO }}</td>
                                    <td>{{ $value->notes }}</td>
                                    <td>{{ $value->request_date }}</td>
                                    <td>{{ number_format($value->total, 0, '', '.') }}</td>
                                    <td>
                                        @if( $value->is_validate == 1 && $value->approval_status == 12)
                                        <a class="open_modal_bidding btn btn-xs btn-success" id="open_modal" data-id="{{ $value->id }}" data-toggle="modal" data-target="#modal_create_po" href="javascript:;" >
                                            <i class="fa fa-truck"></i> Create PO
                                        </a>
                                        @endif
                                        <a class="open_modal_bidding btn btn-xs btn-info" href="{{ route('admin.purchase-request-show',$value->id) }}" >
                                            <i class="fa fa-eye"></i> Show
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

<div class="modal fade" id="modal_create_po" tabindex="-1" role="dialog" aria-labelledby="modalCreatePO" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImport">{{ 'Bidding Model' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <a href="#" class="bidding-online btn btn-primary btn-lg">Online</a>
                    </div>
                    <div class="col-lg-4 text-center">
                        <a href="#" class="bidding-repeat btn btn-info btn-lg">Repeat Order</a>
                    </div>
                    <div class="col-lg-4 text-center">
                        <a href="#" class="bidding-direct btn btn-success btn-lg">Direct Order</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    $(document).on('click', '#open_modal', function (e) {
        e.preventDefault()

        const id = $(this).data('id')

        $(document).find('.bidding-online').attr('href', '{{ url('admin/purchase-request-online') }}/' + id)
        $(document).find('.bidding-repeat').attr('href', '{{ url('admin/purchase-request-repeat') }}/' + id)
        $(document).find('.bidding-direct').attr('href', '{{ url('admin/purchase-request-direct') }}/' + id)
    })

    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        order: [[0, 'desc']],
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