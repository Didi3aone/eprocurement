@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.master-acp.title') }}</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
@can('master_acp_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.master-acp.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.master-acp.title_singular') }}
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
                                <th>{{ trans('cruds.master-acp.fields.id') }}</th>
                                <th>{{ trans('cruds.master-acp.fields.acp_no') }}</th>
                                <th>Approval</th>
                                <th>Project</th>
                                <th>Vendor</th>
                                <th>Currency</th>
                                <th>Total Value</th>
                                <th>Created At</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($model as $key => $acp)
                                <tr data-entry-id="{{ $acp->id }}">
                                    <td>{{ $acp->id ?? '' }}</td>
                                    <td>{{ $acp->acp_no ?? '' }}</td>
                                    <td>{{ \App\Models\AcpTable::Type_Status[$acp->status_approval] }}</td>
                                    <td>{{ \App\Models\AcpTable::Type_Project[$acp->is_project] }}</td>
                                    <td>{{ $acp->company_name }}</td>
                                    <td>{{ $acp->currency }}</td>
                                    <td style="text-align:right;">{{ \toDecimal($acp->total) }}</td>
                                    <td>{{ $acp->created_at }}</td>
                                    <td>
                                        @can('master_acp_show')
                                            <a class="btn btn-primary btn-xs" href="{{ route('admin.master-acp.show', $acp->id) }}">
                                                <i class="fa fa-eye"></i> {{ trans('global.view') }}
                                            </a>
                                        @endcan
                                        @can('master_acp_delete')
                                            <form action="{{ route('admin.master-acp.destroy', $acp->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection