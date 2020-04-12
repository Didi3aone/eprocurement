@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.vendors.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.name') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $vendors->name ?? old('name', '') }}"> 
                        @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.email') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ $vendors->email ?? old('email', '') }}"> 
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.company_type') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('company_type') ? 'is-invalid' : '' }}" name="company_type" value="{{ $vendors->company_type ?? old('company_type', '') }}"> 
                        @if($errors->has('company_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_type') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.company_from') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('company_from') ? 'is-invalid' : '' }}" name="company_from" value="{{ $vendors->company_from ?? old('company_from', '') }}"> 
                        @if($errors->has('company_from'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_from') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.address') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" value="{{ $vendors->address ?? old('address', '') }}"> 
                        @if($errors->has('address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.npwp') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('npwp') ? 'is-invalid' : '' }}" name="npwp" value="{{ $vendors->npwp ?? old('npwp', '') }}"> 
                        @if($errors->has('npwp'))
                            <div class="invalid-feedback">
                                {{ $errors->first('npwp') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.status') }}</label>
                        <div class="">
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-active" type="radio" value="1"
                                    name="status">
                                <label class="form-check-label" for="inline-radio-active">{{ trans('cruds.vendors.fields.status_active') }}</label>
                            </div>
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-non-active" type="radio" value="0"
                                    name="status" checked>
                                <label class="form-check-label" for="inline-radio-non-active">{{ trans('cruds.vendors.fields.status_inactive') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.vendors.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection