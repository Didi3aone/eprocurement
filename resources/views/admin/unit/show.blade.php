@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.unit.title_singular') }}</a></li>
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
                                {{ trans('cruds.unit.fields.id') }}
                            </th>
                            <td>
                                {{ $unit->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.unit.fields.company_id') }}
                            </th>
                            <td>
                                {{ isset($unit->company) ? $unit->company->name : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.unit.fields.code') }}
                            </th>
                            <td>
                                {{ $unit->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.unit.fields.description') }}
                            </th>
                            <td>
                                {{ $unit->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.unit.fields.created_at') }}
                            </th>
                            <td>
                                {{ $unit->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.unit.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $unit->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection