@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Init GL</a></li>
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
            <a class="btn btn-success" href="{{ route("admin.gl.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.gl.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.gl.import') }}
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
                                    {{ trans('cruds.gl.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.gl.fields.code') }}
                                </th>
                                <th>
                                    {{ trans('cruds.gl.fields.account') }}
                                </th>
                                <th>
                                    {{ trans('cruds.gl.fields.balance') }}
                                </th>
                                <th>
                                    {{ trans('cruds.gl.fields.short_text') }}
                                </th>
                                <th>
                                    {{ trans('cruds.gl.fields.acct_long_text') }}
                                </th>
                                <th>
                                    {{ trans('cruds.gl.fields.long_text') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gls as $key => $gl)
                                <tr data-entry-id="{{ $gl->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $gl->id ?? '' }}</td>
                                    <td>{{ $gl->code ?? '' }}</td>
                                    <td>{{ $gl->account ?? '' }}</td>
                                    <td>{{ $gl->balance ?? '' }}</td>
                                    <td>{{ $gl->short_text ?? '' }}</td>
                                    <td>{{ $gl->acct_long_text ?? '' }}</td>
                                    <td>{{ $gl->long_text ?? '' }}</td>
                                    <td>
                                        @can('gl_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.gl.show', $gl->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('gl_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.gl.edit', $gl->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('gl_delete')
                                            <form action="{{ route('admin.gl.destroy', $gl->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('cruds.gl.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.gl.import') }}" method="post" enctype="multipart/form-data">
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