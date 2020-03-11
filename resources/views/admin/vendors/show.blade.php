@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
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
                                {{ trans('cruds.vendors.fields.id') }}
                            </th>
                            <td>
                                {{ $vendors->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.code') }}
                            </th>
                            <td>
                                {{ $vendors->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.name') }}
                            </th>
                            <td>
                                {{ $vendors->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.departemen_peminta') }}
                            </th>
                            <td>
                                {{ isset($vendors->departments->name) ? $vendors->departments->name : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.status') }}
                            </th>
                            <td>
                                {{ $vendors->status == 1 ? 'Active' : 'Inactive' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection