@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Repeat Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Repeat Order</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
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
                                <th>#</th>
                                <th>PO Number</th>
                                <th>Notes</th>
                                <th>PO Date</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($poRepeat as $key => $val)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $val->PO_NUMBER ?? '' }}</td>
                                    <td>{{ $val->notes }}</td>
                                    <td>{{ $val->po_date }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('vendor.purchase-order-repeat-detail',Crypt::encryptString($val->id) ) }}">
                                            <i class="fa fa-eye"></i>
                                            Show
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
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection