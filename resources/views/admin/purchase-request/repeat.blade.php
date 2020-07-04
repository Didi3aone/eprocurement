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
                <label>Term Of Payment Desciption</label>
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
                            {{-- @foreach($currency as $key => $value)
                                <option value="{{ $value->currency }}" @if($value->currency == 'IDR') selected @endif>
                                    {{ $value->currency }}
                                </option>
                            @endforeach --}}
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
                            <th style="width: 20%">Currency</th>
                            <th style="width: 20%">Original Price</th>
                            <th style="width: 20%">Net Price</th>
                            <th style="width: 14%">Delivery Date</th>
                            <th style="width: 64%">Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <a class="btn btn-primary conversi" href="javascript:void(0)"><i class="fa fa-money"></i> Conversion</a> --}}
                        @foreach($data as $key => $value) 
                            <tr>
                                <input type="hidden" name="id[]" value="{{ $value->id }}">
                                <input type="hidden" name="idDetail[]" value="{{ $value->id }}">
                                <input type="hidden" name="plant_code[]" id="plant_code" value="{{ $value->plant_code }}">
                                <input type="hidden" name="doc_type_detail[]" id="doc_type" value="{{ $value->doc_type }}">
                                <input type="hidden" name="pr_no[]" value="{{ $value->pr_no }}">
                                <input type="hidden" name="request_date[]" value="{{ $value->request_date }}">
                                <input type="hidden" name="rn_no[]" value="{{ $value->request_no }}">
                                <input type="hidden" name="is_assets[]" value="{{ $value->is_assets }}">
                                <input type="hidden" name="assets_no[]" value="{{ $value->assets_no }}">
                                <input type="hidden" name="text_id[]" value="{{ $value->text_id }}">
                                <input type="hidden" name="short_text[]" value="{{ $value->short_text }}">
                                <input type="hidden" name="text_form[]" value="{{ $value->text_form }}">
                                <input type="hidden" name="text_line[]" value="{{ $value->text_line }}">
                                <input type="hidden" name="delivery_date_category[]" value="{{ $value->delivery_date_category }}">
                                <input type="hidden" name="account_assignment[]" value="{{ $value->account_assignment }}">
                                <input type="hidden" name="purchasing_group_code[]" value="{{ $value->purchasing_group_code }}">
                                <input type="hidden" name="preq_name[]" value="{{ $value->preq_name }}">
                                <input type="hidden" name="gl_acct_code[]" value="{{ $value->gl_acct_code }}">
                                <input type="hidden" name="cost_center_code[]" value="{{ $value->cost_center_code }}">
                                <input type="hidden" name="profit_center_code[]" value="{{ $value->profit_center_code }}">
                                <input type="hidden" name="storage_location[]" value="{{ $value->storage_location }}">
                                <input type="hidden" name="material_group[]" value="{{ $value->material_group }}">
                                <input type="hidden" name="preq_item[]" value="{{ $value->preq_item }}">
                                <input type="hidden" name="PR_NO[]" value="{{ $value->PR_NO }}">
                                <input type="hidden" name="notes_detail[]" value="{{ $value->notes }}">
                                <input type="hidden" name="category[]" value="{{ $value->category }}">
                                <input type="hidden" class="form-control material_id" name="material_id[]"  id="material_id" readonly value="{{ $value->material_id }}">
                                <input type="hidden" name="description[]" value="{{ $value->description }}">
                                <input type="hidden" name="delivery_date[]" value="{{ $value->delivery_date }}">
                                <input type="hidden" class="" name="unit[]" readonly value="{{ $value->unit }}">
                                <input type="hidden" class="qty" name="qty[]" readonly value="{{ empty($value->qty) ? 0 : $value->qty }}">
                                <td>{!! $value->material_id .'<br>'.$value->description !!}
                                    @php
                                        $hist = \sapHelp::getHistoryPo($value->material_id);
                                    @endphp
                                </td>
                                <td>{{ $value->unit }}</td>
                                <td>{{ empty($value->qty) ? 0 : $value->qty }}</td>
                                <td>
                                    <select name="rfq[]" id="history" class="select2 history" required>
                                        <option> -- Select --</option>
                                        @if( !empty($hist['header']->item) )
                                            @foreach($hist['header']->item as $key => $rows)
                                                @if(!empty($rows->EBELN))
                                                    <option value="{{ $rows->EBELN }}"
                                                        data-price="{{ $hist['detail']->item[$key]->NETPR }}"
                                                        data-vendor="{{ substr($rows->LIFNR,3) }}"
                                                        data-currency="{{ $rows->WAERS }}">
                                                        {{ $rows->EBELN."/".$rows->LIFRE }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td><input type="text" class="original_currency" name="original_currency[]" id="original_currency" value="" readonly></td>
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
                           
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Payment Term</label>
                        <select name="payment_term" id="payment_term" class="form-control select2">
                            <option value="">-- Select --</option>
                            @foreach ($top as $val)
                            <option value="{{ $val->payment_terms }}">
                                {{ $val->no_of_days." days" }}
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
    $(".exchange_rate").attr('disabled',true)
    $("#currency").attr('disabled',true);
    $("#currency").on('change',function(e) {
        let id = $(this).val()      
        $(".exchange_rate").attr('disabled',false)
        handleChange()
    })
    $(".exchange_rate").on('keyup change', function(e) {
        handleChange()
    })
    function handleChange() {
        $tr = $('#datatables-run tbody tr')
        var $ex = $('.exchange_rate').val()
        $ex = $ex===''? '1': $ex
        $.each($tr, function(i, $el) {
            var $ori = $($el).find('.original_currency').val()
            var $curr = $("#currency").val()
            var ori = $($el).find('.original_price').val()
            ori = ori===''? '1': ori
            var $net = $($el).find('.net_price')
            var update = parseFloat(ori) * parseFloat($ex)
            if($ori!== $curr) {
                $net.val(parseInt(update))
            }
        })
    }

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

    $('.history').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const row = $(this).closest('tr')
        const price = row.find('option:selected').data('price')
        const oriCurrency = row.find('option:selected').data('currency')
        const net = row.find('.net_price')
        const ori = row.find('.original_price')
        const code = row.find('option:selected').data('vendor')
        const qty = row.find('.qty').val()
        const oriCurr = row.find('.original_currency').val(oriCurrency)

        getVendors(code)
        getCurrency(oriCurrency)

        if( price ) {
            
            net.val(price * 100)
            ori.val(price * 100)
        } else {
            net.val(0)
            ori.val(0)
        }
    })

    function getCurrency(currency)
    {
        const url = '{{ route('admin.quotation-currency') }}'
        const $currency = $("#currency")
        $.getJSON(url, function(items) {
            let newOptions = ''
            $("#currency").attr('disabled',false);

             for (var id in items) {
                let selected = ''
                if( currency == items[id] ) {
                    selected = 'selected'
                }
                newOptions += '<option value="'+ id +'" '+selected+'>'+ items[id] +'</option>';
            }

            $('#image_loading').hide()
            $currency.html(newOptions)
        });
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
</script>
@endsection