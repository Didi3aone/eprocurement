@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Material</a></li>
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
                                {{ trans('cruds.masterMaterial.fields.id') }}
                            </th>
                            <td>
                                {{ $material->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.code') }}
                            </th>
                            <td>
                                {{ $material->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.name') }}
                            </th>
                            <td>
                                {{ $material->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.departemen_peminta') }}
                            </th>
                            <td>
                                {{ isset($material->departments->name) ? $material->departments->name : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.status') }}
                            </th>
                            <td>
                                {{ $material->status == 1 ? 'Active' : 'Inactive' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection