@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.masterMaterial.title') }}</a></li>
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
                                {{ trans('cruds.masterMaterial.fields.small_description') }}
                            </th>
                            <td>
                                {{ $material->small_description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.description') }}
                            </th>
                            <td>
                                {{ $material->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.m_group_id') }}
                            </th>
                            <td>
                                {{ isset($material->material_group->code) ? $material->material_group->code . ' - ' . $material->material_group->description : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.m_type_id') }}
                            </th>
                            <td>
                                {{ isset($material->material_type->code) ? $material->material_type->code . ' - ' . $material->material_type->description : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.m_plant_id') }}
                            </th>
                            <td>
                                {{ isset($material->plant->code) ? $material->plant->code . ' - ' . $material->plant->description : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.m_purchasing_id') }}
                            </th>
                            <td>
                                {{ isset($material->purchasing_group->code) ? $material->purchasing_group->code . ' - ' . $material->purchasing_group->description : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterMaterial.fields.m_profit_id') }}
                            </th>
                            <td>
                                {{ isset($material->profit_center->code) ? $material->profit_center->code . ' - ' . $material->profit_center->description : '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection