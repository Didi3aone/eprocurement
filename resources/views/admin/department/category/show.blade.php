@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Department</a></li>
            <li class="breadcrumb-item">Category</li>
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
                                {{ trans('cruds.masterCategoryDept.fields.id') }}
                            </th>
                            <td>
                                {{ $category->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterCategoryDept.fields.code') }}
                            </th>
                            <td>
                                {{ $category->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.masterCategoryDept.fields.name') }}
                            </th>
                            <td>
                                {{ $category->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection