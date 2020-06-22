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
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
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
                                <th>{{ trans('cruds.master-acp.fields.is_approval') }}</th>
                                <th>{{ trans('cruds.master-acp.fields.is_project') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($model as $key => $acp)
                                <tr data-entry-id="{{ $acp->id }}">
                                    @php
                                        $approval = 'Pending';
                                        if ($acp->is_approval == 1)
                                            $approval = 'Approved';
                                        elseif ($acp->is_approval == 2)
                                            $approval = 'Rejected';
                                    @endphp
                                    <td>{{ $acp->id ?? '' }}</td>
                                    <td>{{ $acp->acp_no ?? '' }}</td>
                                    <td>{{ $approval }}</td>
                                    <td>{{ $acp->is_project == 1 ? 'Is Project' : 'Non Project' }}</td>
                                    <td>
                                        @can('master_acp_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.master-acp.show', $acp->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('master_acp_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.master-acp.edit', $acp->id) }}">
                                                {{ trans('global.edit') }}
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
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection