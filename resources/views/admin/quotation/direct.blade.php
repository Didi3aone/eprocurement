@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Repeat Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Direct Order</a></li>
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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.upload_file') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.status') }}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotation as $key => $val)
                                        <tr data-entry-id="{{ $val->id }}">
                                            <td>{{ $val->id ?? '' }}</td>
                                            <td>{{ $val->po_no ?? '' }}</td>
                                            <td>
                                                @php $files = explode(', ', $val->upload_file); @endphp
                                                @foreach ($files as $file)
                                                <a href="{{ asset('uploads/direct/' . $file) }}">{{ $file }}</a>
                                                @endforeach
                                            </td>
                                            <td>{{ $val->approval_status == 1 ? 'Approved' : 'Unapproved' }}</td>
                                            <td>
                                                <a class="btn btn-xs btn-warning" href="{{ route('admin.quotation-show-direct', $val->id) }}">
                                                    <i class="fa fa-tv"></i> Show Materials
                                                </a>
                                                @if ($val->approval_status != 1)
                                                @can('quotation_edit')
                                                    <a class="btn btn-xs btn-info" href="{{ route('admin.quotation-edit-repeat', $val->id) }}">
                                                        <i class="fa fa-edit"></i> {{ trans('global.edit') }}
                                                    </a>
                                                @endcan
                                                @endif
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