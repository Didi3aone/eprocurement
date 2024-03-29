@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Department</a></li>
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
@can('department_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success float-rigth" href="{{ route("admin.department.create") }}">
                <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.masterDepartment.title_singular') }}
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
                                {{ trans('cruds.masterDepartment.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.masterDepartment.fields.category_id') }}
                            </th>
                            <th>
                                {{ trans('cruds.masterDepartment.fields.name') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($department as $key => $val)
                                <tr data-entry-id="{{ $val->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $val->code ?? '' }}
                                    </td>
                                    <td>
                                        {{ $val['category']->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $val->name ?? '' }}
                                    </td>
                                    <td>
                                        @can('department_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.department.show', $val->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('department_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.department.edit', $val->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('department_delete')
                                            <form action="{{ route('admin.permissions.destroy', $val->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection