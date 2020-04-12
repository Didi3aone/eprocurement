@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.quotation.title') }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" method="POST" action="{{ route("admin.quotation.update", [$gl->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.request_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('request_no') ? 'is-invalid' : '' }}" name="request_no" value="{{ old('request_no', $pr->request_no) }}" readonly> 
                        @if($errors->has('request_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('request_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.purchasing_leadtime') }}</label>
                        <div class="row">
                            <div class="col-lg-3">
                                <select name="leadtime_type" id="leadtime_type" class="form-control">
                                    <option value="0">Tanggal</option>
                                    <option value="1">Jumlah Hari</option>
                                </select>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="purchasing_leadtime" class="form-control form-control-line {{ $errors->has('purchasing_leadtime') ? 'is-invalid' : '' }}" name="purchasing_leadtime" value="{{ old('purchasing_leadtime', 0) }}"> 
                                @if($errors->has('purchasing_leadtime'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('purchasing_leadtime') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.target_price') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('target_price') ? 'is-invalid' : '' }}" name="target_price" value="{{ old('target_price', 0) }}"> 
                        @if($errors->has('target_price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('target_price') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.expired_date') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('expired_date') ? 'is-invalid' : '' }}" name="expired_date" value="{{ old('expired_date', date('Y-m-d', strtotime('+3 months', time()))) }}"> 
                        @if($errors->has('expired_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('expired_date') }}
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