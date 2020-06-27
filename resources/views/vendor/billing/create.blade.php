@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Billing</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("vendor.billing-post") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>No Faktur Pajak</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_faktur') ? 'is-invalid' : '' }}" name="no_faktur" value="{{ old('no_faktur', '') }}"> 
                            @if($errors->has('no_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Faktur Pajak <span class="text-danger">*</span></label>
                            <input type="text" id="mdate" class="form-control form-control-line {{ $errors->has('tgl_faktur') ? 'is-invalid' : '' }}" name="tgl_faktur" value="{{ old('tgl_faktur', '') }}"> 
                            @if($errors->has('tgl_faktur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_faktur') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Invoice</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_invoice') ? 'is-invalid' : '' }}" name="no_invoice" value="{{ old('no_invoice', '') }}"> 
                            @if($errors->has('no_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Invoice <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mdate2 form-control-line {{ $errors->has('tgl_invoice') ? 'is-invalid' : '' }}" name="tgl_invoice" value="{{ old('tgl_invoice', '') }}"> 
                            @if($errors->has('tgl_invoice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_invoice') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Nominal Invoice Sesudah PPN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('nominal_inv_after_ppn') ? 'is-invalid' : '' }}" name="nominal_inv_after_ppn" value="{{ old('nominal_inv_after_ppn', '') }}"> 
                            @if($errors->has('nominal_inv_after_ppn'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nominal_inv_after_ppn') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>PPN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('ppn') ? 'is-invalid' : '' }}" name="ppn" value="{{ old('ppn', '') }}"> 
                            @if($errors->has('ppn'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ppn') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>DPP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('dpp') ? 'is-invalid' : '' }}" name="dpp" value="{{ old('dpp', '') }}"> 
                            @if($errors->has('dpp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('dpp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Rekening <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_rekening') ? 'is-invalid' : '' }}" name="no_rekening" value="{{ old('no_rekening', '') }}"> 
                            @if($errors->has('no_rekening'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_rekening') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Surat Jalan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('no_surat_jalan') ? 'is-invalid' : '' }}" name="no_surat_jalan" value="{{ old('no_surat_jalan', '') }}"> 
                            @if($errors->has('no_surat_jalan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_surat_jalan') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>TGL. Surat Jalan <span class="text-danger">*</span></label>
                            <input type="text" id="" class="form-control mdate form-control-line {{ $errors->has('tgl_surat_jalan') ? 'is-invalid' : '' }}" name="tgl_surat_jalan" value="{{ old('tgl_surat_jalan', '') }}"> 
                            @if($errors->has('tgl_surat_jalan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tgl_surat_jalan') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>NPWP</label>
                            <input type="text" id="" class="form-control form-control-line {{ $errors->has('npwp') ? 'is-invalid' : '' }}" name="npwp" value="{{ old('npwp', '') }}"> 
                            @if($errors->has('npwp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('npwp') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Keterangan PO</label>
                            <textarea class="form-control form-control-line" name="keterangan_po"></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>PO <span class="text-danger">*</span> </label>
                            <input type="file" class="form-control form-control-line" name="po" value="{{ old('po', '') }}"> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Surat Ket. Bebas Pajak</label>
                            <input type="file" id="" class="form-control form-control-line {{ $errors->has('surat_ket_bebas_pajak') ? 'is-invalid' : '' }}" name="surat_ket_bebas_pajak" value="{{ old('surat_ket_bebas_pajak', '') }}"> 
                            @if($errors->has('surat_ket_bebas_pajak'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('surat_ket_bebas_pajak') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Upload File Invoice <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-line" name="file_invoice" value="{{ old('file_invoice', '') }}"> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Upload File Faktur <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-line" name="file_faktur" value="{{ old('file_faktur', '') }}"> 
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" id="save"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('vendor.billing') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection