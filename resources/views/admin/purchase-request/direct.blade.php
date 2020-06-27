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
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("admin.quotation-direct.store") }}" enctype="multipart/form-data" method="post">
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
                    <div class="form-group">
                        <div class="table-responsive" style="overflow-x:scroll;">
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;padding-right:15px;">Material</th>
                                        <th style="width: 10%;padding-right:15px;">Unit</th>
                                        <th style="width: 10%;">Qty</th>
                                        <th style="width: 20%">RFQ</th>
                                        <th style="width: 16%">Net Price</th>
                                        <th style="width: 14%">Delivery Date</th>
                                        <th style="width: 34%">Delivery Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
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
                                            <input type="hidden" class="form-control" name="id[]" readonly value="{{ $value->id }}">
                                            <input type="hidden" class="form-control" name="PR_NO[]" readonly value="{{ $value->PR_NO }}">
                                            <input type="hidden" class="form-control material_id" name="material_id[]" readonly value="{{ $value->material_id }}">
                                            <input type="hidden" class="form-control" name="description[]" readonly value="{{ $value->description }}">
                                            <input type="hidden" class="form-control" name="delivery_date[]" readonly value="{{ $value->delivery_date }}">
                                            <td>{!! $value->material_id .'<br>'.$value->description !!}</td>
                                            <td><input type="text" class="form-control" name="unit[]" readonly value="{{ $value->unit }}"></td>
                                            <td><input type="text" class="form-control qty" name="qty[]" readonly value="{{ empty($value->qty) ? 0 : $value->qty }}"></td>
                                            <td>
                                                <input type="hidden" class="form-control acp_id" name="acp_id" id="acp_id" value="0">
                                                <select name="rfq[]" id="rfq" class="form-control select2 rfq" required>
                                                    <option value="0"> Select </option>
                                                    @foreach(\App\Models\Rfq::getRFQ($value->material_id) as $key => $valus)
                                                    <option value="{{ $valus->purchasing_document }}" data-code="{{ $valus->code }}" data-acp="{{ $valus->acp_id }}">{{ $valus->purchasing_document." - ". $valus->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control net_price" name="price[]" id="net_price" value="" readonly></td>
                                            <td>{{ $value->delivery_date }}</td>
                                            <td><input type="text" class="form-control mdate" name="delivery_date_new[]" id="delivery_date_new" value=""></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Vendor</label>
                        <div class="row">
                            <div class="col-lg-9">
                                <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.notes') }}</label>
                        <input type="text" id="notes" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" value="{{ old('notes', '') }}" required>
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

                    <div class="form-actions">
                        {{-- <input type="hidden" name="id" value="{{ $uri['ids'] }}"> --}}
                        <button type="submit" class="btn btn-success click" id="save"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                        {{-- <button type="submit" class="btn btn-success click"> <i class="fa fa-tv"></i> {{ trans('global.preview') }}</button> --}}
                        <a href="{{ route('admin.purchase-request.index') }}" class="btn btn-inverse">Cancel</a>
                        <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
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
    let index = 1
    $("#currency").on('change',function(e) {
        let id = $(this).val()
        
        if( id == 'USD' ) {
            $(".exchange_rate").attr('disabled',false)
        } else {
            $(".exchange_rate").val(' ')
            $(".exchange_rate").attr('disabled',true)
        }
    })

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

    loadChangeRate()

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
            //getRq(vendorId)
        }).trigger('change');
    }

    $('.rfq').on('change', function (e) {
        e.preventDefault()
        $("#image_loading").show()
        const purchasing_document = $(this).val()
        const row = $(this).closest('tr')
        const net = row.find('.net_price')
        const url = '{{ route('admin.rfq-get-net-price') }}'
        const materialId = row.find('.material_id')
        const qty  = row.find('.qty')
        const plant_code = $("#plant_code").val()
        const code = row.find('.rfq option:selected').data('code')
        const acp_id = row.find('.rfq option:selected').data('acp')
        row.find(".acp_id").val(acp_id)

        getVendor(code)

        $.getJSON(url,{'purchasing_document': purchasing_document }, function (items) {
            $("#image_loading").hide()
            if(items.purchasing_document) {
                let nets = items.net_order_price ? items.net_order_price : '0'
                let price = qty.val() * nets
                net.val(parseFloat(price).toFixed(2))
            } else {
                net.val('0')
            }
        })
    })

    function getVendor(code)
    {
        const url = '{{ route('admin.get-vendors') }}'
        const $vendor = $("#vendor_id");
        $.getJSON(url, {'code' : code}, function (items) {
            let newOptions = ''

            for (var id in items) {
                newOptions += '<option value="'+ id +'">'+ items[id] +'</option>'
            }
            $vendor.html(newOptions)
            $('.select2').select2()
        })
    }

    //loadRfq()//
</script>
@endsection