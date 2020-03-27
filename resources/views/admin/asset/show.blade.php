@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.asset.title_singular') }}</a></li>
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
                                {{ trans('cruds.asset.fields.id') }}
                            </th>
                            <td>
                                {{ $asset->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.asset.fields.company_id') }}
                            </th>
                            <td>
                                {{ isset($asset->company) ? $asset->company->name : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.asset.fields.code') }}
                            </th>
                            <td>
                                {{ $asset->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.asset.fields.description') }}
                            </th>
                            <td>
                                {{ $asset->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.asset.fields.created_at') }}
                            </th>
                            <td>
                                {{ $asset->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.asset.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $asset->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection