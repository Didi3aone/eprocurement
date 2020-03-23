@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.purchase-order.quotation') }}</a></li>
            <li class="breadcrumb-item active">Create Quotation</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.purchase-order.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.request_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('request_no') ? 'is-invalid' : '' }}" name="request_no" value="{{ $purchaseRequest->request_no ?? old('request_no', '') }}" readonly> 
                        @if($errors->has('request_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('request_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.notes') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" value="{{ $purchaseRequest->notes ?? old('notes', '') }}" readonly> 
                        @if($errors->has('notes'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notes') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.request_date') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('request_date') ? 'is-invalid' : '' }}" name="request_date" value="{{ $purchaseRequest->request_date ?? old('request_date', '') }}" readonly> 
                        @if($errors->has('request_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('request_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.total') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('total') ? 'is-invalid' : '' }}" name="total" value="{{ $purchaseRequest->total ?? old('total', '') }}" readonly> 
                        @if($errors->has('total'))
                            <div class="invalid-feedback">
                                {{ $errors->first('total') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.approval_status') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('approval_status') ? 'is-invalid' : '' }}" name="approval_status" value="{{ $purchaseRequest->approval_status ?? old('approval_status', '') }}" readonly> 
                        @if($errors->has('approval_status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('approval_status') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.vendor_id') }}</label>
                        <select class="form-control select2 {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id" id="vendor_id" required>
                            @foreach($vendors as $id => $v)
                                <option value="{{ $v->id }}" {{ old('vendor_id', '') ? 'selected' : '' }}>{{ $v->code }} - {{ $v->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.purchase-order.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection