@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Acp</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Acp</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
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
                                        <th>Acp No</th>
                                        <th>Vendor</th>
                                        <th>{{ trans('cruds.quotation.fields.status') }}</th>
                                        <th>Currency</th>
                                        <th>Total Value</th>
                                        <th>&nbsp;</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    @foreach($quotation as $key => $val)
                                         <tr data-entry-id="{{ $val->id }}">
                                            <td>{{ $val->id ?? '' }}</td>
                                            <td>{{ $val->acp_no ?? '' }}</td>
                                            <td>{{ $val->company_name ?? '' }}</td>
                                            <td>
                                                @if($val->status_approval == 0)
                                                    <span class="badge badge-primary">Waiting For Approval</span>
                                                @elseif( $val->status_approval == 2)
                                                    <span class="badge badge-primary">Approved</span>
                                                @elseif( $val->status_approval == 3)
                                                    <span class="badge badge-primary">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $val->currency ?? '' }}</td>
                                            <td>{{ \toDecimal($val->totalvalue)  ?? '' }}</td>
                                            <td>
                                                <a class="btn btn-xs btn-warning" href="{{ route('admin.show-acp-approval-finish', $val->id) }}">
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