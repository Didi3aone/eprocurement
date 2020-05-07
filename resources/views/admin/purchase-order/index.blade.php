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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.purchase-order.fields.id') }}</th>
                                <th>{{ trans('cruds.purchase-order.fields.request_no') }}</th>
                                <th>{{ trans('cruds.purchase-order.fields.po_date') }}</th>
                                {{-- <th>{{ trans('cruds.purchase-order.fields.vendor_id') }}</th> --}}
                                <th>{{ trans('cruds.purchase-order.fields.request_date') }}</th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($po as $key => $q)
                                <tr data-entry-id="{{ $q->id }}">
                                    <td>{{ $q->id ?? '' }}</td>
                                    <td>{{ $q->po_no }}</td>
                                    <td>{{ $q->po_date }}</td>
                                    {{-- <td>{{ !empty($q->vendor_id) ? $q->vendor->name . ' - ' . $q->vendor->email : '' }}</td> --}}
                                    <td>{{ $q->created_at ?? '' }}</td>
                                    <td>
                                        {{-- @can('purchase_order_approval')
                                            <a class="btn btn-xs btn-success" href="{{ route('admin.purchase-order-approval-po', $q->id) }}">
                                                {{ trans('cruds.purchase-order.approval') }}
                                            </a>
                                        @endcan --}}
                                        {{-- @can('purchase_request_show') --}}
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.purchase-order.show', $q->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        {{-- @endcan --}}

                                        {{-- @can('purchase_request_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.purchase-order.form', $q->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan --}}

                                        {{-- @can('purchase_request_delete')
                                            <form action="{{ route('admin.purchase-order.destroy', $q->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan --}}
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
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection