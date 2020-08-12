@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.master-acp.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.master-acp.store") }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    {{-- <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.acp_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('acp_no') ? 'is-invalid' : '' }}" name="acp_no" value="{{ $acp_no ?? old('acp_no', '') }}" required> 
                        @if($errors->has('acp_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('acp_no') }}
                            </div>
                        @endif
                    </div> --}}
                    <div class="form-group">
                        <label>Plant</label>
                        <select class="form-control select2 form-control-line" name="plant_id" required> 
                            <option value="">-- Select --</option>
                            @foreach($plant ?? '' as $code => $name)
                                <option value="{{ $code }}">{{ $code." - ".$name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>Material From PR</label>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox11" name="is_from_pr" value="1">
                            <label class="form-check-label" for="inlineCheckbox11">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox22" name="is_from_pr" value="0" checked>
                            <label class="form-check-label" for="inlineCheckbox22">No</label>
                        </div>
                    </div>
                    <label>Project</label>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input material-inputs" type="radio" id="inlineCheckbox1" name="is_project" value="1">
                            <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input material-inputs" type="radio" id="inlineCheckbox2" name="is_project" value="0" checked>
                            <label class="form-check-label" for="inlineCheckbox2">No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Reference Acp No</label>
                        <select class="form-control select2 form-control-line" name="reference_acp_no"> 
                            <option value="">-- Select --</option>
                            @foreach($acpNo ?? '' as $key => $value)
                                <option value="{{ $value->acp_no }}">{{ $value->acp_no }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.currency') }}</label>
                        <select name="currency" id="currency" class="form-control select2" required>
                            @foreach($currency as $key => $value)
                                <option value="{{ $value->currency }}" @if($value->currency == 'IDR') selected @endif>
                                    {{ $value->currency }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.start_date') }}</label>
                        <input type="text" class="mdate form-control form-control-line {{ $errors->has('start_date') ? 'is-invalid' : '' }}" name="start_date" value="{{ date('Y-m-d') }}" required> 
                        @if($errors->has('start_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.end_date') }}</label>
                        <input type="text" class="mdate form-control form-control-line {{ $errors->has('end_date') ? 'is-invalid' : '' }}" name="end_date" value="{{ date('Y-m-d') }}" required> 
                        @if($errors->has('end_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" class="form-control form-control-line {{ $errors->has('upload_file') ? 'is-invalid' : '' }}" multiple name="upload_file[]" value=""> 
                    </div>
                    <hr style="margin: 30px 0">
                    <div class="form-group">
                        <label for="">{{ trans('cruds.master-acp.invite_vendor') }}</label>
                        <div class="row">
                            <div class="col-lg-9">
                                <select name="search-vendor" id="search-vendor" class="form-control select2">
                                    <option>-- Select --</option>
                                    @foreach ($vendor as $val)
                                    <option 
                                        value="{{ $val->code }}"
                                        data-id="{{ $val->id }}"
                                        data-title="{{ $val->title }}"
                                        data-name="{{ $val->company_name }}"
                                        data-email="{{ $val->email }}"
                                        data-street="{{ $val->street }}"
                                        data-city="{{ $val->city }}"
                                    >
                                        {{ $val->code." - ".$val->company_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <button id="btn-search-vendor" class="btn btn-info"><i class="fa fa-check"></i> Add Vendor</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Vendor Code</th>
                                        <th>Vendor Name</th>
                                        <th>Email</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="vendors"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea type="text" class="form-control form-control-line" name="description"></textarea>
                    </div>
                    <div class="form-actions">
                        {{-- <button type="submit" class="d-none">Submit</button> --}}
                        <button type="submit" class="btn btn-success" id="saves"> <i class="fa fa-save"></i> {{ trans('global.save') }}</button>
                        <button type="button" class="btn btn-warning preview" id="preview"> <i class="fa fa-eye"></i> Preview</button>
                        <a href="{{ route('admin.master-acp.index') }}" type="button" class="btn btn-inverse pull-right"><i class="fa fa-arrow-left"></i> Cancel</a>
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
    $(".preview").click(function() {
        var $form = $('.card-body form')
        $form.attr('target','_blank')
        var link = $form.attr('action')
        var target = '{{ route('admin.master-acp-confirmation') }}'
        $form.attr('action', target)
        $form.submit();
        $form.removeAttr('target')
        $form.attr('action', link)
    })

    $('#saves').click(function() {
        checked = $("input[type=checkbox]:checked").length;
        vendorGet = $(".vendor_id").length

       /* if( vendorGet < 3 ) {
            swal('Oops','Please choose at least 3 vendors','error')
            return false;
        }*/
        //console.log(vendorGet)
        if(!checked) {
            swal('Oops','Please check winner vendor','error')
            return false;
        }

        if( checked > 1 ) {
            swal('Oops','Choose the winner of one vendor','error')
            return false;
        }
        $("#saves").attr('disabled', 'disabled');
        $('#saves').text('Please wait ...')
        return true;
    });


    /**$("#saves").click(function(e) { 
        e.preventDefault()
        let winnerS = $('.wines').val() 

        $.each(winnerS,function($i,$el) {
            let elementWin = $($el).find('wines').val()

            console.log()
        })

    })**/
    /**<td class="file_attachment">
        <input type="file" name="file_attachment_${vendor}[]" class="form-control"/>
    </td>**/
    function rowMaterial (vendor,indexs) {
        return `
            <tr>
                <td>${indexs}</td>
                <td>
                    <select name="material_${vendor}[]" id="" class="choose-material form-control select2"></select>
                </td>
                <td>
                    <select name="currency_${vendor}[]" id="" class="choose-currency form-control select2"></select>
                </td>
                <td class="price">
                    <input type="text" name="price_${vendor}[]" class="prices form-control"/>
                </td>
                <td class="qty">
                    <input type="text" name="qty_${vendor}[]" class="form-control" required/>
                </td>
                <td class="qty_pr">
                    <input type="text" name="qty_pr_${vendor}[]" class="form-control" required/>
                </td>
                <td>
                    <button 
                        class="remove-material btn btn-xs btn-danger" 
                        onclick="this.parentNode.parentNode.remove()"
                    >
                        <i class="fa fa-trash"></i> Remove
                    </button>
                </td>
            </tr>
        `
    }

    $(document).on('click', '#btn-search-vendor', function (e) {
        e.preventDefault()

        const $search = $('#search-vendor').children('option:selected')
        $search.attr('disabled', 'disabled')
        const input_vendor = $search.val()
        const $vendorId = $("#search-vendor").val()
        $('#search-vendor').val('').trigger('change')
        $('#search-vendor').select2()

        if (input_vendor != '-- Select --') {
            const id_vendor = $search.data('id')
            const name_vendor = $search.data('name')
            const email_vendor = $search.data('email')

            let template = `
                <tr>
                    <td>${input_vendor}</td>
                    <td>${name_vendor}</td>
                    <td>${email_vendor}</td>
                    <td class="text-right">
                        <input type="hidden" name="vendor_id[]" class="vendor_id" value="${input_vendor}">
                        <input type="checkbox" name="winner_${input_vendor}" id="winner_${input_vendor}" value="1"/>
                        <label for="winner_${input_vendor}">Winner</label>
                        <button class="add_material btn btn-success btn-xs" data-vendor="${input_vendor}">
                            <i class="fa fa-plus-square"></i> Add Material
                        </button>
                        <a href="javascript:;"
                            data-vendor="${input_vendor}"
                            class="remove-vendor btn btn-xs btn-danger" 
                        >
                            <i class="fa fa-trash"></i> Remove
                        </a>
                    </td>
                </tr>
                <tr class="material-${input_vendor}">
                    <td colspan="4" style="overflow-x:auto">
                        <table class="table table-striped" style="overflow-x:auto">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width: 30%;padding-right:18px;">Material Code</th>
                                    <th style="width: 20%">Currency</th>
                                    <th style="width: 20%;padding-right:18px;">Price</th>
                                    <th style="width: 20%;padding-right:18px;">Per</th>
                                    <th style="width: 20%;padding-right:18px;">Qty PR</th>
                                    <th class="text-right" style="width: 10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody class="list-material-${input_vendor}"></tbody>
                        </table>
                    </td>
                </tr>
            `
            $('#vendors').append(template)
            duplicateTable(input_vendor)
        } else {
            swal('Oops','No vendor selected','error')
            return false
        }
    })
    function duplicateTable(targetClass) {
        $.each($('#vendors .select2:not(span)'), function(){
            try {
                $(this).select2("destroy")
            } catch (error) {}
        })
        var $trEl = $('#vendors > tr')
        if($trEl.length>2) {
            var $materialEl = $($trEl[1]).find('tbody > tr')
            if($materialEl.length>=1) {
                var $targetEl = $(`.material-${targetClass} tbody`)
                $.each($($materialEl), function(){
                    var $el = $(this).clone()
                    $targetEl.append($el)
                    //commend
                    // console.log(this, $el, $targetEl)
                })
                $(`.material-${targetClass} tbody .choose-material`).attr('name', `material_${targetClass}[]`)
                $(`.material-${targetClass} tbody .choose-currency`).attr('name', `currency_${targetClass}[]`)
                $(`.material-${targetClass} tbody .prices`).attr('name', `price_${targetClass}[]`)
                $(`.material-${targetClass} tbody .qty input`).attr('name', `qty_${targetClass}[]`)
                $(`.material-${targetClass} tbody .qty_pr input`).attr('name', `qty_pr_${targetClass}[]`)
            }
        }
        $("#vendors .select2").select2()
        var $elMaterial = $(document).find('#vendors .choose-material')
        $elMaterial.select2('destroy')
        $elMaterial.select2({
            ajax: {
                url: base_url + '/admin/master-acp-material',
                dataType: 'json',
                tokenSeparators: [",", " "],
                //tokenSeparators: [',', ', ', ' '],
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        fromPr : $("input[name='is_from_pr']:checked").val()
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            templateSelection: function(data) {
                return data.title;
            },
            allowClear: true
        })
        var $elCurrency = $(document).find('#vendors .choose-currency')
        $elCurrency.select2('destroy')
        $elCurrency.select2({
            ajax: {
                url: base_url + '/admin/master-acp-currency',
                dataType: 'json',
                delay: 300,
                processResults: function (response) {
                    return {
                        results: response
                    }
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            templateSelection: function(data) {
                return data.title;
            },
            allowClear: true
        })
    }
    $(document).on('click', '.remove-vendor', function (e) {
        const vendor = $(this).data('vendor')
        var value = $(this).closest('tr').find('.vendor_id').val()
        $.each($('#search-vendor option'), function(){
            $this = $(this)
            if($this.val()===value) {
                $this.removeAttr('disabled')
            }
        })
        $('#search-vendor').select2()
        $(this).closest('tr').remove()
        $('.material-' + vendor).remove()

        return false;
    })

    let indexs = 1;
    $(document).on('click', '.add_material', function (e) {
        e.preventDefault()
        var interval
        var formatData = function($el) {
            clearInterval(interval)
            interval = setInterval(() => {
                $el.mask('#,##0.00', {reverse: true})
            }, 500)
        }
        $('.money').mask('#.##0', { reverse: true })
        $(document).on('keyup', 'input.prices ', function(e){
            // ...
            formatData($(this))
        });

        const $tr = $(this).closest('tr').parent()
        const vendor = $(this).data('vendor')
        

        $(document).find('.list-material-' + vendor).append(rowMaterial(vendor, indexs))
        $('.select2').select2()
        $tr.find('input[type="number"]').addClass('form-control')

        $(document).find('.choose-material').select2({
            ajax: {
                url: base_url + '/admin/master-acp-material',
                dataType: 'json',
                tokenSeparators: [",", " "],
                //tokenSeparators: [',', ', ', ' '],
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        fromPr : $("input[name='is_from_pr']:checked").val(),
                        isProject : $("input[name='is_project']:checked").val(),
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            templateSelection: function(data) {
                return data.title;
            },
            allowClear: true
        })

        $(document).find('.choose-currency').select2({
            ajax: {
                url: base_url + '/admin/master-acp-currency',
                dataType: 'json',
                delay: 300,
                processResults: function (response) {
                    return {
                        results: response
                    }
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            templateSelection: function(data) {
                return data.title;
            },
            allowClear: true
        })
        indexs++
    })

    $(function() {
        $('.datetimepicker').datetimepicker({
            format: 'Y-m-d',
            // mask: true
        }).trigger('change');
    });

    $('.money').mask('#.##0', { reverse: true })
</script>
@endsection