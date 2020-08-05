@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendors</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
@can('vendor_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.vendors.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.vendors.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <a href="{{ route('admin.vendors.download') }}" class="btn btn-success"><i class="fa fa-file"></i> Export Vendors</a>
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.vendors.import') }}
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
                                <th style="display: none;">
                                    &nbsp;
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.id') }}
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.email') }}
                                </th>
                                <th>
                                    BP Grouping
                                </th>
                                <th>
                                    Supplier Account Group
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.address') }}
                                </th>
                                <th>
                                    Created at
                                </th>
                                <th>
                                    Updated at
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $key => $vendor)
                                <tr data-entry-id="{{ $vendor->id }}">
                                    <td style="display: none;">{{ $vendor->status_ }}</td>
                                    <td>{{ $vendor->id }}</td>
                                    <td>{!! $vendor->status_str !!}</td>
                                    <td>{{ $vendor->company_name }}</td>
                                    <td>{{ $vendor->email }}</td>
                                    <td>{{ $vendor->vendor_bp_group_code }}</td>
                                    <td>{{ $vendor->specialize }}</td>
                                    <td>{{ $vendor->street }}</td>
                                    <td>{{ $vendor->created_date }}</td>
                                    <td>{{ $vendor->updated_date }}</td>
                                    <td>
                                        <button class="show_modal btn btn-xs btn-success" data-id="{{ $vendor->id }}" data-toggle="modal" data-target="#modal_password">
                                            <i class="fa fa-key"></i> {{ trans('global.set_password') }}
                                        </button>
                                        @can('vendor_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.vendors.show', $vendor->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('vendor_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.vendors.edit', $vendor->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('vendor_delete')
                                            <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('cruds.vendors.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.vendors.import') }}" method="post" enctype="multipart/form-data">
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

<div class="modal fade" id="modal_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalPasswordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPasswordLabel">{{ trans('cruds.vendors.password') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.vendors.set-password') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="vendor_id" id="vendor_id" value="">
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.password') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" value="{{ old('password') }}" required> 
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.password_confirmation') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation" value="{{ old('password_confirmation') }}" required> 
                        @if($errors->has('password_confirmation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                    </div>
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
    order: [[0, 'asc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});

$('.show_modal').on('click', function (e) {
    e.preventDefault()

    const id = $(this).data('id')
    $('#vendor_id').val(id)
})
</script>
@endsection