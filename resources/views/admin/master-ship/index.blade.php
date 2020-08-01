@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Ship To</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
@can('ship_to_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.ship-to.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} Ship To
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
                                    PT
                                </th>
                                <th>
                                    Address
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shipTo ?? '' as $key => $st)
                                <tr>
                                    <td>{{ $st->id ?? '' }}</td>
                                    <td>{{ $st->name ?? '' }}</td>
                                    <td>{{ $st->alamat ?? '' }}</td>
                                    <td>
                                        @can('ship_to_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.ship-to.show', $st->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('ship_to_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.ship-to.edit', $st->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('ship_to_delete')
                                            <form action="{{ route('admin.ship-to.destroy', $st->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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