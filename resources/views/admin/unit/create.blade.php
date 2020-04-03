@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.unit.title_singular') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.unit.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.unit.fields.uom') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('uom') ? 'is-invalid' : '' }}" name="uom" value="{{ old('uom', '') }}"> 
                        @if($errors->has('uom'))
                            <div class="invalid-feedback">
                                {{ $errors->first('uom') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.unit.fields.iso') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('iso') ? 'is-invalid' : '' }}" name="iso" value="{{ old('iso', '') }}"> 
                        @if($errors->has('iso'))
                            <div class="invalid-feedback">
                                {{ $errors->first('iso') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.unit.fields.text') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text" value="{{ old('text', '') }}"> 
                        @if($errors->has('text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('text') }}
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