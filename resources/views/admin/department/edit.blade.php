@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Department</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Department</h4>
                <form class="form-material m-t-40" action="{{ route("admin.department.update", $department->id) }}" enctype="multipart/form-data" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.masterCategoryDept.fields.id') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ $department->code ?? old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterCategoryDept.fields.name') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $department->name ??  old('name', '') }}"> 
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterDepartment.fields.company_id') }}</label>
                        <select class="form-control select2 {{ $errors->has('company_id') ? 'is-invalid' : '' }}" name="company_id" id="company_id" required>
                            @foreach($company as $id => $cmp)
                                <option value="{{ $cmp->id }}" {{ $department->company_id ? "selected" : in_array($cmp->id, old('company_id', [])) ? 'selected' : '' }}>{{ $cmp->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('company_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterDepartment.fields.status') }}</label>
                        <div class="">
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-active" type="radio" value="active"
                                    name="status" @if($department->status == "active" )  checked @endif>
                                <label class="form-check-label" for="inline-radio-active">{{ trans('cruds.masterDepartment.fields.status_active') }}</label>
                            </div>
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-non-active" type="radio" value="inactive"
                                    name="status" @if($department->status == "inactive" )  checked @endif>
                                <label class="form-check-label" for="inline-radio-non-active">{{ trans('cruds.masterDepartment.fields.status_inactive') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterDepartment.fields.category_id') }}</label>
                        <select class="form-control select2 {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                            @foreach($category as $id => $cat)
                                <option value="{{ $cat->id }}" {{ $department->category_id == $cat->id ? "selected" : in_array($cat->id, old('category_id', [])) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('category_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <button type="button" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection