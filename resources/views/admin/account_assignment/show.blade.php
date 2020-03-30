@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.account_assignment.title_singular') }}</a></li>
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
                                {{ trans('cruds.account_assignment.fields.id') }}
                            </th>
                            <td>
                                {{ $account_assignment->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.account_assignment.fields.code') }}
                            </th>
                            <td>
                                {{ $account_assignment->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.account_assignment.fields.description') }}
                            </th>
                            <td>
                                {{ $account_assignment->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.account_assignment.fields.created_at') }}
                            </th>
                            <td>
                                {{ $account_assignment->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.account_assignment.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $account_assignment->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection