@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Ship To</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.ship-to.update",$shipTo->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>PT</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $shipTo->name) }}"> 
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('alamat') ? 'is-invalid' : '' }}" name="alamat" value="{{ old('alamat', $shipTo->alamat) }}"> 
                        @if($errors->has('alamat'))
                            <div class="invalid-feedback">
                                {{ $errors->first('alamat') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" id="save"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.material_type.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection