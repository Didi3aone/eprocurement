@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ 'Purchase Order' }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form class="form-material m-t-40" method="POST" action="{{ route("admin.purchase-order.update", [$purchaseOrder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>PO Number</label>
                        <input type="text" class="form-control form-control-line" readonly name="PO_NUMBER" value="{{ $purchaseOrder->PO_NUMBER ?? old('PO_NUMBER', '') }}"> 
                        @if($errors->has('PO_NUMBER'))
                            <div class="invalid-feedback">
                                {{ $errors->first('PO_NUMBER') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Term Of Payment Desciption</label>
                        <textarea type="text" disabled class="form-control form-control-line" name="notes">{{ $purchaseOrder->notes ?? old('notes', '') }}</textarea>
                        @if($errors->has('notes'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notes') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Currency</label>
                                <input type="text" class="form-control form-control-line exchange_rate" name="currency" value="{{ $purchaseOrder->currency }}" readonly> 
                                {{-- <select name="currency" id="currency" class="form-control select2" required>
                                    @foreach($currency as $key => $value)
                                        <option value="{{ $value->currency }}" @if($value->currency == $purchaseOrder->currency) selected @endif>
                                            {{ $value->currency }}
                                        </option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                            <div class="form-group">
                                <label>Exchange Rate</label>
                                <input type="text" class="form-control form-control-line exchange_rate" name="exchange_rate" value="" @if($purchaseOrder->currency == 'IDR') disabled @endif> 
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Vendor</label>
                                <input type="text" class="form-control form-control-line" readonly name="vendor_id" value="{{ $purchaseOrder->vendors['name'] }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Payment Term</label>
                                <select name="payment_term" id="payment_term" class="form-control select2" disabled>
                                    <option>-- Select --</option>
                                    @foreach ($top as $val)
                                    <option value="{{ $val->payment_terms }}" @if($val->payment_terms == $purchaseOrder->payment_term) selected @endif>
                                        {{ $val->no_of_days." days" }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables-run" class="table table-condesed">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Material</th>
                                    <th style="width: 5%">Unit</th>
                                    <th style="width: 10%">Qty</th>
                                    <th style="width: 20%">Net Price</th>
                                    <th style="width: 14%">Delivery Date</th>
                                    <th style="width: 64%">Tax</th>
                                    <th style="width: 64%">Delivery Complete</th>
                                    <th style="width: 64%">
                                        {{-- <button type="button" id="add_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button> --}}
                                    </th>
                                </tr>
                             </thead>
                            <tbody id="poItem">
                                @foreach($purchaseOrder->orderDetail as $key => $value) 
                                    @php
                                        $readonly = '';
                                        $disabled = '';
                                        if( $value->is_gr == \App\Models\PurchaseOrdersDetail::YesGr ) {
                                            $readonly = 'readonly';
                                            $disabled = 'disabled';
                                        }
                                    @endphp
                                    @if($value->is_active == \App\Models\PurchaseOrdersDetail::Active)
                                    <tr id="item_{{ $key }}">
                                        <input type="hidden" class="id" name="idDetail[]" id="id" value="{{ $value->id }}">
                                        <input type="hidden" class="id" name="idPrDetail[]" id="idPrDetail" value="">
                                       <td>{{ $value->material_id." - ". $value->description }}</td>
                                       <td>{{ $value->unit }}</td>
                                       <td><input type="text" class="qty" name="qty[]" id="qty" {{ $readonly }} value="{{ $value->qty }}"></td>
                                       <td><input type="text" class="price" name="price[]" id="price" {{ $readonly }} value="{{ $value->price }}"</td>
                                       <td><input type="text" class="delivery_date mdate" disabled name="delivery_date[]" id="delivery_date" value="{{ $value->delivery_date }}"></td>
                                       <td>
                                            <input type="checkbox" class="" id="check_{{ $value->id }}" name="tax_code[]" value="1"
                                                @if($value->tax_code == 'V1') checked @endif>
                                            <label for="check_{{ $value->id }}">&nbsp;</label>
                                       </td>
                                       <td>
                                            <input type="checkbox" class="" id="checks_{{ $key }}" name="delivery_complete[]" value="1">
                                            <label for="checks_{{ $key }}">&nbsp;</label>
                                       </td>
                                       <td>
                                            @if( $value->is_gr == \App\Models\PurchaseOrdersDetail::NoGr )
                                            <a href="javascript:;" data-key="{{ $key }}" data-id="{{ $value->id }}" data-po="{{ $purchaseOrder->PO_NUMBER }}"  class="remove-item btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                            @endif
                                       </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success click" id="save"> <i class="fa fa-save"></i> {{ trans('global.update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $('#datatables-run').DataTable({
        "searching": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bInfo": false,
        "ordering": false
    });

    let index = 1
    $(document).ready(function() {
        $('#add_item').on('click', function (e) {
        e.preventDefault()

        let html = `
                 <tr data-id="${index}">
                    <input type="hidden" class="id" name="idDetail[]" id="id" value="">
                    <input type="hidden" class="id" name="idPrDetail[]" id="idPrDetail_${index}" value="">
                    <td><select name="material_id[]" id="material_id_${index}" class="material_id select2 form-control"></select></td>
                    <td><input type="text" class="unit" name="unit[]" id="unit_${index}" value=""></td>
                    <td><input type="text" class="qty" name="qty[]" id="qty_${index}" value=""></td>
                    <td><input type="text" class="price" name="price[]" id="price" value=""</td>
                    <td><input type="text" class="delivery_date" id="mdate" name="delivery_date[]" id="delivery_date" value=""></td>
                    <td>
                        <input type="checkbox" class="" id="check_${index}" name="tax_code[]" value="1">
                        <label for="check_${index}">&nbsp;</label>
                    </td>
                    <td>
                        <a href="javascript:;" data-id="" class="remove-item btn btn-danger btn-xs">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            `

            $('#poItem').append(html)
            $('.select2').select2();
            listMaterial(index)
            index++
        })
    })

    $("#currency").on('change',function(e) {
        let id = $(this).val()
        
        if( id != 'IDR' ) {
            $(".exchange_rate").attr('disabled',false)
        } else {
            $(".exchange_rate").val(' ')
            $(".exchange_rate").attr('disabled',true)
        }
    })

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }

    $('.money').mask('#.##0', { reverse: true });

    const loadChangeRate = function () {
        $("#currency").on('change',function(e) {
            let id = $(this).val()
            
            if( id != 'IDR' ) {
                $(".exchange_rate").attr('disabled',false)
            } else {
                $(".exchange_rate").val(' ')
                $(".exchange_rate").attr('disabled',true)
            }
        }).trigger('change');
    }

    $(document).on('click','.remove-item',function(e){
        e.preventDefault()
        let id = $(this).data('id');
        let deleteFile = confirm("Do you really want to Delete?");
        const $key = $(this).data('key')

        if (deleteFile == true) {
            $.ajax({
                url: '{{ route("admin.purchase-order-destroy") }}',
                type: 'PUT',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:id
                },
                success: function(response){
                    if( response.success == true ) {
                        $("#item_" + $key).remove()
                    } else {
                        swal('Oops',response.message,'error')
                    }
                }
            });
        }
    });

    $('.history').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const row = $(this).closest('tr')
        const price = row.find('option:selected').data('price')
        const net = row.find('.net_price')
        const ori = row.find('.original_price')
        const code = row.find('option:selected').data('vendor')
        const qty = row.find('.qty').val()

        getVendors(code)
        if( price ) {
            let fixPrice = 0
            const rate = $(".exchange_rate").val()
            if( $("#currency").val() != 'IDR' ) {
                fixPrice = ((price * rate) * qty)
            } else {
                fixPrice = (price * qty)
            }
            
            const oriPrice = (price * qty)
            net.val(fixPrice)
            ori.val(price * qty)
        } else {
            net.val(0)
            ori.val(0)
        }
    })

    function listMaterial (i) {
        const url = '{{ route('admin.get-material-pr') }}'
        const $material_id = $('#material_id_'+ i);
        $('#image_loading').show()

        $.getJSON(url, function (data) {
            $material_id.empty();
            $material_id.append('<option value="">-- Select --</option>');

            for (var i = 0; i < data.length; i++) {
                $material_id.append(
                    '<option value='+data[i].code+' data-unit='+data[i].unit+' data-qty='+data[i].qty+' data-id='+data[i].id+'>' + data[i].code +' - '+ data[i].description +' </option>');
            }

            $('#image_loading').hide()
            $material_id.change();
        });

        $('.select2').select2()
        oncange(i);
    }

    function oncange(i) {
        $("#material_id_" + i).change(function() {
            let unit = $('#material_id_'+ i +' option:selected').data('unit')
            let qty = $('#material_id_'+ i +' option:selected').data('qty')
            let idz = $('#material_id_'+ i +' option:selected').data('id')
            $("#unit_"+i).val(unit)
            $("#qty_"+i).val(qty)
            $("#idPrDetail_"+i).val(idz)
        })
    }

    function getVendors(code)
    {
        const url = '{{ route('admin.get-vendors') }}'
        const $vendor_id = $("#vendor_id")
        $.getJSON(url, { 'code' : code}, function(items) {
            let newOptions = ''

             for (var id in items) {
                newOptions += '<option value="'+ id +'">'+ items[id] +'</option>';
            }

            $('#image_loading').hide()
            $vendor_id.html(newOptions)
        });
    }

    loadChangeRate()
</script>
@endsection