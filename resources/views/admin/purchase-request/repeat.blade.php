@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Repeat Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ 'PO Repeat' }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }
</style>
<form class="form-rn" action="{{ route("admin.quotation-repeat.store") }}" enctype="multipart/form-data" method="post">
    <div class="card">
        <div class="card-body">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.po_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', $po_no) }}" readonly> 
                        @if($errors->has('po_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('po_no') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.doc_type') }}</label>
                        <select class="form-control form-control-line select2 {{ $errors->has('doc_type') ? 'is-invalid' : '' }}" name="doc_type">
                            @foreach ($docTypes as $type)
                                <option value="{{ $type->code }}">{{ $type->code }} - {{ $type->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.purchase-order.fields.notes') }}</label>
                <textarea id="notes" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes"></textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="upload_file">{{ trans('cruds.purchase-order.fields.upload_file') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="file" name="upload_file[]" multiple id="upload_file">
                @if($errors->has('upload_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('upload_file') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Currency</label>
                        <select name="currency" id="currency" class="form-control select2" required>
                            @foreach($currency as $key => $value)
                                <option value="{{ $value->currency }}" @if($value->currency == 'IDR') selected @endif>
                                    {{ $value->currency }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Exchange Rate</label>
                        <input type="text" class="form-control form-control-line exchange_rate" name="exchange_rate" value="{{ old('exchange_rate', '') }}" disabled> 
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
                            <th style="width: 20%">History PO</th>
                            <th style="width: 20%">Original Price</th>
                            <th style="width: 20%">Net Price</th>
                            <th style="width: 14%">Delivery Date</th>
                            <th style="width: 64%">Tax</th>
                        </tr>
                    </thead>
                    {{-- get from rfq,  net_order_price untuk pricenya --}}
                    <tbody>
                        @foreach($data as $key => $value) 
                            <input type="hidden" name="id[]" value="{{ $value->id }}">
                            <tr>
                                <input type="hidden" name="plant_code[]" id="plant_code" value="{{ $value->plant_code }}">
                                <input type="hidden" name="doc_type[]" id="doc_type" value="{{ $value->doc_type }}">
                                <input type="hidden" name="pr_no[]" readonly value="{{ $value->pr_no }}">
                                <input type="hidden" name="request_date[]" readonly value="{{ $value->request_date }}">
                                <input type="hidden" name="rn_no[]" readonly value="{{ $value->request_no }}">
                                <input type="hidden" name="is_assets[]" readonly value="{{ $value->is_assets }}">
                                <input type="hidden" name="assets_no[]" readonly value="{{ $value->assets_no }}">
                                <input type="hidden" name="text_id[]" readonly value="{{ $value->text_id }}">
                                <input type="hidden" name="short_text[]" readonly value="{{ $value->short_text }}">
                                <input type="hidden" name="text_form[]" readonly value="{{ $value->text_form }}">
                                <input type="hidden" name="text_line[]" readonly value="{{ $value->text_line }}">
                                <input type="hidden" name="delivery_date_category[]" readonly value="{{ $value->delivery_date_category }}">
                                <input type="hidden" name="account_assignment[]" readonly value="{{ $value->account_assignment }}">
                                <input type="hidden" name="purchasing_group_code[]" readonly value="{{ $value->purchasing_group_code }}">
                                <input type="hidden" name="preq_name[]" readonly value="{{ $value->preq_name }}">
                                <input type="hidden" name="gl_acct_code[]" readonly value="{{ $value->gl_acct_code }}">
                                <input type="hidden" name="cost_center_code[]" readonly value="{{ $value->cost_center_code }}">
                                <input type="hidden" name="profit_center_code[]" readonly value="{{ $value->profit_center_code }}">
                                <input type="hidden" name="storage_location[]" readonly value="{{ $value->storage_location }}">
                                <input type="hidden" name="material_group[]" readonly value="{{ $value->material_group }}">
                                <input type="hidden" name="preq_item[]" readonly value="{{ $value->preq_item }}">
                                <input type="hidden" name="PR_NO[]" readonly value="{{ $value->PR_NO }}">
                                <input type="hidden" name="notes[]" value="{{ $value->notes }}">
                                <input type="hidden" name="category[]" value="{{ $value->category }}">
                                <input type="hidden" class="form-control material_id" name="material_id[]"  id="material_id" readonly value="{{ $value->material_id }}">
                                <input type="hidden" name="description[]" readonly value="{{ $value->description }}">
                                <input type="hidden" name="delivery_date[]" readonly value="{{ $value->delivery_date }}">
                                <input type="hidden" class="" name="unit[]" readonly value="{{ $value->unit }}">
                                <input type="hidden" class="" name="qty[]" readonly value="{{ empty($value->qty) ? 0 : $value->qty }}">
                                <td>{!! $value->material_id .'<br>'.$value->description !!}</td>
                                <td>{{ $value->unit }}</td>
                                <td>{{ empty($value->qty) ? 0 : $value->qty }}</td>
                                <td>
                                    <select name="history[]" id="history" class="select2 history" required>
                                        <option> -- Select --</option>
                                        @foreach(getHistoryPo($value->material_id) as $key => $rows)
                                            <option value="{{ $rows->price }}">{{ $rows->po['PO_NUMBER'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" class="original_price" name="original_price[]" id="original_price" value="" readonly></td>
                                <td><input type="text" class="net_price" name="price[]" id="net_price" value="" readonly></td>
                                <td><input type="text" class="mdate" name="delivery_date_new[]" id="delivery_date_new" value="{{ $value->delivery_date }}"></td>
                                <td><input type="checkbox" class="" id="check_{{ $value->id }}" name="tax_code[]" value="1">
                                    <label for="check_{{ $value->id }}">&nbsp;</label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                            <option>-- Select --</option>
                            @foreach ($vendor as $val)
                            <option 
                                value="{{ $val->code }}"
                                data-id="{{ $val->id }}"
                                data-name="{{ $val->name }}"
                                data-email="{{ $val->email }}"
                                data-address="{{ $val->address }}"
                                data-npwp="{{ $val->npwp }}"
                            >
                                {{ $val->code }} - {{ $val->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Payment Term</label>
                        <select name="payment_term" id="payment_term" class="form-control select2" required>
                            <option>-- Select --</option>
                            @foreach ($top as $val)
                            <option value="{{ $val->no_of_days }}">
                                {{ $val->payment_terms." - ".$val->no_of_days }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-actions">
                <input type="hidden" name="quantities" value="{{ $uri['quantities'] }}">
                <button type="submit" class="btn btn-success click" id="save"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                {{-- <a href="{{ route('admin.purchase-request.index') }}" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a> --}}
                <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
            </div>
        </div>
    </div>
</form>
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

    $('.rfq').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const purchasing_document = $(this).val()
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

    $('.history').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const price = $(this).val()
        const row = $(this).closest('tr')
        const net = row.find('.net_price')
        const ori = row.find('.original_price')

        if( price ) {
            let fixPrice = 0
            const rate = $(".exchange_rate").val()
            if( $("#currency").val() == 'USD' ) {
                fixPrice = price / rate
            } else {
                fixPrice = price
            }
            net.val(Math.round(fixPrice))
            ori.val(price)
        } else {
            net.val(0)
            ori.val(0)
        }
    })
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