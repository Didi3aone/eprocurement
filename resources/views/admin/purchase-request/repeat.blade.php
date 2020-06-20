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
@if(session('status'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" id="info-alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("admin.quotation-save-repeat") }}" enctype="multipart/form-data" method="post">
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
                                        {{ $val->payment_terms }}
                                    </option>
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
                                    <option>-- Select --</option>
                                    <option value="IDR">
                                        IDR
                                    </option>
                                    <option value="USD">
                                        USD
                                    </option>
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
                    <div class="form-group">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tabs">
                                <thead>
                                    <tr>
                                        <th>Material ID</th>
                                        <th>Material Desc</th>
                                        <th>Unit</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 20%">History PO</th>
                                        <th style="width: 20%">Net Price</th>
                                    </tr>
                                </thead>
                                {{-- get from rfq,  net_order_price untuk pricenya --}}
                                <tbody>
                                    @foreach($data as $key => $value) 
                                        <input type="hidden" name="id[]" value="{{ $value->id }}">
                                        <tr>
                                            <input type="hidden" name="plant_code[]" id="plant_code" value="{{ $value->plant_code }}">
                                            <input type="hidden" class="form-control" name="pr_no[]" readonly value="{{ $value->pr_no }}">
                                            <input type="hidden" class="form-control" name="request_date[]" readonly value="{{ $value->request_date }}">
                                            <input type="hidden" class="form-control" name="rn_no[]" readonly value="{{ $value->request_no }}">
                                            <input type="hidden" class="form-control" name="is_assets[]" readonly value="{{ $value->is_assets }}">
                                            <input type="hidden" class="form-control" name="assets_no[]" readonly value="{{ $value->assets_no }}">
                                            <input type="hidden" class="form-control" name="text_id[]" readonly value="{{ $value->text_id }}">
                                            <input type="hidden" class="form-control" name="text_form[]" readonly value="{{ $value->text_form }}">
                                            <input type="hidden" class="form-control" name="text_line[]" readonly value="{{ $value->text_line }}">
                                            <input type="hidden" class="form-control" name="delivery_date_category[]" readonly value="{{ $value->delivery_date_category }}">
                                            <input type="hidden" class="form-control" name="account_assignment[]" readonly value="{{ $value->account_assignment }}">
                                            <input type="hidden" class="form-control" name="purchasing_group_code[]" readonly value="{{ $value->purchasing_group_code }}">
                                            <input type="hidden" class="form-control" name="preq_name[]" readonly value="{{ $value->preq_name }}">
                                            <input type="hidden" class="form-control" name="gl_acct_code[]" readonly value="{{ $value->gl_acct_code }}">
                                            <input type="hidden" class="form-control" name="cost_center_code[]" readonly value="{{ $value->cost_center_code }}">
                                            <input type="hidden" class="form-control" name="profit_center_code[]" readonly value="{{ $value->profit_center_code }}">
                                            <input type="hidden" class="form-control" name="storage_location[]" readonly value="{{ $value->storage_location }}">
                                            <input type="hidden" class="form-control" name="material_group[]" readonly value="{{ $value->material_group }}">
                                            <input type="hidden" class="form-control" name="preq_item[]" readonly value="{{ $value->preq_item }}">
                                            <input type="hidden" class="form-control" name="PR_NO[]" readonly value="{{ $value->PR_NO }}">
                                            <td><input type="text" class="form-control material_id" name="material_id[]"  id="material_id" readonly value="{{ $value->material_id }}"></td>
                                            <td><input type="text" class="form-control" name="description[]" readonly value="{{ $value->description }}"></td>
                                            <td><input type="text" class="form-control" name="unit[]" readonly value="{{ $value->unit }}"></td>
                                            <td><input type="text" class="form-control" name="qty[]" readonly value="{{ empty($value->qty) ? 0 : $value->qty }}"></td>
                                            <td>
                                                <select name="history[]" id="history" class="form-control select2 history" required>
                                                    <option> -- Select --</option>
                                                    @foreach(getHistoryPo($value->material_id) as $key => $rows)
                                                        <option value="{{ $rows->price }}">{{ $rows->po['po_no']." - ".$rows->po->vendors['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control net_price" name="price[]" id="net_price" value="" readonly></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="quantities" value="{{ $uri['quantities'] }}">
                        <button type="submit" class="btn btn-success click" id="save"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.purchase-request.index') }}" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                        <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                        <button type="button" class="btn btn-primary"> <i class="fa fa-eye"></i> {{ trans('global.preview') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>

    $("#currency").on('change',function(e) {
        let id = $(this).val()
        
        if( id == 'USD' ) {
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
            
            if( id == 'USD' ) {
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
        const url = '{{ route('admin.rfq-get-net-price') }}'
        const materialId = row.find('.material_id')
        const plant_code = $("#plant_code").val()

        $.getJSON(url,{'purchasing_document': purchasing_document,'plant' : plant_code }, function (items) {
            $("#image_loading").hide()
            if(items.purchasing_document) {
                let nets = items.net_order_price ? items.net_order_price : 'Not found RFQ price'
                net.val(nets)
            } else {
                net.val('Not found RFQ price')
            }
        })
    })

    $('.history').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const price = $(this).val()
        const row = $(this).closest('tr')
        const net = row.find('.net_price')

        if( price ) {
            let fixPrice = 0
            const rate = $(".exchange_rate").val()
            if( $("#currency").val() == 'USD' ) {
                fixPrice = price / rate
            } else {
                fixPrice = price
            }
            net.val(Math.round(fixPrice))
        } else {
            net.val(0)
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