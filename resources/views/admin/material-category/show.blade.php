@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.material-category.title_singular') }}</a></li>
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
                                {{ trans('cruds.material-category.fields.id') }}
                            </th>
                            <td>
                                {{ $material_category->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material-category.fields.code') }}
                            </th>
                            <td>
                                {{ $material_category->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material-category.fields.description') }}
                            </th>
                            <td>
                                {{ $material_category->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material-category.fields.created_at') }}
                            </th>
                            <td>
                                {{ $material_category->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.material-category.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $material_category->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection