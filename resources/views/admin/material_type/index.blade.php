@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.material_type.title') }}</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
@can('material_type_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.material_type.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.material_type.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.material_type.import') }}
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
                                    {{ trans('cruds.material_type.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.material_type.fields.code') }}
                                </th>
                                <th>
                                    {{ trans('cruds.material_type.fields.description') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materialType as $key => $mt)
                                <tr data-entry-id="{{ $mt->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $mt->id ?? '' }}</td>
                                    <td>{{ $mt->code ?? '' }}</td>
                                    <td>{{ $mt->description ?? '' }}</td>
                                    <td>
                                        @can('material_type_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.material_type.show', $mt->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('material_type_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.material_type.edit', $mt->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('material_type_delete')
                                            <form action="{{ route('admin.material_type.destroy', $mt->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="modalImport" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImport">{{ trans('cruds.material_type.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.material_type.import') }}" method="post" enctype="multipart/form-data">
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