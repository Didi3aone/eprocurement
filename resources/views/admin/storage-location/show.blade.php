@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.storage-location.title_singular') }}</a></li>
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
                                {{ trans('cruds.storage-location.fields.id') }}
                            </th>
                            <td>
                                {{ $storageLocation->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.storage-location.fields.code') }}
                            </th>
                            <td>
                                {{ $storageLocation->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.storage-location.fields.status') }}
                            </th>
                            <td>
                                {{ $storageLocation->status }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.storage-location.fields.description') }}
                            </th>
                            <td>
                                {{ $storageLocation->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.storage-location.fields.created_at') }}
                            </th>
                            <td>
                                {{ $storageLocation->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.storage-location.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $storageLocation->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection