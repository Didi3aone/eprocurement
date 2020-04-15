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
                            <td>{{ trans('cruds.quotation.fields.id') }}</td>
                            <td>{{ $quotation->id }}</td>
                        </tr>
                            <td>{{ trans('cruds.quotation.fields.po_no') }}</td>
                            <td>{{ $quotation->po_no }}</td>
                        </tr>
                        </tr>
                            <td>{{ trans('cruds.quotation.fields.vendor_id') }}</td>
                            <td>{{ isset($quotation->vendor) ? $quotation->vendor->name . ' - ' . $quotation->vendor->email : '' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.leadtime_type') }}</td>
                            <td>{{ $quotation->leadtime_type }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</td>
                            <td>{{ $quotation->purchasing_leadtime }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.target_price') }}</td>
                            <td>{{ $quotation->target_price }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.expired_date') }}</td>
                            <td>{{ $quotation->expired_date }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.vendor_leadtime') }}</td>
                            <td>{{ $quotation->vendor_leadtime }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.vendor_price') }}</td>
                            <td>{{ $quotation->vendor_price }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.created_at') }}</td>
                            <td>{{ $quotation->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.updated_at') }}</td>
                            <td>{{ $quotation->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-actions">
                    <a href="{{ route('vendor.quotation-edit', $quotation->id) }}" class="btn btn-inverse">Next</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection