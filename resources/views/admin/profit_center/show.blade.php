@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.profit_center.title') }}</a></li>
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
                                {{ trans('cruds.profit_center.fields.id') }}
                            </th>
                            <td>
                                {{ $profitCenter->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.profit_center.fields.code') }}
                            </th>
                            <td>
                                {{ $profitCenter->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.profit_center.fields.name') }}
                            </th>
                            <td>
                                {{ $profitCenter->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.profit_center.fields.small_description') }}
                            </th>
                            <td>
                                {{ $profitCenter->small_description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.profit_center.fields.description') }}
                            </th>
                            <td>
                                {{ $profitCenter->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.profit_center.fields.created_at') }}
                            </th>
                            <td>
                                {{ $profitCenter->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.profit_center.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $profitCenter->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection