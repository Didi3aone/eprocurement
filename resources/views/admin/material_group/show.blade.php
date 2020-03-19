@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.material_group.title') }}</a></li>
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
                                {{ trans('cruds.material_group.fields.id') }}
                            </th>
                            <td>
                                {{ $materialGroup->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material_group.fields.language') }}
                            </th>
                            <td>
                                {{ $materialGroup->language }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material_group.fields.code') }}
                            </th>
                            <td>
                                {{ $materialGroup->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material_group.fields.description') }}
                            </th>
                            <td>
                                {{ $materialGroup->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material_group.fields.created_at') }}
                            </th>
                            <td>
                                {{ $materialGroup->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material_group.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $materialGroup->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection