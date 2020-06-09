@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.rfq.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.rfq.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq.fields.code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ $plant->code ?? old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq.fields.description') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" value="{{ $plant->description ?? old('description', '') }}"> 
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.rfq.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection