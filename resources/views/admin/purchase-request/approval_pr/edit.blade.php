@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.approval_pr.title') }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" method="POST" action="{{ route("admin.approval_pr.update", [$approval_pr->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.approval_pr.fields.pr_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('pr_no') ? 'is-invalid' : '' }}" name="pr_no" value="{{ $approval_pr->pr_no ?? old('pr_no', '') }}"> 
                        @if($errors->has('pr_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('pr_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.approval_pr.fields.approval_position') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('approval_position') ? 'is-invalid' : '' }}" name="approval_position" value="{{ $approval_pr->approval_position ?? old('approval_position', '') }}"> 
                        @if($errors->has('approval_position'))
                            <div class="invalid-feedback">
                                {{ $errors->first('approval_position') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.approval_pr.fields.nik') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('nik') ? 'is-invalid' : '' }}" name="nik" value="{{ $approval_pr->nik ?? old('nik', '') }}"> 
                        @if($errors->has('nik'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nik') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.approval_pr.fields.status') }}</label>
                        <div class="">
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-active" type="radio" value="0"
                                    name="status">
                                <label class="form-check-label" for="inline-radio-active">{{ trans('cruds.approval_pr.fields.status_active') }}</label>
                            </div>
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-non-active" type="radio" value="inactive"
                                    name="status" checked>
                                <label class="form-check-label" for="inline-radio-non-active">{{ trans('cruds.approval_pr.fields.status_inactive') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.approval_pr.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection