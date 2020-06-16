@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Show</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Repeat Order</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('vendor.quotation-approve-repeat') }}" method="post">
                    @csrf
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td>{{ trans('cruds.quotation.fields.id') }}</td>
                                <td>{{ $quotation->id }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.quotation.fields.po_no') }}</td>
                                <td>{{ $quotation->po_no }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.quotation.fields.status') }}</td>
                                <td>{{ $quotation->status == 0 ? 'PO repeat' : ($quotation->status == 1 ? 'Online' : 'Penunjukkan Langsung') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Material Code</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotation->detail as $det)
                                @if ($det->material)
                                    <tr>
                                        <td>{{ $det->material }} - {{ $det->materialDetail->description }}</td>
                                        <td>{{ number_format($det->qty, 0, '', '.') }}</td>
                                        <td>{{ $det->unit }}</td>
                                        <td>{{ number_format($det->vendor_price, 0, '', '.') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    @if( $quotation->approval_status == 1)
                    <div class="form-actions">
                        <input type="hidden" name="id" value="{{ $quotation->id }}">
                        <input type="hidden" name="po_no" value="{{ $quotation->po_no }}">
                        <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> {{ trans('global.approve') }}</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection