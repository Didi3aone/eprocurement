@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.master-rfq.title') }}</a></li>
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
            <a class="btn btn-success" href="{{ route("admin.rfq.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.master-rfq.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.master-rfq.import') }}
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
                                <th>{{ trans('cruds.vendors.fields.code') }}</th>
                                <th>{{ trans('cruds.vendors.fields.name') }}</th>
                                <th>{{ trans('cruds.vendors.fields.street') }}</th>
                                <th>{{ trans('cruds.vendors.fields.city') }}</th>
                                <th>{{ trans('cruds.vendors.fields.district') }}</th>
                                <th>{{ trans('cruds.vendors.fields.postal_code') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $key => $vendor)
                                <tr data-entry-id="{{ $vendor->id }}">
                                    <td>{{ $vendor->code ?? '' }}</td>
                                    <td>{{ $vendor->name ?? '' }}</td>
                                    <td>{{ $vendor->street ?? '' }}</td>
                                    <td>{{ $vendor->city ?? '' }}</td>
                                    <td>{{ $vendor->district ?? '' }}</td>
                                    <td>{{ $vendor->postal_code ?? '' }}</td>
                                    <td>
                                        {{-- <a class="btn btn-xs btn-warning" href="{{ route('admin.rfq-add-detail', $vendor->code) }}">
                                            {{ trans('global.add') }}
                                        </a> --}}
                                        <a class="btn btn-xs btn-primary" href="{{ url('admin/rfq-show/' . $vendor->code) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                        {{-- <a class="btn btn-xs btn-info" href="{{ route('admin.rfq.edit', $vendor->code) }}">
                                            {{ trans('global.edit') }}
                                        </a> --}}
                                        {{-- <form action="{{ route('admin.rfq.destroy', $vendor->code) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form> --}}
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
                <h5 class="modal-title" id="modalImport">{{ trans('cruds.master-rfq.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.rfq.import') }}" method="post" enctype="multipart/form-data">
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
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection