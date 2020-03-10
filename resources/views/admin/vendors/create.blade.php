@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendors</a></li>
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
                        <label>{{ trans('cruds.vendors.fields.no_vendor') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('no_vendor') ? 'is-invalid' : '' }}" name="no_vendor" value="{{ old('no_vendor', '') }}"> 
                        @if($errors->has('no_vendor'))
                            <div class="invalid-feedback">
                                {{ $errors->first('no_vendor') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.nama_vendor') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('nama_vendor') ? 'is-invalid' : '' }}" name="nama_vendor" value="{{ old('nama_vendor', '') }}"> 
                        @if($errors->has('nama_vendor'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nama_vendor') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.vendors.fields.departemen_peminta') }}</label>
                        <select class="form-control select2 {{ $errors->has('departemen_peminta') ? 'is-invalid' : '' }}" name="departemen_peminta" id="departemen_peminta" required>
                            @foreach($departments as $id => $dept)
                                <option value="{{ $dept->id }}" {{ in_array($dept->id, old('departemen_peminta', [])) ? 'selected' : '' }}>{{ $dept->name }}</option>
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
                        <input type="text" class="form-control form-control-line {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" value="{{ old('status', '') }}"> 
                        @if($errors->has('status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
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