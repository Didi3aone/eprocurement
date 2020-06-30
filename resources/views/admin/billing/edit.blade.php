@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.billing.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form class="form-material m-t-40" action="{{ route("admin.billing-store") }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="title">HEADER</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.proposal_id') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('proposal_id') ? 'is-invalid' : '' }}" name="proposal_id" value="{{ $billing->proposal_id ?? old('proposal_id', '') }}" required> 
                            @if($errors->has('proposal_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('proposal_id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.document_no') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('document_no') ? 'is-invalid' : '' }}" name="document_no" value="{{ $billing->document_no ?? old('document_no', '') }}" required> 
                            @if($errors->has('document_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('document_no') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.title') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ $billing->title ?? old('title', '') }}" required> 
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.proposal_date') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('proposal_date') ? 'is-invalid' : '' }}" name="proposal_date" value="{{ $billing->proposal_date ?? old('proposal_date', '') }}" required> 
                            @if($errors->has('proposal_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('proposal_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.division') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('division') ? 'is-invalid' : '' }}" name="division" value="{{ $billing->division ?? old('division', '') }}" required> 
                            @if($errors->has('division'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('division') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.vendor_id') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id" value="{{ $billing->vendor_id ?? old('vendor_id', '') }}" required> 
                            @if($errors->has('vendor_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vendor_id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.region') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('region') ? 'is-invalid' : '' }}" name="region" value="{{ $billing->region ?? old('region', '') }}" required> 
                            @if($errors->has('region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('region') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.status') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" value="{{ $billing->status ?? old('status', '') }}" required> 
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Attachment</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.file_invoice') }}</label>
                            <input type="file" class="form-control form-control-line {{ $errors->has('file_invoice') ? 'is-invalid' : '' }}" name="file_invoice" value="{{ $billing->file_invoice ?? old('file_invoice', '') }}" required> 
                            @if($errors->has('file_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.file_principal') }}</label>
                            <input type="file" class="form-control form-control-line {{ $errors->has('file_principal') ? 'is-invalid' : '' }}" name="file_principal" value="{{ $billing->file_principal ?? old('file_principal', '') }}" required> 
                            @if($errors->has('file_principal'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file_principal') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.file_faktur') }}</label>
                            <input type="file" class="form-control form-control-line {{ $errors->has('file_faktur') ? 'is-invalid' : '' }}" name="file_faktur" value="{{ $billing->file_faktur ?? old('file_faktur', '') }}" required> 
                            @if($errors->has('file_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.file_ktp') }}</label>
                            <input type="file" class="form-control form-control-line {{ $errors->has('file_ktp') ? 'is-invalid' : '' }}" name="file_ktp" value="{{ $billing->file_ktp ?? old('file_ktp', '') }}" required> 
                            @if($errors->has('file_ktp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file_ktp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.file_claim') }}</label>
                            <input type="file" class="form-control form-control-line {{ $errors->has('file_claim') ? 'is-invalid' : '' }}" name="file_claim" value="{{ $billing->file_claim ?? old('file_claim', '') }}" required> 
                            @if($errors->has('file_claim'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file_claim') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.file_copy_faktur') }}</label>
                            <input type="file" class="form-control form-control-line {{ $errors->has('file_copy_faktur') ? 'is-invalid' : '' }}" name="file_copy_faktur" value="{{ $billing->file_copy_faktur ?? old('file_copy_faktur', '') }}" required> 
                            @if($errors->has('file_copy_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file_copy_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.file_skp') }}</label>
                            <input type="file" class="form-control form-control-line {{ $errors->has('file_skp') ? 'is-invalid' : '' }}" name="file_skp" value="{{ $billing->file_skp ?? old('file_skp', '') }}" required> 
                            @if($errors->has('file_skp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file_skp') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Informasi Klaim</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.claim_no') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('claim_no') ? 'is-invalid' : '' }}" name="claim_no" value="{{ $billing->claim_no ?? old('claim_no', '') }}" required> 
                            @if($errors->has('claim_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('claim_no') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.ktp_name') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('ktp_name') ? 'is-invalid' : '' }}" name="ktp_name" value="{{ $billing->ktp_name ?? old('ktp_name', '') }}"> 
                            @if($errors->has('ktp_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ktp_name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.npwp_name') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('npwp_name') ? 'is-invalid' : '' }}" name="npwp_name" value="{{ $billing->npwp_name ?? old('npwp_name', '') }}" required> 
                            @if($errors->has('npwp_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('npwp_name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.no_faktur') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_faktur') ? 'is-invalid' : '' }}" name="no_faktur" value="{{ $billing->no_faktur ?? old('no_faktur', '') }}" required> 
                            @if($errors->has('no_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.tgl_faktur') }}</label>
                            <input type="date" class="form-control form-control-line {{ $errors->has('tgl_faktur') ? 'is-invalid' : '' }}" name="tgl_faktur" value="{{ $billing->tgl_faktur ?? old('tgl_faktur', '') }}" required> 
                            @if($errors->has('tgl_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.total_claim') }}</label>
                            <input type="number" class="form-control form-control-line {{ $errors->has('total_claim') ? 'is-invalid' : '' }}" name="total_claim" value="{{ $billing->total_claim ?? old('total_claim', '') }}" required> 
                            @if($errors->has('total_claim'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('total_claim') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.tgl_invoice') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('tgl_invoice') ? 'is-invalid' : '' }}" name="tgl_invoice" value="{{ $billing->tgl_invoice ?? old('tgl_invoice', '') }}" required> 
                            @if($errors->has('tgl_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.posting_date') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('posting_date') ? 'is-invalid' : '' }}" name="posting_date" value="{{ $billing->posting_date ?? old('posting_date', '') }}" required> 
                            @if($errors->has('posting_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('posting_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.npwp') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('npwp') ? 'is-invalid' : '' }}" name="npwp" value="{{ $billing->npwp ?? old('npwp', '') }}" required> 
                            @if($errors->has('npwp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('npwp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.ktp_no') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('ktp_no') ? 'is-invalid' : '' }}" name="ktp_no" value="{{ $billing->ktp_no ?? old('ktp_no', '') }}"> 
                            @if($errors->has('ktp_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ktp_no') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.tipe_pajak') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('tipe_pajak') ? 'is-invalid' : '' }}" name="tipe_pajak" value="{{ $billing->tipe_pajak ?? old('tipe_pajak', '') }}" required> 
                            @if($errors->has('tipe_pajak'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tipe_pajak') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.nominal_pajak') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('nominal_pajak') ? 'is-invalid' : '' }}" name="nominal_pajak" value="{{ $billing->nominal_pajak ?? old('nominal_pajak', '') }}" required> 
                            @if($errors->has('nominal_pajak'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nominal_pajak') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.company_list') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('company_list') ? 'is-invalid' : '' }}" name="company_list" value="{{ $billing->company_list ?? old('company_list', '') }}" required> 
                            @if($errors->has('company_list'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company_list') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.nominal_claimable') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('nominal_claimable') ? 'is-invalid' : '' }}" name="nominal_claimable" value="{{ $billing->nominal_claimable ?? old('nominal_claimable', '') }}" required> 
                            @if($errors->has('nominal_claimable'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nominal_claimable') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.perihal_claim') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('perihal_claim') ? 'is-invalid' : '' }}" name="perihal_claim" value="{{ $billing->perihal_claim ?? old('perihal_claim', '') }}" required> 
                            @if($errors->has('perihal_claim'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('perihal_claim') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.potongan_pph') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('potongan_pph') ? 'is-invalid' : '' }}" name="potongan_pph" value="{{ $billing->potongan_pph ?? old('potongan_pph', '') }}"> 
                            @if($errors->has('potongan_pph'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('potongan_pph') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.jumlah_pph') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('jumlah_pph') ? 'is-invalid' : '' }}" name="jumlah_pph" value="{{ $billing->jumlah_pph ?? old('jumlah_pph', '') }}" required> 
                            @if($errors->has('jumlah_pph'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('jumlah_pph') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.partner_bank') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('partner_bank') ? 'is-invalid' : '' }}" name="partner_bank" value="{{ $billing->partner_bank ?? old('partner_bank', '') }}" required> 
                            @if($errors->has('partner_bank'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('partner_bank') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label>{{ trans('cruds.billing.fields.payment_term_claim') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('payment_term_claim') ? 'is-invalid' : '' }}" name="payment_term_claim" value="{{ $billing->payment_term_claim ?? old('payment_term_claim', '') }}" required> 
                            @if($errors->has('payment_term_claim'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('payment_term_claim') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">GENERAL LEDGER</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.gl_account') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('gl_account') ? 'is-invalid' : '' }}" name="gl_account" value="{{ $billing->gl_account ?? old('gl_account', '') }}" required> 
                            @if($errors->has('gl_account'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gl_account') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.gl_value') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('gl_value') ? 'is-invalid' : '' }}" name="gl_value" value="{{ $billing->gl_value ?? old('gl_value', '') }}" required> 
                            @if($errors->has('gl_value'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gl_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.cost_center') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('cost_center') ? 'is-invalid' : '' }}" name="cost_center" value="{{ $billing->cost_center ?? old('cost_center', '') }}" required> 
                            @if($errors->has('cost_center'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cost_center') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Other AR</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.ar') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('ar') ? 'is-invalid' : '' }}" name="ar" value="{{ $billing->ar ?? old('ar', '') }}" required> 
                            @if($errors->has('ar'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ar') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.ar_value') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('ar_value') ? 'is-invalid' : '' }}" name="ar_value" value="{{ $billing->ar_value ?? old('ar_value', '') }}" required> 
                            @if($errors->has('ar_value'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ar_value') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.billing') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection