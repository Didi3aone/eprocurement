@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.unit.title_singular') }}</a></li>
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
@can('unit_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success float-rigth" href="{{ route("admin.unit.create") }}">
                <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.unit.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.unit.import') }}
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
                                {{ trans('cruds.unit.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.unit.fields.uom') }}
                            </th>
                            <th>
                                {{ trans('cruds.unit.fields.iso') }}
                            </th>
                            <th>
                                {{ trans('cruds.unit.fields.text') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($units as $key => $val)
                                <tr data-entry-id="{{ $val->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $val->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $val->uom }}
                                    </td>
                                    <td>
                                        {{ $val->iso ?? '' }}
                                    </td>
                                    <td>
                                        {{ $val->text ?? '' }}
                                    </td>
                                    <td>
                                        @can('unit_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.unit.show', $val->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('unit_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.unit.edit', $val->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('unit_delete')
                                            {{-- <form action="{{ route('admin.permissions.destroy', $val->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form> --}}
                                            <button class="btn btn-xs btn-danger" onclick="deleteConfirmation({{$val->id}})">Delete</button>
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

<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="modal_import" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('cruds.unit.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.unit.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" name="xls_file" id="xls_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    function deleteConfirmation(id) {
        swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (e) {
            if (e) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('admin') }}/unit/" + id ,
                    data: { _token: CSRF_TOKEN },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                            window.location.reload()
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });
            } else {
                swal('Cancel')
            }
        })
    }
</script>
@endsection