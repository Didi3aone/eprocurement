@extends('layouts.admin')
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
                <form action="{{ route('admin.quotation.to-winner') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive m-t-40">
                                <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.vendor_id') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.leadtime_type') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.target_price') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.expired_date') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.vendor_leadtime') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.vendor_price') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.qty') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quotation as $key => $val)
                                            <tr data-entry-id="{{ $val->id }}">
                                                <input type="hidden" name="vendor_id[]" value="{{ $val->vendor_id }}">
                                                <input type="hidden" name="id[]" value="{{ $val->id }}">
                                                <input type="hidden" name="po_no[]" value="{{ $val->quotation->po_no }}">
                                                <input type="hidden" name="vendor_price[]" value="{{ $val->quotation->vendor_price }}">
                                                <td>{{ $val->id ?? '' }}</td>
                                                <td>{{ $val->quotation->po_no ?? '' }}</td>
                                                <td>{{ isset($val->vendor_id) ? $val->vendor->name . ' - ' . $val->vendor->email : '' }}</td>
                                                <td>{{ $val->quotation->leadtime_type == 0 ? 'Date' : 'Day Count' }}</td>
                                                <td>{{ $val->quotation->purchasing_leadtime ?? '' }}</td>
                                                <td>{{ number_format($val->quotation->target_price, 0, '', '.') ?? '' }}</td>
                                                <td>
                                                    @php $is_expired = '#67757c' @endphp
                                                    @if (time() > strtotime($val->quotation->expired_date))
                                                        @php $is_expired = 'red'; @endphp
                                                    @elseif (time() > strtotime('-2 days', strtotime($val->quotation->expired_date)) && time() <= strtotime($val->quotation->expired_date))
                                                        @php $is_expired = 'orange'; @endphp
                                                    @endif
                                                    <span style="color: {{ $is_expired }}">{{ $val->quotation->expired_date ?? '' }}</span>
                                                </td>
                                                <td>{{ $val->vendor_leadtime ?? '' }}</td>
                                                <td>{{ number_format($val->vendor_price, 0, '', '.') ?? '' }}</td    >
                                                <td>
                                                    <input type="text" class="money form-control" name="qty[]" required>
                                                </td>        
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12">
                            <div class="form-actions">
                                {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
                                <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> {{ trans('global.to-winner') }}</button>
                                <button type="button" class="btn btn-inverse">Cancel</button>
                                <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$('.table').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});

$('.money').mask('#.##0', { reverse: true });
</script>
@endsection