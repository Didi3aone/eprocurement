@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Repeat Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Repeat</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.quotation-approve-repeat') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="quotation_id" value="{{ $model->id }}">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                        <td>{{ $model->po_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.doc_type') }}</th>
                                        <td>{{ $model->doc_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.vendor') }}</th>
                                        <td>{{ $model->getVendor ? $model->getVendor->code." - ".$model->getVendor->name : ''  }}</td>
                                        <input type="hidden" name="vendor_code" value="{{ $model->getVendor ? $model->getVendor->code : '' }}">
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        @if ($model->approval_status != 1)
                                        <th>&nbsp;</th>
                                        @endif
                                        <th>Material Code</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Plant Code</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($model->detail as $det)
                                        @if ($det->material)
                                            <tr>
                                                @if ($model->approval_status != 1)
                                                <td>
                                                    <input type="checkbox" name="id[]" id="check_{{ $det->id }}" value="{{ $det->id }}">
                                                    <label for="check_{{ $det->id }}"></label>
                                                </td>
                                                @endif
                                                <td>{{ $det->material }} - {{ $det->materialDetail->description }}</td>
                                                <td>{{ number_format($det->qty, 0, '', '.') }}</td>
                                                <td>{{ $det->unit }}</td>
                                                <td>{{ number_format($det->vendor_price, 0, '', '.') }}</td>
                                                <td>{{ $det->plant_code }}</td>
                                                <td>
                                                    @if ($model->approval_status != 1)
                                                    <a href="{{ route('admin.quotation.remove-vendor', [$model->id, $det->vendor_id]) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Remove</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- @if ($model->approval_status != 1) --}}
                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12">
                            <div class="form-actions">
                                {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
                                {{-- <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> Approve</button> --}}
                                <a href="{{ route('admin.quotation.repeat') }}" class="btn btn-info">Back</a>
                                {{-- <button type="button" class="btn btn-inverse">Cancel</button> --}}
                                <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection