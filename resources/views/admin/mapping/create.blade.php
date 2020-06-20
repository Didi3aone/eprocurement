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
                <form method="POST" action="{{ route("admin.mapping.store") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="nik">User ID</label>
                        <select class="form-control select2" name="user_id" id="user_id">
                            @foreach ($users as $prgs)
                                <option value="{{ $prgs->user_id }}">{{ $prgs->user_id }} - {{ $prgs->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="plant">Purchasing Group</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2" name="purchasing_group_code[]" multiple id="purchasing_group_code">
                            @foreach ($prg as $prgs)
                                <option value="{{ $prgs->code }}">{{ $prgs->code }} - {{ $prgs->description }}</option>
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