@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.cost.title') }}</a></li>
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
@can('gl_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.cost.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.cost.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.cost.import') }}
            </button>
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
                                    {{ trans('cruds.cost.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.area') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.cost_center') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.company_code') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.profit_center') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.hierarchy_area') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.description') }}
                                </th>
                                <th>
                                    {{ trans('cruds.cost.fields.short_text') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($costs as $key => $cost)
                                <tr data-entry-id="{{ $cost->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $cost->id ?? '' }}</td>
                                    <td>{{ $cost->area ?? '' }}</td>
                                    <td>{{ $cost->cost_center ?? '' }}</td>
                                    <td>{{ $cost->company_code ?? '' }}</td>
                                    <td>{{ $cost->profit_center ?? '' }}</td>
                                    <td>{{ $cost->hierarchy_area ?? '' }}</td>
                                    <td>{{ $cost->name ?? '' }}</td>
                                    <td>{{ $cost->description ?? '' }}</td>
                                    <td>{{ $cost->short_text ?? '' }}</td>
                                    <td>
                                        @can('gl_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.cost.show', $cost->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('gl_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.cost.edit', $cost->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('gl_delete')
                                            <form action="{{ route('admin.cost.destroy', $cost->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('cruds.cost.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.cost.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" name="xls_file" id="xls_file">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
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