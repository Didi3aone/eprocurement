@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.rfq.title') }}</a></li>
            <li class="breadcrumb-item active">Create Detail</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.rfq-save-detail") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_document') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('purchasing_document') ? 'is-invalid' : '' }}" name="purchasing_document" value=""> 
                        @if($errors->has('purchasing_document'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_document') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.company_code') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('company_code') ? 'is-invalid' : '' }}" name="company_code" value=""> 
                        @if($errors->has('company_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_doc_category') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('purchasing_doc_category') ? 'is-invalid' : '' }}" name="purchasing_doc_category" value=""> 
                        @if($errors->has('purchasing_doc_category'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_doc_category') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_doc_type') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('purchasing_doc_type') ? 'is-invalid' : '' }}" name="purchasing_doc_type" value="{{ $code }}"> 
                        @if($errors->has('purchasing_doc_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_doc_type') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.status') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" value=""> 
                        @if($errors->has('status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.deletion_indicator') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('deletion_indicator') ? 'is-invalid' : '' }}" name="deletion_indicator" value=""> 
                        @if($errors->has('deletion_indicator'))
                            <div class="invalid-feedback">
                                {{ $errors->first('deletion_indicator') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.vendor') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('vendor') ? 'is-invalid' : '' }}" name="vendor" value=""> 
                        @if($errors->has('vendor'))
                            <div class="invalid-feedback">
                                {{ $errors->first('vendor') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.language_key') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('language_key') ? 'is-invalid' : '' }}" name="language_key" value=""> 
                        @if($errors->has('language_key'))
                            <div class="invalid-feedback">
                                {{ $errors->first('language_key') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.payment_terms') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('payment_terms') ? 'is-invalid' : '' }}" name="payment_terms" value=""> 
                        @if($errors->has('payment_terms'))
                            <div class="invalid-feedback">
                                {{ $errors->first('payment_terms') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.payment_in1') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('payment_in1') ? 'is-invalid' : '' }}" name="payment_in1" value=""> 
                        @if($errors->has('payment_in1'))
                            <div class="invalid-feedback">
                                {{ $errors->first('payment_in1') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.payment_in2') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('payment_in2') ? 'is-invalid' : '' }}" name="payment_in2" value=""> 
                        @if($errors->has('payment_in2'))
                            <div class="invalid-feedback">
                                {{ $errors->first('payment_in2') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.payment_in3') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('payment_in3') ? 'is-invalid' : '' }}" name="payment_in3" value=""> 
                        @if($errors->has('payment_in3'))
                            <div class="invalid-feedback">
                                {{ $errors->first('payment_in3') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.disc_percent1') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('disc_percent1') ? 'is-invalid' : '' }}" name="disc_percent1" value=""> 
                        @if($errors->has('disc_percent1'))
                            <div class="invalid-feedback">
                                {{ $errors->first('disc_percent1') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.disc_percent2') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('disc_percent2') ? 'is-invalid' : '' }}" name="disc_percent2" value=""> 
                        @if($errors->has('disc_percent2'))
                            <div class="invalid-feedback">
                                {{ $errors->first('disc_percent2') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_org') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('purchasing_org') ? 'is-invalid' : '' }}" name="purchasing_org" value=""> 
                        @if($errors->has('purchasing_org'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_org') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_group') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('purchasing_group') ? 'is-invalid' : '' }}" name="purchasing_group" value=""> 
                        @if($errors->has('purchasing_group'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_group') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.currency') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency" value=""> 
                        @if($errors->has('currency'))
                            <div class="invalid-feedback">
                                {{ $errors->first('currency') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.exchange_rate') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('exchange_rate') ? 'is-invalid' : '' }}" name="exchange_rate" value=""> 
                        @if($errors->has('exchange_rate'))
                            <div class="invalid-feedback">
                                {{ $errors->first('exchange_rate') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.exchange_rate_fixed') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('exchange_rate_fixed') ? 'is-invalid' : '' }}" name="exchange_rate_fixed" value=""> 
                        @if($errors->has('exchange_rate_fixed'))
                            <div class="invalid-feedback">
                                {{ $errors->first('exchange_rate_fixed') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.document_date') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('document_date') ? 'is-invalid' : '' }}" name="document_date" value=""> 
                        @if($errors->has('document_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('document_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.quotation_deadline') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('quotation_deadline') ? 'is-invalid' : '' }}" name="quotation_deadline" value=""> 
                        @if($errors->has('quotation_deadline'))
                            <div class="invalid-feedback">
                                {{ $errors->first('quotation_deadline') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.created_by') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by" value=""> 
                        @if($errors->has('created_by'))
                            <div class="invalid-feedback">
                                {{ $errors->first('created_by') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.last_changed') }}</label>
                        <input type="datetime-local" class="form-control form-control-line {{ $errors->has('last_changed') ? 'is-invalid' : '' }}" name="last_changed" value=""> 
                        @if($errors->has('last_changed'))
                            <div class="invalid-feedback">
                                {{ $errors->first('last_changed') }}
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