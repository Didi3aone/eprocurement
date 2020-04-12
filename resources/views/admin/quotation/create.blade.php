@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.quotation.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.quotation.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ $gl->code ?? old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.account') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('account') ? 'is-invalid' : '' }}" name="account" value="{{ $gl->account ?? old('account', '') }}"> 
                        @if($errors->has('account'))
                            <div class="invalid-feedback">
                                {{ $errors->first('account') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.balance') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('balance') ? 'is-invalid' : '' }}" name="balance" value="{{ $gl->balance ?? old('balance', '') }}"> 
                        @if($errors->has('balance'))
                            <div class="invalid-feedback">
                                {{ $errors->first('balance') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.short_text') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('short_text') ? 'is-invalid' : '' }}" name="short_text" value="{{ $gl->short_text ?? old('short_text', '') }}"> 
                        @if($errors->has('short_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('short_text') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.acct_long_text') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('acct_long_text') ? 'is-invalid' : '' }}" name="acct_long_text" value="{{ $gl->acct_long_text ?? old('acct_long_text', '') }}"> 
                        @if($errors->has('acct_long_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('acct_long_text') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.long_text') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('long_text') ? 'is-invalid' : '' }}" name="long_text" value="{{ $gl->long_text ?? old('long_text', '') }}"> 
                        @if($errors->has('long_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('long_text') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.quotation.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection