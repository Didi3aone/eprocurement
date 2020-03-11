@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" method="POST" action="{{ route("admin.vendors.update", [$vendors->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ $vendors->code ?? old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
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
                        <label>{{ trans('cruds.vendors.fields.departemen_peminta') }}</label>
                        <select class="form-control select2 {{ $errors->has('departemen_peminta') ? 'is-invalid' : '' }}" name="departemen_peminta" id="departemen_peminta" required>
                            @foreach($departments as $id => $dept)
                                <option value="{{ $dept->id }}" {{ in_array($dept->id, old('departemen_peminta', [])) ? 'selected' : '' }}>{{ $dept->code }} - {{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('departemen_peminta'))
                            <div class="invalid-feedback">
                                {{ $errors->first('departemen_peminta') }}
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