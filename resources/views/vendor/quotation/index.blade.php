@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Quotation</a></li>
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
{{-- @can('quotation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.quotation.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.quotation.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.quotation.import') }}
            </button>
        </div>
    </div>
@endcan --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                <th>{{ trans('cruds.quotation.fields.model') }}</th>
                                <th>{{ trans('cruds.quotation.fields.status') }}</th>
                                <th>{{ trans('cruds.quotation.fields.leadtime_type') }}</th>
                                <th>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</th>
                                <th>{{ trans('cruds.quotation.fields.expired_date') }}</th>
                                <th>{{ trans('cruds.quotation.fields.target_price') }}</th>
                                <th>{{ trans('cruds.quotation.fields.vendor_leadtime') }}</th>
                                <th>{{ trans('cruds.quotation.fields.vendor_price') }}</th>
                                <th>{{ trans('cruds.quotation.fields.qty') }}</th>
                                <th>{{ trans('cruds.quotation.fields.bidding_count') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation as $key => $val)
                                <tr data-entry-id="{{ $val->id }}">
                                    <td>{{ $val->id ?? '' }}</td>
                                    <td>{{ $val->po_no ?? '' }}</td>
                                    <td>{{ $val->model == 1 ? 'Open' : 'Close' }}</td>
                                    <td>{{ $val->status == 0 ? 'PO repeat' : ($val->status == 1 ? 'Online' : 'Penunjukkan Langsung') }}</td>
                                    <td>{{ $val->leadtime_type == 0 ? 'Date' : 'Day Count' }}</td>
                                    <td>{{ $val->purchasing_leadtime ?? '' }}</td>
                                    <td>
                                        @php $is_expired = '#67757c' @endphp
                                        @if (time() > strtotime($val->expired_date))
                                            @php $is_expired = 'red'; @endphp
                                        @elseif (time() > strtotime('-2 days', strtotime($val->expired_date)) && time() <= strtotime($val->expired_date))
                                            @php $is_expired = 'orange'; @endphp
                                        @endif
                                        <span style="color: {{ $is_expired }}">{{ $val->expired_date ?? '' }}</span>
                                    </td>
                                    <td>{{ number_format($val->target_price, 0, '', '.') ?? '' }}</td>
                                    <td>{{ $val->vendor_leadtime ?? '' }}</td>
                                    <td>{{ number_format($val->vendor_price, 0, '', '.') ?? '' }}</td>
                                    <td>{{ number_format($val->qty, 0, '', '.') }}</td>
                                    <td>{{ $val->count }}</td>
                                    <td>
                                        {{-- @if (time() <= strtotime($val->expired_date)) --}}
                                        <a class="btn btn-xs btn-info" href="{{ route('vendor.quotation-detail', $val->id) }}">
                                            {{ 'View' }}
                                        </a>
                                        {{-- @endif --}}
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