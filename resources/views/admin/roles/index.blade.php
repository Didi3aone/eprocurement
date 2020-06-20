@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
            <li class="breadcrumb-item active">Role</li>
        </ol>
    </div>
</div>
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.roles.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
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
                                    {{ trans('cruds.role.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.role.fields.title') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $role)
                                <tr data-entry-id="{{ $role->id }}">
                                    <td>
                                        {{ $role->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $role->title ?? '' }}
                                    </td>
                                    <td>
                                        @can('role_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $role->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('role_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.roles.edit', $role->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('role_delete')
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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