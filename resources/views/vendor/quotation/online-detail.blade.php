@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.quotation.title') }}</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.po_no') }}</td>
                            <td>{{ $quotation->po_no }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.leadtime_type') }}</td>
                            <td>{{ $quotation->leadtime_type == 0 ? 'Date' : 'Day Count' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</td>
                            <td>{{ $quotation->purchasing_leadtime }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.target_price') }}</td>
                            <td>{{ number_format($quotation->target_price, 0, '', '.') }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.expired_date') }}</td>
                            <td>{{ $quotation->expired_date }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-actions">
                    @if ($quotation->status != 0)
                        <a href="{{ route('vendor.quotation-bid', $quotation->id) }}" class="btn btn-primary">
                            <i class="fa fa-check"></i> Bid
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection