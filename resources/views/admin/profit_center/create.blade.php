@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.profit_center.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.profit_center.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.profit_center.fields.code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ $profitCenter->code ?? old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.profit_center.fields.name') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $profitCenter->name ?? old('name', '') }}"> 
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.profit_center.fields.small_description') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('small_description') ? 'is-invalid' : '' }}" name="small_description" value="{{ $profitCenter->small_description ?? old('small_description', '') }}"> 
                        @if($errors->has('small_description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('small_description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.profit_center.fields.description') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" value="{{ $profitCenter->description ?? old('description', '') }}"> 
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.profit_center.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection