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
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.id') }}
                            </th>
                            <td>
                                {{ $quotation->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.po_no') }}
                            </th>
                            <td>
                                {{ $quotation->po_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.vendor_id') }}
                            </th>
                            <td>
                                {{ isset($quotation->vendor_id) ? $quotation->vendor->name . ' - ' . $quotation->vendor->email : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.upload_file') }}
                            </th>
                            <td>
                                {{ $quotation->upload_file }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.purchasing_leadtime') }}
                            </th>
                            <td>
                                {{ $quotation->purchasing_leadtime }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.target_price') }}
                            </th>
                            <td>
                                {{ $quotation->target_price }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.vendor_leadtime') }}
                            </th>
                            <td>
                                {{ $quotation->vendor_leadtime }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.vendor_price') }}
                            </th>
                            <td>
                                {{ $quotation->vendor_price }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.expired_date') }}
                            </th>
                            <td>
                                {{ $quotation->expired_date }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.created_at') }}
                            </th>
                            <td>
                                {{ $quotation->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.quotation.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $quotation->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection