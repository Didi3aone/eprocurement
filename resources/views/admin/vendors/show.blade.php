@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User Management</a></li>
            <li class="breadcrumb-item">Role</li>
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
                                {{ trans('cruds.role.fields.id') }}
                            </th>
                            <td>
                                {{ $role->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.title') }}
                            </th>
                            <td>
                                {{ $role->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.permissions') }}
                            </th>
                            <td>
                                @foreach($role->permissions as $key => $permissions)
                                    <span class="label label-info">{{ $permissions->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection