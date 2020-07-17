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
            @method('put')
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
                            <tr>
                                <th>No Surat jalan</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->no_surat_jalan) }}">{{ $billing->no_surat_jalan }}</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Detail Billing</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.vendor_id') }}</label>
                            <input type="text" class="form-control form-control-line" name="vendor_id" value="{{ $billing->vendor_id }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.proposal_id') }}</label>
                            <input type="text" class="form-control form-control-line" name="billing_no" value="{{ $billing->billing_no ?? old('billing_no', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No Faktur Pajak</label>
                            <input type="text" class="form-control form-control-line" name="no_faktur" value="{{ $billing->no_faktur ?? old('no_faktur', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Faktur Pajak</label>
                            <input type="text" id="mdate" class="form-control form-control-line" name="tgl_faktur" value="{{ $billing->tgl_faktur ?? old('tgl_faktur', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Invoice</label>
                            <input type="text" class="form-control form-control-line" name="no_invoice" value="{{ $billing->no_invoice ?? old('no_invoice', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Invoice</label>
                            <input type="text" class="form-control mdate2 form-control-line" name="tgl_invoice" value="{{ $billing->tgl_invoice ?? old('tgl_invoice', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Nominal Invoice After PPN</label>
                            <input type="text" class="form-control form-control-line" name="nominal_inv_after_ppn" value="{{ $billing->nominal_inv_after_ppn }}" id="nominal_inv_after_ppn" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>PPN</label>
                            <input type="text" class="form-control form-control-line" id="ppn" name="ppn" value="{{ $billing->ppn ?? old('ppn', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>DPP</label>
                            <input type="text" class="form-control form-control-line" name="dpp" id="dpp" value="{{ toDecimal($billing->dpp) ?? old('dpp', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Rekening </label>
                            <input type="text" class="form-control form-control-linn" name="no_rekening" value="{{ $billing->no_rekening ?? old('no_rekening', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>NPWP</label>
                            <input type="text" id="" class="form-control form-control-line" name="npwp" value="{{ $billing->npwp ?? old('npwp', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Keterangan PO</label>
                            <input type="text" id="" class="form-control form-control-line" name="keterangan_po" value="{{ $billing->keterangan_po ?? old('keterangan_po', '') }}" readonly> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{-- <h3 class="title">HEADER</h3> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.document_no') }}</label>
                            <input type="text" class="form-control form-control-line" name="document_no" value="" readonly> 
                        </div> --}}
                        {{-- <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.proposal_date') }}</label>
                            <input type="text" class="form-control form-control-line " name="proposal_date" value="{{ $billing->proposal_date ?? old('proposal_date', '') }}" readonly> 
                        </div> --}}
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.base_line_date') }} *</label>
                            <input type="text" class="form-control form-control-line mdate {{ $errors->has('base_line_date') ? 'is-invalid' : '' }}" name="base_line_date" value="" required>
                            @if($errors->has('base_line_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('base_line_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.assignment') }} *</label>
                            <input type="text" class="form-control form-control-line {{ $errors->has('assignment') ? 'is-invalid' : '' }}" name="assignment" value="" required> 
                            @if($errors->has('assignment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('assignment') }}
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
                            <select class="form-control select2 form-control-line" name="tipe_pph" id="tipe_pph">
                                <option value=""> -Select-</option>
                                @foreach ($tipePphs as $tipe)
                                    <option value="{{ $tipe->withholding_tax_rate }}" data-rate="{{ $tipe->withholding_tax_rate }}">{{ $tipe->withholding_tax_code }} - {{ $tipe->name }}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="form-group col-lg-4">
                            <label>Base PPH</label>
                            <input type="text" class="form-control form-control-line" name="base_pph" value="{{ toDecimal($billing->dpp) }}"> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.jumlah_pph') }}</label>
                            <input type="text" class="form-control money form-control-line" name="jumlah_pph" id="jumlah_pph" value=""> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.currency') }}</label>
                            <select class="form-control select2 form-control-line" name="currency" value=""> 
                                @foreach ($currency as $curr)
                                    <option value="{{ $curr->currency }}" @if( $curr->currency == "IDR") selected @endif>{{ $curr->currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ 'Tax Amount' }}</label>
                            <input type="text" class="form-control form-control-line " name="tax_amount" value="" id="taxAmount"> 
                            <input type="checkbox" class="" id="check_1" name="calculate_tax" value="1">
                            <label for="check_1">&nbsp; Calculate Tax</label>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Bank House</label>
                            <select class="form-control select2 form-control-line" name="house_bank" value=""> 
                                @foreach ($bankHouse as $bankHouses)
                                    <option value="{{ $bankHouses->house_bank }}">{{ $bankHouses->house_bank." - ".$bankHouses->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.exchange_rate') }}</label>
                            <input type="text" class="form-control form-control-line" name="exchange_rate" value=""> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Nominal Invoice</label>
                            <input type="text" class="form-control form-control-line " name="nominal_invoice_staff" value="" id="nominal_invoice_staff"> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.perihal_claim') }}</label>
                            <input type="text" class="form-control form-control-line " name="perihal_claim" value="{{ $billing->perihal_claim ?? old('perihal_claim', '') }}"> 
                        </div>
                        {{-- <div class="form-group col-lg-6">
                            <label>Ref Key 3</label>
                            <input type="text" class="form-control form-control-line " name="ref_key_3" maxlength="16" value=""> 
                        </div> --}}
                        <div class="form-group col-lg-6">
                            <input type="checkbox" class="" id="check_B" name="payment_block" value="1">
                            <label for="check_B">&nbsp; Payment Block</label>
                            <label>Payment Block</label>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Nominal Balance</label>
                            <input type="text" class="form-control form-control-line" name="nominal_balance" id="nominal_balance" value="" readonly> 
                        </div>
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
                        <div class="table-responsive">
                            <table class="table table-striped" id="datatables-run">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">Qty</th>
                                        <th>Value</th>
                                        <th>Material</th>
                                        <th>PO No</th>
                                        <th>PO Item</th>
                                        <th>GR Doc</th>
                                        <th>GR No</th>
                                        <th>GR Date</th>
                                    </tr>
                                </thead>
                                <tbody id="billing-detail">
                                    @php
                                        $totalSum = 0;
                                    @endphp
                                    @foreach ($billing->detail as $val)
                                    @php
                                        $totalSum += $val->amount;
                                    @endphp
                                    <tr>
                                        <input type="hidden" value="{{ $val->id }}" name="iddetail[]">
                                        <td>{{ $val->qty }}</td>
                                        <td><input type="text" class="amount" name="amount[]" id="amount" value="{{ $val->amount }}"/></td>
                                        <td>{{ $val->material_id." - ".$val->material->description }}</td>
                                        <td>{{ $val->po_no }}</td>
                                        <td>{{ $val->PO_ITEM }}</td>
                                        <td>{{ $val->doc_gr }}</td>
                                        <td>{{ $val->item_gr }}</td>
                                        <td>{{ $val->gr_date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                        @php
                            $balance = $billing->dpp - $totalSum;
                        @endphp
                        <input type="hidden" class="form-control form-control-line" name="nominal_balances" id="nominal_balances" value="{{ toDecimal($balance) }}"> 
                    </div>
                    <br>
                    <br>
                    <div class="form-actions">
                        <button id="save" type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.submit') }}</button>
                        {{-- <a href="{{ route('admin.billing') }}" type="button" class="btn btn-inverse"><i class="fa fa-arrow-left"></i> Back To List</a> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#datatables-run').DataTable({
        "searching": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bInfo": false,
        "ordering": false
    });

    $("#nominal_balance").val($("#nominal_balances").val())

    $('.money').mask('#.##0', { reverse: true });

    $("#tipe_pph").change(function() {
        let rates = $('#tipe_pph option:selected').data('rate')

        //dpp * rate
        //rate tipe pph * base = nominal pph

        // rumus nominal invoice 
        // dpp * ppn (1.1) - nominal pph
        var dpp = $("#dpp").val()
        var ppn = $("#ppn").val()
        var ppns = ''
        if( ppn == 'V1' ) {
            ppns = 1.1
            var nomInv = parseFloat(tt) * ppns - roundedString;
        } else {
            var nomInv = parseFloat(tt) * ppns - roundedString;
        }

        tt = dpp.replace(/,/g, '.');
        var count = parseFloat(tt) * rates;
        var roundedString = count.toFixed(2);
        var cm = roundedString.replace(".", ",");

        
        $("#jumlah_pph").val(cm)
        $("#nominal_invoice_staff").val(nomInv.toFixed(2))
    })

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

    $(document).on('click', '#rejects', function (result) {
        const $modal = $('#modal_rejected_reasons')
        $modal.find('#billing-id').val($(this).data('id'))
        $modal.modal('show')
    })

    $(document).on('click', '#submit', function (result) {
        $form = $('.form-material')
        $form.attr('action', '{{ route('admin.billing-store') }}')
        $form.submit()
    })

    $("#check_1").click(function() {
        if(this.checked) {
            if( this.value == 1) {
                //$("#payment_block").val('B') --}}
                $("#taxAmount").attr('readonly',true)
                $("#nominal_invoice_staff").attr('readonly',true)
            } 
        } else {
            $("#nominal_invoice_staff").attr('readonly',false)
            $("#taxAmount").attr('readonly',false)
            //$("#payment_block").val(' ')
        }
    })

    $('.amount').on('keyup', function() {
        let value = $(this).val()
        if (isNaN(value.replace(',', ''))) return false

        let _value = document.getElementsByClassName('amount')
        if (_value.length > 0) {
            let total = 0
            for (let i = 0; i < _value.length; i++) {
                let _value_value = _value[i].value
                if (_value_value=='') _value_value = '0'
                total += parseInt(_value_value.replace(',', ''))
            }
            $('#nominal_balance').val(formatNumber(total))
        }
    })

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    $(function() {
     
    })

</script>
@endsection