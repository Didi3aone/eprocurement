@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Detail</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.billing.title') }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form class="form-material m-t-40" action="{{ route("admin.billing-store") }}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $billing->id }}">
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Attachment</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ trans('cruds.billing.fields.file_invoice') }}</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->file_invoice) }}">{{ $billing->file_invoice }}</a></td>
                            </tr>
                            <tr>
                                <th>File PO</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->po) }}">{{ $billing->po  }}</a> </td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.billing.fields.file_faktur') }}</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->file_faktur ) }}">{{ $billing->file_faktur }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.billing.fields.file_skp') }}</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->surat_ket_bebas_pajak) }}">{{ $billing->surat_ket_bebas_pajak }}</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">HEADER</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.proposal_id') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('billing_no') ? 'is-invalid' : '' }}" name="billing_no" value="{{ $billing->billing_no ?? old('billing_no', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.document_no') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('document_no') ? 'is-invalid' : '' }}" name="document_no" value="{{ $billing->document_no ?? old('document_no', '') }}" readonly> 
                            @if($errors->has('document_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('document_no') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.vendor_id') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id" value="{{ $billing->vendor_id ?? old('vendor_id', '') }}" readonly> 
                            @if($errors->has('vendor_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vendor_id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.proposal_date') }}</label>
                            <input type="date" class="form-control form-control-line {{ $errors->has('proposal_date') ? 'is-invalid' : '' }}" name="proposal_date" value="{{ $billing->proposal_date ?? old('proposal_date', '') }}" readonly> 
                            @if($errors->has('proposal_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('proposal_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.npwp') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('npwp') ? 'is-invalid' : '' }}" name="npwp" value="{{ $billing->npwp ?? old('npwp', '') }}" readonly> 
                            @if($errors->has('npwp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('npwp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.no_rekening') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_rekening') ? 'is-invalid' : '' }}" name="no_rekening" value="{{ $billing->no_rekening ?? old('no_rekening', '') }}" readonly> 
                            @if($errors->has('no_rekening'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_rekening') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.no_faktur') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_faktur') ? 'is-invalid' : '' }}" name="no_faktur" value="{{ $billing->no_faktur ?? old('no_faktur', '') }}" readonly> 
                            @if($errors->has('no_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_faktur') }}
                                </div>
                            @endif
                        </div>
                        {{-- <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.status') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" value="{{ $billing->status ? \App\Models\Vendor\Billing::TypeStatus[$billing->status] : '' }}" required readonly> 
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div> --}}
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.tgl_invoice') }}</label>
                            <input type="date" class="form-control form-control-line {{ $errors->has('tgl_invoice') ? 'is-invalid' : '' }}" name="tgl_invoice" value="{{ $billing->tgl_invoice ?? old('tgl_invoice', '') }}" required> 
                            @if($errors->has('tgl_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.tgl_faktur') }}</label>
                            <input type="date" class="form-control form-control-line {{ $errors->has('tgl_faktur') ? 'is-invalid' : '' }}" name="tgl_faktur" value="{{ $billing->tgl_faktur ?? old('tgl_faktur', '') }}" required> 
                            @if($errors->has('tgl_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.base_line_date') }}</label>
                            <input type="date" class="form-control form-control-line {{ $errors->has('base_line_date') ? 'is-invalid' : '' }}" name="base_line_date" value="{{ $billing->posting_date ?? old('base_line_date', '') }}" required> 
                            @if($errors->has('base_line_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('base_line_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.assignment') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('assignment') ? 'is-invalid' : '' }}" name="assignment" value="{{ $billing->assignment ?? old('assignment', '') }}" required> 
                            @if($errors->has('assignment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('assignment') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.dpp') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('dpp') ? 'is-invalid' : '' }}" name="dpp" id="dpp" value="{{ $billing->dpp ?? old('dpp', '') }}" readonly> 
                            @if($errors->has('dpp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('dpp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.tipe_pajak') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('tipe_pajak') ? 'is-invalid' : '' }}" name="tipe_pajak" value="{{ $billing->ppn ?? old('tipe_pajak', '') }}" readonly> 
                            @if($errors->has('tipe_pajak'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tipe_pajak') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.nominal_pajak') }}</label>
                            <input type="number" class="form-control form-control-line {{ $errors->has('nominal_pajak') ? 'is-invalid' : '' }}" name="nominal_pajak" value="{{ $billing->nominal_pajak ?? old('nominal_pajak', '') }}" required> 
                            @if($errors->has('nominal_pajak'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nominal_pajak') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.payment_term_claim') }}</label>
                            <select class="form-control select2 form-control-line {{ $errors->has('payment_term_claim') ? 'is-invalid' : '' }}" name="payment_term_claim" value="{{ $billing->payment_term_claim ?? old('payment_term_claim', '') }}" required> 
                                @foreach ($payments as $pay)
                                    <option value="{{ $pay->payment_terms }}">{{ $pay->payment_terms }} - {{ $pay->own_explanation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.tipe_pph') }}</label>
                            <select class="form-control select2 form-control-line" name="tipe_pph" id="tipe_pph" value="{{ $billing->tipe_pph ?? old('tipe_pph', '') }}">
                                @foreach ($tipePphs as $tipe)
                                    <option value="{{ $tipe->withholding_tax_rate }}">{{ $tipe->withholding_tax_code }} - {{ $tipe->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.jumlah_pph') }}</label>
                            <input type="number" class="form-control form-control-line {{ $errors->has('jumlah_pph') ? 'is-invalid' : '' }}" name="jumlah_pph" id="jumlah_pph" value="{{ $billing->jumlah_pph ?? old('jumlah_pph', '') }}" readonly> 
                            @if($errors->has('jumlah_pph'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('jumlah_pph') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.total_invoice') }}</label>
                            <input type="number" class="form-control form-control-line {{ $errors->has('total_invoice') ? 'is-invalid' : '' }}" name="total_invoice" value="{{ $billing->dpp + $billing->ppn ?? old('total_invoice','') }}" required> 
                            @if($errors->has('total_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('total_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.perihal_claim') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('perihal_claim') ? 'is-invalid' : '' }}" name="perihal_claim" value="{{ $billing->perihal_claim ?? old('perihal_claim', '') }}" required> 
                            @if($errors->has('perihal_claim'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('perihal_claim') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.currency') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency" value="{{ $billing->currency ?? old('currency', 'IDR') }}" required> 
                            @if($errors->has('currency'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('currency') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.exchange_rate') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('exchange_rate') ? 'is-invalid' : '' }}" name="exchange_rate" value="{{ $billing->exchange_rate ?? old('exchange_rate', '') }}" required> 
                            @if($errors->has('exchange_rate'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('exchange_rate') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Detail Item Billing</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>No Faktur Pajak</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_faktur') ? 'is-invalid' : '' }}" name="no_faktur" value="{{ $billing->no_faktur ?? old('no_faktur', '') }}" readonly> 
                            @if($errors->has('no_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Faktur Pajak</label>
                            <input type="text" id="mdate" class="form-control form-control-line {{ $errors->has('tgl_faktur') ? 'is-invalid' : '' }}" name="tgl_faktur" value="{{ $billing->tgl_faktur ?? old('tgl_faktur', '') }}" readonly> 
                            @if($errors->has('tgl_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Invoice</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_invoice') ? 'is-invalid' : '' }}" name="no_invoice" value="{{ $billing->no_invoice ?? old('no_invoice', '') }}" readonly> 
                            @if($errors->has('no_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Invoice</label>
                            <input type="text" class="form-control mdate2 form-control-line {{ $errors->has('tgl_invoice') ? 'is-invalid' : '' }}" name="tgl_invoice" value="{{ $billing->tgl_invoice ?? old('tgl_invoice', '') }}" readonly> 
                            @if($errors->has('tgl_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Nominal Invoice Sesudah PPN</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('nominal_inv_after_ppn') ? 'is-invalid' : '' }}" name="nominal_inv_after_ppn" value="{{ $billing->nominal_inv_after_ppn ?? old('nominal_inv_after_ppn', '') }}" readonly> 
                            @if($errors->has('nominal_inv_after_ppn'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nominal_inv_after_ppn') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>PPN</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('ppn') ? 'is-invalid' : '' }}" name="ppn" value="{{ $billing->ppn ?? old('ppn', '') }}" readonly> 
                            @if($errors->has('ppn'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ppn') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>DPP</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('dpp') ? 'is-invalid' : '' }}" name="dpp" id="dpp" value="{{ $billing->dpp ?? old('dpp', '') }}" readonly> 
                            @if($errors->has('dpp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('dpp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Rekening </label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_rekening') ? 'is-invalid' : '' }}" name="no_rekening" value="{{ $billing->no_rekening ?? old('no_rekening', '') }}" readonly> 
                            @if($errors->has('no_rekening'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_rekening') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>NPWP</label>
                            <input type="text" id="" class="form-control form-control-line {{ $errors->has('npwp') ? 'is-invalid' : '' }}" name="npwp" value="{{ $billing->npwp ?? old('npwp', '') }}" readonly> 
                            @if($errors->has('npwp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('npwp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Keterangan PO</label>
                            <input type="text" id="" class="form-control form-control-line {{ $errors->has('keterangan_po') ? 'is-invalid' : '' }}" name="keterangan_po" value="{{ $billing->keterangan_po ?? old('keterangan_po', '') }}" readonly> 
                            @if($errors->has('keterangan_po'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('keterangan_po') }}
                                </div>
                            @endif
                        </div>
                        {{-- <div class="form-group col-lg-4">
                            <label>PO <span class="text-danger">*</span> </label>
                            <input type="file" class="form-control form-control-line" name="po" value="{{ $billing->po ?? old('po', '') }}"> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Surat Ket. Bebas Pajak</label>
                            <input type="file" id="" class="form-control form-control-line {{ $errors->has('surat_ket_bebas_pajak') ? 'is-invalid' : '' }}" name="surat_ket_bebas_pajak" value="{{ $billing->surat_ket_bebas_pajak ?? old('surat_ket_bebas_pajak', '') }}"> 
                            @if($errors->has('surat_ket_bebas_pajak'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('surat_ket_bebas_pajak') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Upload File Invoice <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-line" name="file_invoice" value="{{ $billing->file_invoice ?? old('file_invoice', '') }}"> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Upload File Faktur <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-line" name="file_faktur" value="{{ $billing->file_faktur ?? old('file_faktur', '') }}"> 
                        </div> --}}


                        {{-- dikarantina --}}
                        {{-- <div class="form-group col-lg-3">
                            <label>{{ trans('cruds.billing.fields.title') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ $billing->title ?? old('title', '') }}" required> 
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
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
                            <label>{{ trans('cruds.billing.fields.division') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('division') ? 'is-invalid' : '' }}" name="division" value="{{ $billing->division ?? old('division', '') }}" required> 
                            @if($errors->has('division'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('division') }}
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
                            <label>{{ trans('cruds.billing.fields.ktp_no') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('ktp_no') ? 'is-invalid' : '' }}" name="ktp_no" value="{{ $billing->ktp_no ?? old('ktp_no', '') }}"> 
                            @if($errors->has('ktp_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ktp_no') }}
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
                            <label>{{ trans('cruds.billing.fields.partner_bank') }}</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('partner_bank') ? 'is-invalid' : '' }}" name="partner_bank" value="{{ $billing->partner_bank ?? old('partner_bank', '') }}" required> 
                            @if($errors->has('partner_bank'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('partner_bank') }}
                                </div>
                            @endif
                        </div> --}}
                        {{-- end karantina --}}

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="title col-lg-8">Purchase Order List</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 10%">Value</th>
                                        <th style="width: 10%">Material Code</th>
                                        <th style="width: 10%">Description</th>
                                        <th style="width: 20%">PO No</th>
                                        <th style="width: 10%">PO Item</th>
                                        <th style="width: 10%">GR Doc</th>
                                        <th style="width: 10%">GR No</th>
                                        <th style="width: 20%">GR Date</th>
                                    </tr>
                                </thead>
                                <tbody id="billing-detail">
                                    @foreach ($details as $val)
                                    <tr>
                                        <td><input type="number" class="qty form-control" name="qty[]" value="{{ $val->qty }}" readonly/></td>
                                        <td><input type="number" class="amount form-control" name="amount[]" value="{{ $val->amount }}" readonly/></td>
                                        <td><input type="text" class="material form-control" name="material[]" value="{{ $val->material_no }}" readonly></select></td>
                                        <td><input type="text" class="description form-control" name="description[]" value="{{ $val->material->description }}" readonly/></td>
                                        <td><input type="text" class="po_no form-control" name="po_no[]" value="{{ $val->po_no }}" readonly></td>
                                        <td><input type="text" class="po_item form-control" name="po_item[]" value="{{ $val->po_item }}" readonly></td>
                                        <td><input type="text" class="doc_gr form-control" name="doc_gr[]" value="{{ $val->doc_gr }}" readonly/></td>
                                        <td><input type="text" class="item_gr form-control" name="item_gr[]" value="{{ $val->item_gr }}" readonly/></td>
                                        <td><input type="text" class="posting_date form-control" name="posting_date[]" value="{{ $val->posting_date }}" readonly/></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-actions">
                        @php
                            $disabled = false;

                            if ($billing->status == 2)
                                $disabled = true;
                            elseif ($billing->status == 3)
                                $disabled = true;
                            else
                                $disabled = false;
                        @endphp
                        @if ($disabled == false)
                            @can('accounting_staff')
                                <a href="javascript:;" id="approval" type="button" class="btn btn-warning"> <i class="fa fa-check"></i> {{ trans('global.approve') }}</a>
                                <a href="javascript:;" id="reject" data-toggle="modal" data-id="{{ $billing->id }}" data-target="#modal_rejected_reason" type="button" class="btn btn-danger"> <i class="fa fa-times"></i> {{ trans('global.reject') }}</a>
                            @endcan
                            @can('accounting_spv')
                                <a href="javascript:;" id="reject" data-toggle="modal" data-id="{{ $billing->id }}" data-target="#modal_rejected_reason" type="button" class="btn btn-danger"> <i class="fa fa-times"></i> {{ trans('global.reject') }}</a>
                            @endcan
                        @elseif ($disabled == true)
                            @can('accounting_spv')
                                <a href="javascript:;" id="submit" type="button" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.submit') }}</a>
                            @endcan
                        @endif
                        <a href="{{ route('admin.billing') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal_rejected_reason" tabindex="-1" role="dialog" aria-labelledby="modal_rejected_reason" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejected Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.billing-post-rejected') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="billing-id" value="">
                    <textarea name="reason" id="reason" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-trash"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).on('change', '#tipe_pph', function () {
        const nominal_pph = $(this).val() * $('#dpp').val()
        console.log($(this).val(), $('#dpp').val(), nominal_pph)

        $(document).find('#jumlah_pph').val(nominal_pph)
    }).trigger('change')

    $(document).on('click', '#approval', function (result) {
        $form = $('.form-material')
        $form.attr('action', '{{ route('admin.billing-post-approved') }}')
        $form.submit()
    })

    $(document).on('click', '#reject', function (result) {
        const $modal = $('#modal_rejected_reason')
        $modal.find('#billing-id').val($(this).data('id'))
        $modal.modal('show')
    })

    $(document).on('click', '#submit', function (result) {
        $form = $('.form-material')
        $form.attr('action', '{{ route('admin.billing-store') }}')
        $form.submit()
    })
</script>
@endsection