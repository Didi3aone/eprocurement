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
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.vendors.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.vendors.title_singular') }}
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
                                    {{ trans('cruds.vendors.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.no_vendor') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.nama_vendor') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.departemen_peminta') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vendors.fields.status') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $key => $vendor)
                                <tr data-entry-id="{{ $vendor->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $vendor->id ?? '' }}</td>
                                    <td>{{ $vendor->no_vendor ?? '' }}</td>
                                    <td>{{ $vendor->nama_vendor ?? '' }}</td>
                                    <td>{{ $vendor['department']->name ?? '' }}</td>
                                    <td>{{ $vendor->status }}</td>
                                    <td>
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