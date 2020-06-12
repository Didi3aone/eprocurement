@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Repeat</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.quotation.winner') }}" method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                        <td>{{ $model->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                        <td>{{ $model->po_no }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            @csrf
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Vendor Code</th>
                                        <th>Vendor Name</th>
                                        <th>Material Code</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($model->detail as $det)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="id[]" id="check_{{ $det->id }}" value="{{ $det->id }}">
                                            <label for="check_{{ $det->id }}"></label>
                                        </td>
                                        <td>{{ isset($det->vendor) ? $det->vendor->code : '' }}</td>
                                        <td>{{ isset($det->vendor) ? $det->vendor->name : '' }}</td>
                                        <td>{{ $det->material }} - {{ $det->materialDetail->description }}</td>
                                        <td>{{ number_format($det->qty, 0, '', '.') }}</td>
                                        <td>{{ number_format($det->unit, 0, '', '.') }}</td>
                                        <td>{{ number_format($det->vendor_price, 0, '', '.') }}</td>
                                        <td>
                                            <a href="{{ route('admin.quotation.remove-vendor', [$model->id, $det->vendor_id]) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Remove</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12">
                            <div class="form-actions">
                                {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
                                <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> {{ 'Choose to winner' }}</button>
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