@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Material</a></li>
            <li class="breadcrumb-item active">List</li>
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
@if(session('status'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" id="info-alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@can('material_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success float-rigth" href="{{ route("admin.material.create") }}">
                <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.masterMaterial.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.masterMaterial.import') }}
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
                            <th>{{ trans('cruds.masterMaterial.fields.id') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.code') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.description') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.plant_code') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.material_type_code') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.uom_code') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.purchasing_group_code') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.storage_location_code') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.material_group_code') }}</th>
                            <th>{{ trans('cruds.masterMaterial.fields.profit_center_code') }}</th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($material as $key => $val)
                                <tr data-entry-id="{{ $val->id }}">
                                    <td>{{ $val->id ?? '' }}</td>
                                    <td>{{ $val->code ?? '' }}</td>
                                    <td>{{ $val->description ?? '' }}</td>
                                    <td>{{ $val->plant_code ?? '' }}</td>
                                    <td>{{ $val->material_type_code ?? '' }}</td>
                                    <td>{{ $val->uom_code ?? '' }}</td>
                                    <td>{{ $val->purchasing_group_code ?? '' }}</td>
                                    <td>{{ $val->storage_location_code ?? '' }}</td>
                                    <td>{{ $val->material_group_code ?? '' }}</td>
                                    <td>{{ $val->profit_center_code ?? '' }}</td>
                                    <td>
                                        @can('material_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.material.show', $val->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('material_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.material.edit', $val->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('material_delete')
                                            <button class="btn btn-xs btn-danger" onclick="deleteConfirmation({{$val->id}})">Delete</button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach --}}
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
                <h5 class="modal-title">{{ trans('cruds.masterMaterial.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.material.import') }}" method="post" enctype="multipart/form-data">
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

    $("#info-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#info-alert").slideUp(500);
    });

    $("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#danger-alert").slideUp(500);
    });
    
    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        // order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: '{{ route('admin.material.list') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'code', name: 'code' },
            { data: 'description', name: 'description' },
            { data: 'plant_code', name: 'plant_code' },
            { data: 'material_type_code', name: 'material_type_code' },
            { data: 'uom_code', name: 'uom_code' },
            { data: 'purchasing_group_code', name: 'purchasing_group_code' },
            { data: 'storage_location_code', name: 'storage_location_code' },
            { data: 'material_group_code', name: 'material_group_code' },
            { data: 'profit_center_code', name: 'profit_center_code' },
            {
                data: null, 
                class: 'text-center',
                width: '5%',
                'bSortable': false, 
                'bSearchable': false, 
                render: function(data) {
                    console.log(data)
                    let html = ''
                    const show_url = '{{ url('admin/material/') }}' +'/'+data.id
                    const edit_url = '{{ url('admin/material/') }}' +'/'+data.id + '/edit'

                    @can('material_show')
                    html += `<a class="btn btn-xs btn-primary" href="${show_url}">
                            {{ trans('global.view') }}
                        </a>`
                    @endcan

                    @can('material_edit')
                    html += `<a class="btn btn-xs btn-info" href="${edit_url}">
                            {{ trans('global.edit') }}
                        </a>`
                    @endcan

                    @can('material_delete')
                    html += `<button class="btn btn-xs btn-danger" onclick="deleteConfirmation(${data.id})">Delete</button>`
                    @endcan

                    return html
                }
            }
        ],
    });

    function deleteConfirmation(id) {
        swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            console.log(e)
            if (e == true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/admin/material/destroy/')"+id ,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }
</script>
@endsection