@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">ACP</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">ACP</a></li>
            <li class="breadcrumb-item active">ACP Approval</li>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                        <th>Acp No</th>
                                        <th>{{ trans('cruds.quotation.fields.status') }}</th>
                                        <th>Total Value</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotation as $key => $val)
                                        <tr data-entry-id="{{ $val->id }}">
                                            <td>{{ $val->id ?? '' }}</td>
                                            <td>{{ $val->acp_no ?? '' }}</td>
                                            <td>
                                                @if($val->status == 0)
                                                    <span class="badge badge-primary">Waiting For Approval</span>
                                                @elseif( $val->status == 1)
                                                    <span class="badge badge-primary">Approved</span>
                                                @elseif( $val->status == 3)
                                                    <span class="badge badge-primary">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $val->totalvalue ?? '' }}</td>
                                            <td>
                                                <a class="btn btn-xs btn-warning" href="{{ route('admin.show-acp-approval', $val->id) }}">
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