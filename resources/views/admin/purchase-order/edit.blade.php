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
                        <textarea type="text" class="form-control form-control-line" name="notes">{{ $purchaseOrder->notes ?? old('notes', '') }}</textarea>
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
                                <select name="currency" id="currency" class="form-control select2" required>
                                    @foreach($currency as $key => $value)
                                        <option value="{{ $value->currency }}" @if($value->currency == $purchaseOrder->currency) selected @endif>
                                            {{ $value->currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Exchange Rate</label>
                                <input type="text" class="form-control form-control-line exchange_rate" name="exchange_rate" value="" @if($purchaseOrder->currency == 'IDR') disabled @endif> 
                            </div>
                        </div>
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
                                <select name="payment_term" id="payment_term" class="form-control select2" required>
                                    <option>-- Select --</option>
                                    @foreach ($top as $val)
                                    <option value="{{ $val->payment_terms }}" @if($val->payment_terms == $purchaseOrder->payment_terms) selected @endif>
                                        {{ $val->payment_terms." - ".$val->no_of_days }}
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
                                    <th style="width: 20%">Material</th>
                                    <th style="width: 5%">Unit</th>
                                    <th style="width: 10%">Qty</th>
                                    <th style="width: 20%">Net Price</th>
                                    <th style="width: 14%">Delivery Date</th>
                                    <th style="width: 64%">Tax</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchaseOrder->orderDetail as $key => $value) 
                                    <tr>
                                       <td>{{ $value->material_id." - ". $value->description }}</td>
                                       <td>{{ $value->unit }}</td>
                                       <td><input type="text" class="qty" name="qty[]" id="qty" value="{{ $value->qty }}"></td>
                                       <td><input type="text" class="price" name="price[]" id="price" value="{{ $value->price }}"</td>
                                       <td>{{ $value->delivery_date }}</td>
                                       <td>
                                            <input type="checkbox" class="" id="check_{{ $value->id }}" name="tax_code[]" value="1"
                                                @if($value->tax_code == 1) checked @endif>
                                            <label for="check_{{ $value->id }}">&nbsp;</label>
                                       </td>
                                    </tr>
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

    /*function getRq(vendorId)
    {
        $("#image_loading").show()

        const url = '{{ route('admin.rfq-get-by-vendor') }}'
        const row = $(this).closest('tr')

        $rfq = $(".rfq");
        $.ajax({
            url: url,
            data: {
                vendor_id : vendorId
            },
            success: function (data) {
                $("#image_loading").hide()
                $rfq.empty()
                $rfq.append('<option value="">-- Select --</option>')

                for (var i = 0; i < data.length; i++) {
                    $rfq.append('<option value=' + data[i].purchasing_document + '>'+ data[i].purchasing_document +' </option>');
                }

                $rfq.change()
            }
        });
        $('.select2').select2()
    }*/

    /**$('.rfq').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const purchasing_document = $(this).data()
        const row = $(this).closest('tr')
        const net = row.find('.net_price')
        const ori = row.find('.original_price')
        const url = '{{ route('admin.rfq-get-net-price') }}'
        const materialId = row.find('.material_id')
        const plant_code = $("#plant_code").val()

        $.getJSON(url,{'purchasing_document': purchasing_document,'plant' : plant_code }, function (items) {
            $("#image_loading").hide()
            if(items.purchasing_document) {
                let nets = items.net_order_price ? items.net_order_price : 'Not found RFQ price'
                net.val(nets)
                ori.val(nets)
            } else {
                net.val('Not found RFQ price')
                ori.val(nets)
            }
        })
    })
    */

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

    /*$(document).on('keyup', '.exchange_rate', function(event) {
        numberWithComma($(this).val())
    });

    function numberWithComma(number) {
        let numbers         = number + ''
        let components      = numbers.split(".");
            components [0]  = components [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return components.join(".");
    }*/
</script>
@endsection