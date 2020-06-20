@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User Mapping</a></li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    </div>
</div>
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.mapping.create") }}">
                <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.user-mapping.title_singular') }}
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
                                <th>{{ trans('cruds.user-mapping.fields.id') }}</th>
                                <th>{{ trans('cruds.user-mapping.fields.nik') }}</th>
                                <th>{{ trans('cruds.user-mapping.fields.plant') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($model as $key => $row)
                                <tr data-entry-id="{{ $row->id }}">
                                    <td>{{ $row->id ?? '' }}</td>
                                    <td>{{ $row->user_id ?? '' }}</td>
                                    <td>{{ $row->purchasing_group_code ?? '' }}</td>
                                    <td>
                                        @can('user_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.mapping.edit', $row->id) }}">
                                                {{ trans('global.edit') }}
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