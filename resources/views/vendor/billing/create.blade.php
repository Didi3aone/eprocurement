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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="title">HEADER</h3>
                        </div>
                        <div class="card-body">
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
                                {{-- <div class="form-group col-lg-3">
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
                                <div class="form-group col-lg-3">
                                    <label>{{ trans('cruds.billing.fields.po_no') }}</label>
                                    <select class="form-control select2 form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" id="po_no" name="po_no" value="{{ $billing->po_no ?? old('po_no', '') }}" required> 
                                    @if($errors->has('po_no'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('po_no') }}
                                        </div>
                                    @endif
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3 class="title col-lg-8">Purchase Order List</h3>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <a href="javascript:;" id="add-material" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Item
                                    </a>
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
                                                <th style="width: 10%">Material Code</th>
                                                <th style="width: 10%">Description</th>
                                                <th style="width: 20%">PO No</th>
                                                <th style="width: 10%">GR Doc</th>
                                                <th style="width: 10%">GR No</th>
                                                <th style="width: 10%">GR Date</th>
                                                <th style="width: 10%">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="billing-detail">
                                            <tr>
                                                <input type="hidden" name="qty_old[]" class="qty-old" value="">
                                                <td><input type="number" class="qty form-control" name="qty[]" required/></td>
                                                <td><input type="text" class="material form-control" name="material[]" required readonly></select></td>
                                                <td><input type="text" class="description form-control" name="description[]" required readonly/></td>
                                                <td><select class="choose-po select2 po_no form-control" name="po_no[]" required></select></td>
                                                <td><input type="text" class="doc_gr form-control" name="doc_gr[]" required readonly/></td>
                                                <td><input type="text" class="item_gr form-control" name="item_gr[]" required readonly/></td>
                                                <td><input type="text" class="tahun_gr form-control" name="tahun_gr[]" required readonly/></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                                    <a href="{{ route('admin.billing') }}" type="button" class="btn btn-inverse">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const base_url = '{{ url('/') }}'

    $(document).on('click', '#add-material', function (e) {
        e.preventDefault()

        const template = `
            <tr>
                <input type="hidden" name="qty_old[]" class="qty-old" value="">
                <td><input type="number" class="qty form-control" name="qty[]" required/></td>
                <td><input type="text" class="material form-control" name="material[]" required readonly></select></td>
                <td><input type="text" class="description form-control" name="description[]" required readonly/></td>
                <td><select class="choose-po select2 po_no form-control" name="po_no[]" required></select></td>
                <td><input type="text" class="doc_gr form-control" name="doc_gr[]" required readonly/></td>
                <td><input type="text" class="item_gr form-control" name="item_gr[]" required readonly/></td>
                <td><input type="text" class="tahun_gr form-control" name="tahun_gr[]" required readonly/></td>
                <td>
                    <a href="javascript:;" class="remove-item btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i> Remove
                    </a>
                </td>
            </tr>
        `

        $(document).find('#billing-detail').append(template)
        loadMaterial()
    })

    $(document).on('click', '.remove-item', function (e) {
        e.preventDefault()

        $(this).parent().parent().remove()
    })

    function loadMaterial () {
        $('.choose-po').select2({
            ajax: {
                url: base_url + '/admin/material/select2',
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                },
                cache: true
            }
        })
    }

    $(document).on('change', '.choose-po', function () {
        $tr = $(this).closest('tr')

        const value = $(this).children('option:selected').val().split('-')
        const po_no = value[0]
        const material = value[1]
        const qty = value[2]
        const doc_gr = value[3]
        const item_gr = value[4]
        const tahun_gr = value[5]
        const reference_document = value[6]
        const description = value[7]

        $tr.find('.material').val(material)
        $tr.find('.qty').val(qty)
        $tr.find('.qty-old').val(qty)
        $tr.find('.doc_gr').val(doc_gr)
        $tr.find('.item_gr').val(item_gr)
        $tr.find('.tahun_gr').val(tahun_gr)
        $tr.find('.reference_document').val(reference_document)
        $tr.find('.description').val(description)
    }).trigger('change')

    $(document).on('change', '.qty', function () {
        $tr = $(this).closest('tr')
        $qty_old = parseInt($tr.find('.qty-old').val())
        $this = $(this)

        if (parseInt($(this).val()) < $qty_old) {
            alert('Quantity cannot be less than default quantity')
            $this.val($qty_old)

            return false
        }
    }).trigger('change')

    loadMaterial()
</script>
@endsection