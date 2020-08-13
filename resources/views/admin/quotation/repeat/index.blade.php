@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">PO In Process</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO In Process</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
@if(Session::has('notif'))   
    @foreach(Session::get('notif')->item as $key => $value)
        <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
        <strong>Error  !!!</strong> <br/> {{ $value->MESSAGE }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endforeach
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                        <th>PO Eprocurement</th>
                                        <th>Vendor</th>
                                        <th>Approval Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotation as $key => $val)
                                        <tr data-entry-id="{{ $val->id }}">
                                            <td>{{ $val->id ?? '' }}</td>
                                            <td>{{ $val->po_no ?? '' }}</td>
                                            <td>{{ $val->vendor_id." - ".$val->company_name }}</td>
                                            <td>{{ \App\Models\Vendor\Quotation::TypeStatusApproval[$val->approval_status] }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-xs" href="{{ route('admin.quotation-repeat.show', $val->id) }}">
                                                    <i class="fa fa-eye"></i> {{ trans('global.view') }}
                                                </a>
                                                @can('button_test_run_access')
                                                <a class="btn btn-danger btn-xs" href="{{ route('admin.quotation-test-run', $val->id) }}">
                                                    <i class="fa fa-bug"></i> Test Run Bos
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