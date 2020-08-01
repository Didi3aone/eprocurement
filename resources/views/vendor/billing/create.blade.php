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
                                    <label>Tax Invoice Number</label>
                                    <input type="text" class="form-control form-control-line {{ $errors->has('no_faktur') ? 'is-invalid' : '' }}" name="no_faktur" value="{{ old('no_faktur', '') }}"> 
                                    @if($errors->has('no_faktur'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('no_faktur') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Tax Invoice Date <span class="text-danger">*</span></label>
                                    <input type="text" id="mdate" class="form-control form-control-line {{ $errors->has('tgl_faktur') ? 'is-invalid' : '' }}" name="tgl_faktur" value="{{ old('tgl_faktur', '') }}"> 
                                    @if($errors->has('tgl_faktur'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tgl_faktur') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Invoice Number</label>
                                    <input type="text" class="form-control form-control-line {{ $errors->has('no_invoice') ? 'is-invalid' : '' }}" name="no_invoice" value="{{ old('no_invoice', '') }}"> 
                                    @if($errors->has('no_invoice'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('no_invoice') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Invoice Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mdate2 form-control-line {{ $errors->has('tgl_invoice') ? 'is-invalid' : '' }}" name="tgl_invoice" value="{{ old('tgl_invoice', '') }}"> 
                                    @if($errors->has('tgl_invoice'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tgl_invoice') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>DPP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-line {{ $errors->has('dpp') ? 'is-invalid' : '' }}" name="dpp" id="dpp" onkeyup="leadingZero(this.value, $(this), true)" value="{{ old('dpp', '') }}"> 
                                    @if($errors->has('dpp'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dpp') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>VAT <span class="text-danger">*</span></label>
                                    {{-- <input type="text" class="form-control form-control-line {{ $errors->has('ppn') ? 'is-invalid' : '' }}" name="ppn" value="{{ old('ppn', '') }}">  --}}
                                    <select class="form-control select2" name="ppn" id="ppn" placeholder="Choose">
                                        <option value=""> Choose </option>
                                        <option value="V0"> None </option>
                                        <option value="V1"> PPN </option>
                                    </select>
                                    @if($errors->has('ppn'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('ppn') }}
                                        </div>
                                    @endif
                                </div>
                                <p id="demo"></p>
                                <div class="form-group col-lg-4">
                                    <label>Nominal Invoice After VAT<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-line" name="nominal_inv_after_ppn" id="nominal_inv_after_ppn" value="{{ old('nominal_inv_after_ppn', '') }}" readonly> 
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Account No <span class="text-danger">*</span></label>
                                     <select class="form-control select2" name="no_rekening" id="no_rekening" placeholder="Choose">
                                        <option value=""> Choose </option>
                                        @foreach($rekening as $id => $account_no )
                                            <option value=" {{ $account_no }} " >{{ $account_no }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('no_rekening'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('no_rekening') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>TAX</label>
                                    <input type="text" id="" class="form-control form-control-line {{ $errors->has('npwp') ? 'is-invalid' : '' }}" name="npwp" value="{{ old('npwp', $npwp->tax_numbers) }}" readonly> 
                                    @if($errors->has('npwp'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('npwp') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Description PO</label>
                                    <textarea class="form-control form-control-line" name="keterangan_po"></textarea>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Upload File PO <span class="text-danger">*</span> </label>
                                    <input type="file" class="form-control form-control-line" id="files" name="po" value="{{ old('po', '') }}"> 
                                    <a href="" class="" id="viewer" target="_blank" onclick="PreviewImagePo()">Preview File Po</a>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Delivery orders <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control form-control-line" id="files_do" name="no_surat_jalan" value="{{ old('no_surat_jalan', '') }}"> 
                                    <a href="" class="" id="viewer_do" target="_blank" onclick="PreviewImageDo()">Preview File DO</a>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Letter of information. Tax-free</label>
                                    <input type="file" id="surat" class="form-control form-control-line {{ $errors->has('surat_ket_bebas_pajak') ? 'is-invalid' : '' }}" name="surat_ket_bebas_pajak" value="{{ old('surat_ket_bebas_pajak', '') }}"> 
                                    <a href="" class="" id="viewer_surat" target="_blank" onclick="PreviewImageSurat()">Preview File Surat Ket. Bebas Pajak</a>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Upload File Invoice <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control form-control-line" id="files_invoice" name="file_invoice" value="{{ old('file_invoice', '') }}"> 
                                    <a href="" class="" id="viewer_invoice" target="_blank" onclick="PreviewImageInvoice()">Preview File Invoice</a>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Upload File Tax Invoice <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control form-control-line" id="file_faktur" name="file_faktur" value="{{ old('file_faktur', '') }}">
                                    <a href="" class="" id="viewer_faktur" target="_blank" onclick="PreviewImageFaktur()">Preview File Faktur</a>
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
                                <div class="col-lg-4 text-right">
                                    <div class="row">
                                        <div class="col-lg-8 text-left">
                                            <div class="form-group">
                                                <select name="search-po" id="search-po" class="choose-po form-control select2">
                                                    @foreach ($po_gr as $gr)
                                                        <option value="{{ $gr->doc_gr }}">{{ $gr->doc_gr }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 text-right">
                                            <a href="javascript:;" id="add-material" class="btn btn-primary">
                                                <i class="fa fa-plus"></i> Add Item
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Qty GR</th>
                                                <th style="width: 10%">Qty</th>
                                                <th style="width: 10%">Material Code</th>
                                                <th style="width: 10%">Description</th>
                                                <th style="width: 20%">PO No</th>
                                                <th style="width: 10%">PO Item</th>
                                                <th style="width: 10%">GR Doc</th>
                                                <th style="width: 10%">GR No</th>
                                                <th style="width: 20%">GR Date</th>
                                                <th style="width: 10%">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="billing-detail"></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                                    <a href="{{ route('vendor.billing') }}" type="button" class="btn btn-inverse"><i class="fa fa-arrow-left"></i> Back</a>
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
    $('#datatables-run').DataTable({
        "searching": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bInfo": false,
        "ordering": false
    });

    $(document).on('click', '#add-material', function (e) {
        e.preventDefault()
        const $search = $('#search-po').children('option:selected')
        console.log($search)
        $search.attr('disabled', 'disabled')
        const input_po = $search.val()
        console.log(input_po)
        $('#search-po').val('').trigger('change')
        $('#search-po').select2()

        const PO_GR = $('.choose-po').val()

        if (input_po != '') {
            $.get(base_url + '/vendor/billing-po-gr/' + input_po, function (result) {
                var template = ''
                //console.log(result)
                $.each(result,function(k,v) {
                   // console.log(v.material.description)
                    let material = '-';
                    let desc = '-';
                    if( v.material_no != '') {
                        material = v.material_no !='' ?  v.material_no : '-'
                        desc = v.material.description ? v.material.description : v.description
                    }
                    template += `
                        <tr>
                            <input type="hidden"name="currency[]" value="${v.currency}">
                            <input type="hidden"name="plant_code[]" value="${v.plant}">
                            <input type="hidden"name="gl_account[]" value="${v.gl_account}">
                            <input type="hidden"name="profit_center[]" value="${v.profit_center}">
                            <input type="hidden"name="amount[]" value="${v.amount}">
                            <input type="hidden"name="material_document[]" value="${v.material_document}">
                            <input type="hidden"name="reference_document_item[]" value="${v.reference_document_item}">
                            <input type="hidden" name="debet_credit[]" value="${v.debet_credit}"/>
                            <input type="hidden" name="storage_location[]" value="${v.storage_location}"/>
                            <input type="hidden" name="unit[]" value="${v.satuan}"/>
                            <input type="hidden" name="reference_document[]" value="${v.reference_document}"/>
                            <input type="hidden" name="material_doc_item[]" value="${v.material_doc_item}"/>
                            <input type="hidden" name="cost_center_code[]" value="${v.cost_center_code}"/>
                            <input type="hidden" name="tahun_gr[]" value="${v.tahun_gr}"/>
                            <input type="hidden" name="price_per_pc[]" value="${v.price_per_pc}"/>
                            <input type="hidden" name="item_category[]" value="${v.item_category}"/>
                            <input type="hidden" name="purchase_order_detail_id[]" value="${v.purchase_order_detail_id}"/>
                            <td><input type="number" class="qty-old form-control" name="qty_old[]" value="${v.qty}" readonly></td>
                            <td><input type="number" class="qty form-control" name="qty[]" value="${v.qty}" required/></td>
                            <td><input type="text" class="material form-control" name="material[]" value="${material}" readonly></select></td>
                            <td><input type="text" class="description form-control" name="description[]" value="${desc}" readonly/></td>
                            <td><input type="text" class="po_no form-control" name="po_no[]" value="${v.po_no}" readonly></td>
                            <td><input type="text" class="po_item form-control" name="PO_ITEM[]" value="${v.po_item}" readonly/></td>
                            <td><input type="text" class="doc_gr form-control" name="doc_gr[]" value="${v.doc_gr}" readonly/></td>
                            <td><input type="text" class="item_gr form-control" name="item_gr[]" value="${v.item_gr}" readonly/></td>
                            <td><input type="text" class="posting_date form-control" name="posting_date[]" value="${v.posting_date}" readonly/></td>
                            <td>
                                <a href="javascript:;" class="remove-item btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i> Unclaim
                                </a>
                            </td>
                        </tr>
                    `
                });
                $(document).find('#billing-detail').append(template)

            })
        }
    })

    $(document).on('click', '.remove-item', function (e) {
        e.preventDefault()

        $(this).parent().parent().remove()
    })

    // $('.choose-po').select2({
    //     ajax: {
    //         url: base_url + '/admin/material/select2',
    //         dataType: 'json',
    //         delay: 300,
    //         data: function (params) {
    //             var query = {
    //                 search: params.term,
    //                 type: 'public'
    //             }

    //             // Query parameters will be ?search=[term]&type=public
    //             return query;
    //         },
    //         processResults: function (response) {
    //             return {
    //                 results: response
    //             }
    //         },
    //         cache: true
    //     }
    // })

    // $(document).on('change', '.choose-po', function () {
    //     $tr = $(this).closest('tr')

    //     const value = $(this).children('option:selected').val().split('-')
    //     const po_no = value[0]
    //     const material = value[1]
    //     const qty = value[2]
    //     const doc_gr = value[3]
    //     const item_gr = value[4]
    //     const posting_date = value[5]
    //     const reference_document = value[6]
    //     const description = value[7]

    //     $tr.find('.material').val(material)
    //     $tr.find('.qty').val(qty)
    //     $tr.find('.qty-old').val(qty)
    //     $tr.find('.doc_gr').val(doc_gr)
    //     $tr.find('.item_gr').val(item_gr)
    //     $tr.find('.posting_date').val(posting_date)
    //     $tr.find('.reference_document').val(reference_document)
    //     $tr.find('.description').val(description)
    // }).trigger('change')

    $(document).on('change', '.qty', function () {
        $tr = $(this).closest('tr')
        $qty_old = parseInt($tr.find('.qty-old').val())
        $this = $(this)

        if (parseInt($(this).val()) > $qty_old) {
            alert('Quantity cannot be more than default quantity')
            $this.val($qty_old)

            return false
        }
    }).trigger('change')


   $('select').on('change', function() {
       var ppn =  this.value;
       var dpp = $("#dpp").val();
       tt = dpp.replace(/,/g, '.');
       if(ppn == "V1") {
           var count = parseFloat(tt) * 1.1;
           var roundedString = count.toFixed(2);
           var cm = roundedString.replace(".", ",");
           $("#nominal_inv_after_ppn").val(cm);
       } else if(ppn == "V0") {
           var cm = dpp.replace(".", ",");
           $("#nominal_inv_after_ppn").val(cm);
       }

   });

   function PreviewImagePo() {
        pdffile=document.getElementById("files").files[0];
        pdffile_url=URL.createObjectURL(pdffile);
        
        $('#viewer').attr('href',pdffile_url);
    }

    function PreviewImageDo() {
        pdffile=document.getElementById("files_do").files[0];
        pdffile_url=URL.createObjectURL(pdffile);
        
        $('#viewer_do').attr('href',pdffile_url);
    }

    function PreviewImageSurat() {
        pdffile=document.getElementById("surat").files[0];
        pdffile_url=URL.createObjectURL(pdffile);
        
        $('#viewer_surat').attr('href',pdffile_url);
    }

    function PreviewImageInvoice() {
        pdffile=document.getElementById("files_invoice").files[0];
        pdffile_url=URL.createObjectURL(pdffile);
        
        $('#viewer_invoice').attr('href',pdffile_url);
    }

    function PreviewImageFaktur() {
        pdffile=document.getElementById("file_faktur").files[0];
        pdffile_url=URL.createObjectURL(pdffile);
        
        $('#viewer_faktur').attr('href',pdffile_url);
    }

    window.leadingZero = function(value, element, decimal = false) {
        var convert_number = removeChar(value);

        if(decimal) {
            if(value != '') {
            element.val(keyupFormatUangWithDecimal(value));
            } else {
            element.val(0);
            }
        } else {
            if(value != '') {
            element.val(keyupFormatUang(parseInt(convert_number)));
            } else {
            element.val(0);
            }
        }
    }

    function removeChar(value) {
        return value.toString().replace(/[.*+?^${}()|[\]\\]/g, '');
    }

    window.keyupFormatUang = function(value) {
        var number = '';    
        var value_rev = value.toString().split('').reverse().join('');
        
        for(var i = 0; i < value_rev.length; i++) {
            if(i % 3 == 0) number += value_rev.substr(i, 3) + '.';
        }
        
        return number.split('', number.length - 1).reverse().join('');
        }

        window.keyupFormatUangWithDecimal = function(value) {
        return value.replace(/^0+/, '').replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

</script>
@endsection