@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.cost.title') }}</a></li>
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
                                Vendor
                            </th>
                            <td>
                                {{ $billing->getVendor['name'] }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Billing No.
                            </th>
                            <td>
                                {{ $billing->billing_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Faktur No.
                            </th>
                            <td>
                                {{ $billing->faktur_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Invoice No
                            </th>
                            <td>
                                {{ $billing->invoice_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.cost.fields.profit_center') }}
                            </th>
                            <td>
                                {{ $cost->profit_center }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.cost.fields.hierarchy_area') }}
                            </th>
                            <td>
                                {{ $cost->hierarchy_area }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.cost.fields.name') }}
                            </th>
                            <td>
                                {{ $cost->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.cost.fields.description') }}
                            </th>
                            <td>
                                {{ $cost->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.cost.fields.short_text') }}
                            </th>
                            <td>
                                {{ $cost->short_text }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection