@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.approval_pr.title') }}</a></li>
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
                                {{ trans('cruds.approval_pr.fields.id') }}
                            </th>
                            <td>
                                {{ $approval_pr->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.approval_pr.fields.pr_no') }}
                            </th>
                            <td>
                                {{ $approval_pr->pr_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.approval_pr.fields.approval_position') }}
                            </th>
                            <td>
                                {{ $approval_pr->approval_position }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.approval_pr.fields.nik') }}
                            </th>
                            <td>
                                {{ $approval_pr->nik }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.approval_pr.fields.status') }}
                            </th>
                            <td>
                                {{ $approval_pr->status }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.approval_pr.fields.created_at') }}
                            </th>
                            <td>
                                {{ $approval_pr->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.approval_pr.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $approval_pr->updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection