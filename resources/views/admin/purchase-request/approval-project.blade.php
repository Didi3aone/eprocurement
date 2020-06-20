@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.profit_center.title') }}</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="dispcay nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.profit_center.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profit_center.fields.code') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profit_center.fields.name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profit_center.fields.small_description') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profit_center.fields.description') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prProject as $key => $proj)
                                <tr data-entry-id="{{ $proj->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $proj->id ?? '' }}</td>
                                    <td>{{ $proj->code ?? '' }}</td>
                                    <td>{{ $proj->name ?? '' }}</td>
                                    <td>{{ $proj->small_description ?? '' }}</td>
                                    <td>{{ $proj->description ?? '' }}</td>
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