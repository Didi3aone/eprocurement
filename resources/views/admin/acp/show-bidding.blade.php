@extends('layouts.admin')
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
                <form action="{{ route('admin.quotation.winner') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                        <td>{{ $quotation->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                        <td>{{ $quotation->po_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</th>
                                        <td>{{ $quotation->purchasing_leadtime }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.target_price') }}</th>
                                        <td>{{ number_format($quotation->target_price, 0, '', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.expired_date') }}</th>
                                        <td>{{ $quotation->expired_date }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Vendor Name</th>
                                        <th>Leadtime</th>
                                        <th>Vendor Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotation->detail as $det)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="id[]" id="check_{{ $det->id }}" value="{{ $det->id }}">
                                            <label for="check_{{ $det->id }}"></label>
                                        </td>
                                        <td>{{ $det->vendor->name }}</td>
                                        <td>{{ $det->vendor_leadtime }}</td>
                                        <td>{{ number_format($det->vendor_price, 0, '', '.') }}</td>
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