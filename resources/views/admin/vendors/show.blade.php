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
                                {{ trans('cruds.vendors.fields.name') }}
                            </th>
                            <td>
                                {{ $vendors->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.email') }}
                            </th>
                            <td>
                                {{ $vendors->email }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                terms_of_payment
                            </th>
                            <td>
                                {{ $vendors->terms_of_payment }}
                            </td>
                        </tr>
                        {{--
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.npwp') }}
                            </th>
                            <td>
                                {{ $vendors->npwp }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.address') }}
                            </th>
                            <td>
                                {{ $vendors->address }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.company_type') }}
                            </th>
                            <td>
                                {{ $vendors->company_type }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.company_from') }}
                            </th>
                            <td>
                                {{ $vendors->company_from }}
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
                        --}}
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.created_at') }}
                            </th>
                            <td>
                                {{ $vendors->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $vendors->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection