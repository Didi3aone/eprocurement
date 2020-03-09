@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User Management</a></li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    </div>
</div>
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
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
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.email') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.department_id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.roles') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                                <tr data-entry-id="{{ $user->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $user->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $user->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $user->email ?? '' }}
                                    </td>
                                    <td>
                                        {{ $user['department']->name ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($user->roles as $key => $item)
                                            <span class="badge badge-info">{{ $item->title }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('user_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('user_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('user_delete')
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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