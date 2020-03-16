@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.gl.title') }}</a></li>
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
                                {{ trans('cruds.gl.fields.id') }}
                            </th>
                            <td>
                                {{ $gl->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.gl.fields.code') }}
                            </th>
                            <td>
                                {{ $gl->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.gl.fields.account') }}
                            </th>
                            <td>
                                {{ $gl->account }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.gl.fields.balance') }}
                            </th>
                            <td>
                                {{ $gl->balance }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.gl.fields.short_text') }}
                            </th>
                            <td>
                                {{ $gl->short_text }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.gl.fields.acct_long_text') }}
                            </th>
                            <td>
                                {{ $gl->acct_long_text }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.gl.fields.long_text') }}
                            </th>
                            <td>
                                {{ $gl->long_text }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection