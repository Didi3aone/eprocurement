@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.cost.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.cost.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.area') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('area') ? 'is-invalid' : '' }}" name="area" value="{{ $cost->area ?? old('area', '') }}"> 
                        @if($errors->has('area'))
                            <div class="invalid-feedback">
                                {{ $errors->first('area') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.cost_center') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('cost_center') ? 'is-invalid' : '' }}" name="cost_center" value="{{ $cost->cost_center ?? old('cost_center', '') }}"> 
                        @if($errors->has('cost_center'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cost_center') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.company_code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('company_code') ? 'is-invalid' : '' }}" name="company_code" value="{{ $cost->company_code ?? old('company_code', '') }}"> 
                        @if($errors->has('company_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.profit_center') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('profit_center') ? 'is-invalid' : '' }}" name="profit_center" value="{{ $cost->profit_center ?? old('profit_center', '') }}"> 
                        @if($errors->has('profit_center'))
                            <div class="invalid-feedback">
                                {{ $errors->first('profit_center') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.hierarchy_area') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('hierarchy_area') ? 'is-invalid' : '' }}" name="hierarchy_area" value="{{ $cost->hierarchy_area ?? old('hierarchy_area', '') }}"> 
                        @if($errors->has('hierarchy_area'))
                            <div class="invalid-feedback">
                                {{ $errors->first('hierarchy_area') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.name') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $cost->name ?? old('name', '') }}"> 
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.description') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" value="{{ $cost->description ?? old('description', '') }}"> 
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.cost.fields.short_text') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('short_text') ? 'is-invalid' : '' }}" name="short_text" value="{{ $cost->short_text ?? old('short_text', '') }}"> 
                        @if($errors->has('short_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('short_text') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.cost.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection