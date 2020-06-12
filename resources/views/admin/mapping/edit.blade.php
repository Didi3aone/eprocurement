@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User Mapping</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route("admin.mapping.update", $model->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="nik">{{ trans('cruds.user-mapping.fields.nik') }}</label>
                        <select class="form-control select2" name="nik" id="nik">
                            @foreach ($users as $user)
                                <option value="{{ $user->nik }}"{{ $user->nik == $model->nik ? ' selected' : '' }}>{{ $user->nik }} - {{ $user->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('nik'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nik') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="plant">{{ trans('cruds.user-mapping.fields.plant') }}</label>
                        <select class="form-control select2" name="plant" id="plant">
                            @foreach ($plants as $plant)
                                <option value="{{ $plant->code }}"{{ $plant->code == $model->plant ? ' selected' : '' }}>{{ $plant->code }} - {{ $plant->description }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('plant'))
                            <div class="invalid-feedback">
                                {{ $errors->first('plant') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.mapping.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection