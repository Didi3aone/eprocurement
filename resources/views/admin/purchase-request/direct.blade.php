@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Direct Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ 'Direct Order' }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form class="form-rn m-t-40" action="{{ route("admin.quotation-direct.store") }}" enctype="multipart/form-data" method="post">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ trans('cruds.purchase-order.fields.po_no') }}</label>
                                <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', $po_no) }}" readonly> 
                                @if($errors->has('po_no'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('po_no') }}
                                    </div>
                                @endif
                            </div>
                        </div> --}}
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
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Term Of Payment Desciption</label>
                                <input type="text" id="notes" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" value="{{ old('notes', '') }}" required>
                                @if($errors->has('notes'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('notes') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Currency</label>
                                <select name="currency" id="currency" class="form-control select2" required>
                                  
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
                <div class="card-body">
                    <div class="form-group">
                        <div class="table-responsive">
                            <table id="datatables-run" class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;padding-right:15px;">Material</th>
                                        <th style="width: 10%;padding-right:15px;">Unit</th>
                                        <th style="width: 10%;">Qty</th>
                                        <th style="width: 40%;padding-right:180px;">RFQ</th>
                                        <th style="width: 16%">Currency</th>
                                        <th style="width: 16%">Net Price</th>
                                        <th style="width: 16%">Original Price</th>
                                        <th style="width: 14%">Delivery Date PR</th>
                                        <th style="width: 14%">Delivery Date</th>
                                        <th style="width: 34%">Tax</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
                                        <tr>
                                            <input type="hidden" name="doc_type_pr[]" id="doc_type" value="{{ $value->doc_type }}">
                                            <input type="hidden" name="idDetail[]" id="idDetail" value="{{ $value->id }}">
                                            <input type="hidden" name="plant_code[]" id="plant_code" value="{{ $value->plant_code }}">
                                            <input type="hidden" name="pr_no[]" value="{{ $value->pr_no }}">
                                            <input type="hidden" name="request_date[]" value="{{ $value->request_date }}">
                                            <input type="hidden" name="rn_no[]" value="{{ $value->request_no }}">
                                            <input type="hidden" name="is_assets[]" value="{{ $value->is_assets }}">
                                            <input type="hidden" name="assets_no[]" value="{{ $value->assets_no }}">
                                            <input type="hidden" name="short_text[]" value="{{ $value->short_text }}">
                                            <input type="hidden" name="text_id[]" value="{{ $value->text_id }}">
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
                                            <input type="hidden" name="id[]" value="{{ $value->id }}">
                                            <input type="hidden" name="PR_NO[]" value="{{ $value->PR_NO }}">
                                            <input type="hidden" class="material_id" name="material_id[]" value="{{ $value->material_id }}">
                                            <input type="hidden" name="description[]" value="{{ $value->description }}">
                                            <input type="hidden" name="delivery_date[]" value="{{ $value->delivery_date }}">
                                            <input type="hidden" name="unit[]" value="{{ $value->unit }}">
                                            <input type="hidden" name="notes_detail[]" value="{{ $value->notes }}">
                                            <input type="hidden" name="category[]" value="{{ $value->category }}">
                                            <input type="hidden" class="qty" name="qty[]" value="{{ empty($value->qty) ? 0 : $value->qty }}">
                                            <input type="hidden" class="acp_id" name="acp_id[]" id="acp_id" value="0">
                                            <td>{!! $value->material_id .'<br>'.$value->description !!}</td>
                                            <td>{{ $value->unit }}</td>
                                            <td>{{ empty($value->qty) ? 0 : $value->qty }}</td>
                                            <td>
                                                @php
                                                    if( $value->material_id == '' ) {
                                                        $paramM = $value->description;
                                                    } else {
                                                        $paramM = $value->material_id;
                                                    }
                                                @endphp
                                                <select name="rfq[]" id="rfq" class="select2 rfq {{ $errors->has('rfq') ? 'is-invalid' : '' }}" required style="width:100%;">
                                                    <option value=""> Select </option>
                                                    @foreach(\App\Models\AcpTableMaterial::getAcp($paramM) as $key => $valus)
                                                    <option value="{{ $valus->acp_no }}" 
                                                        data-code="{{ $valus->code }}" 
                                                        data-currency="{{ $valus->currency }}"  
                                                        data-material="{{ $valus->material_id }}" 
                                                        data-acp="{{ $valus->acp_id }}">
                                                        {{ $valus->acp_no ." - ". $valus->name }}
                                                    </option>
                                                    @endforeach
                                                    @if($errors->has('rfq'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('rfq') }}
                                                        </div>
                                                    @endif
                                                </select>
                                            </td>
                                            <td><input type="text" class="original_currency" name="original_currency[]" id="original_currency" value="" readonly></td>
                                            <td><input type="text" class="net_price" name="price[]" id="net_price" value="" readonly></td>
                                            <td><input type="text" class="original_price" name="original_price[]" id="original_price" value="" readonly></td>
                                             <td>{{ $value->delivery_date }}</td>
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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Vendor</label>
                                <select name="vendor_id" id="vendor_id" class="form-control select2 {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" required>
                                </select>
                                @if($errors->has('vendor_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('vendor_id') }}
                                    </div>
                                @endif
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Payment Term</label>
                                <input type="text" class="payment_term form-control" name="payment_terms" id="payment_terms" value="" readonly>
                                <input type="hidden" class="payment_term form-control" name="payment_term" id="payment_term" value="" readonly>
                                {{-- <select name="payment_term" id="payment_term" class="form-control select2" disabled>
                                    <option value="">-- Select --</option>
                                    @foreach ($top as $val)
                                    <option value="{{ $val->payment_terms }}">
                                        {{ $val->no_of_days ." days" }}
                                    </option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required" for="upload_file">{{ trans('cruds.purchase-order.fields.upload_file') }}</label>
                        <input class="form-control {{ $errors->has('upload_file') ? 'is-invalid' : '' }}" type="file" name="upload_file[]" multiple id="upload_file">
                        @if($errors->has('upload_file'))
                            <div class="invalid-feedback">
                                {{ $errors->first('upload_file') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success click" id="save"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                        <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                        <button type="button" class="btn btn-warning preview" id="save"> <i class="fa fa-eye"></i> Preview</button>
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
    $(".exchange_rate").attr('disabled',true)
    $("#currency").on('change',function(e) {
        let id = $(this).val()      
        $(".exchange_rate").attr('disabled',false)
        handleChange()
    })

    $(".exchange_rate").on('keyup change', function(e) {
        handleChange()
    })
    $('.preview').on('click', function() {
        var $form = $('.form-rn')
        var link = $form.attr('action')
        var target = '{{ route('admin.purchase-request-repeat-confirmation') }}'
        $form.attr('target', '_blank')
        $form.attr('action', target)
        $form.submit()
        $form.attr('action', link)
        $form.removeAttr('target')
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

    const loadRfq = function () {
        $("#vendor_id").change(function() {
            const vendorId = $(this).val()
        }).trigger('change');
    }

    $('.rfq').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const purchasing_document = $(this).val()
        const row = $(this).closest('tr')
        const net = row.find('.net_price')
        const ori = row.find('.original_price')
        const url = '{{ route('admin.acp-net-price') }}'
        const materialId = row.find('.material_id')
        const qty  = row.find('.qty')
        const plant_code = $("#plant_code").val()
        const code = row.find('.rfq option:selected').data('code')
        const acp_id = row.find('.rfq option:selected').data('acp')
        const ori_curr = row.find('.rfq option:selected').data('currency')
        const materials = row.find('.rfq option:selected').data('material')

        row.find(".acp_id").val(acp_id)
        row.find('.original_currency').val(ori_curr)

        getVendor(code)
        getCurrency(ori_curr)

        $.getJSON(url,{'master_acp_id': acp_id ,'material' : materials,'vendor_id' : code}, function (items) {
            $("#image_loading").hide()
            if(items.master_acp_id) {
                let nets = items.price ? items.price : '0.00'
                net.val(nets)
                ori.val(nets)
            } else {
                net.val('0.00')
                ori.val('0.00')
            }
        })
    })

    function getVendor(code)
    {
        const url = '{{ route('admin.get-vendors') }}'
        const $vendor_id = $("#vendor_id")
        $.ajax({
            url: url,
            method: 'get',
            cache: false,
            data: {
                code: code
            },
            success: function (data) {
                $vendor_id.empty();
                for (var i = 0; i < data.length; i++) {
                    $vendor_id.append('<option value=' + data[i].code + ' data-payment='+data[i].payment_terms+'>'+data[i].code+' - '+ data[i].name +' </option>');
                }

                $vendor_id.change();
            }
        });
        oncange()
    }

    function getPayment(pay)
    {
        const url = '{{ route('admin.quotation-payment') }}'
        const $payment_term = $("#payment_term")
        $.getJSON(url, function(items) {
            let newOptions = ''
           // $("#payment_term").attr('disabled',true);

             for (var id in items) {
                let selected = ''
                if( pay == id ) {
                    selected = 'selected'
                    $("#payment_terms").val(items[id])
                    $("#payment_term").val(id)
                    console.log('yes')
                }
                newOptions += '<option value="'+ id +'" '+selected+'>'+ items[id] +'</option>';
            }

            $('#image_loading').hide()
            $payment_term.html(newOptions)
        });
    }

    function oncange() {
        $("#vendor_id").change(function() {
            let pay = $('#vendor_id option:selected').data('payment')
            //$("#payment_term").val(pay)
            getPayment(pay)
        })
    }

    function getCurrency(currency)
    {
        const url = '{{ route('admin.quotation-currency') }}'
        const $currency = $("#currency")
        $.getJSON(url, function(items) {
            let newOptions = ''

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
</script>
@endsection