@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.purchase-order.title') }}</a></li>
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
@can('purchase_request_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.purchase-order.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.purchase-order.title_singular') }}
            </a>
        </div>
        {{-- <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.purchase-order.import') }}
            </button>
        </div> --}}
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
                                    {{ trans('cruds.purchase-order.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.request_no') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.bidding') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.request_date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.approval_status') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order.fields.status') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchaseOrders as $key => $po)
                                <tr data-entry-id="{{ $po->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $po->id ?? '' }}</td>
                                    <td>{{ isset($po->purchaseRequest) ? $po->purchaseRequest->request_no : '' }}</td>
                                    <td>{{ $po->bidding == 1 ? 'Bidding' : 'Quotation' }}</td>
                                    <td>{{ $po->request_date ?? '' }}</td>
                                    <td>{{ $po->approval_status ?? '' }}</td>
                                    <td>{{ $po->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        @can('purchase_request_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.purchase-order.show', $po->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('purchase_request_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.purchase-order.edit', $po->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('purchase_request_delete')
                                            <form action="{{ route('admin.purchase-order.destroy', $po->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
{{-- 
<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="modalImport" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImport">{{ trans('cruds.purchase-order.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.purchase-order.import') }}" method="post" enctype="multipart/form-data">
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
</div> --}}
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