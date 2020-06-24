@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.master-acp.title') }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<form class="form-material m-t-40" action="{{ route("admin.master-acp.update", $model->id) }}" enctype="multipart/form-data" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.acp_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('acp_no') ? 'is-invalid' : '' }}" name="acp_no" value="{{ $model->acp_no ?? old('acp_no', '') }}" required> 
                        @if($errors->has('acp_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('acp_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="is_project" id="is_project" value="{{ $model->is_project }}">
                        <label for="is_project">{{ trans('cruds.master-acp.fields.is_project') }}</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="is_approval" id="is_approval" value="{{ $model->is_approval }}">
                        <label for="is_approval">{{ trans('cruds.master-acp.fields.is_approval') }}</label>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.currency') }}</label>
                        <select class="form-control form-control-line {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency" required> 
                            <option value="IDR" {{ $model->currency == 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                            <option value="USD" {{ $model->currency == 'USD' ? 'selected' : '' }}>USD - American Dollar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.start_date') }}</label>
                        <input type="text" class="datetimepicker form-control form-control-line {{ $errors->has('start_date') ? 'is-invalid' : '' }}" name="start_date" value="{{ $model->start_date }}" required> 
                        @if($errors->has('start_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.master-acp.fields.end_date') }}</label>
                        <input type="text" class="datetimepicker form-control form-control-line {{ $errors->has('end_date') ? 'is-invalid' : '' }}" name="end_date" value="{{ $model->end_date }}" required> 
                        @if($errors->has('end_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_date') }}
                            </div>
                        @endif
                    </div>
                    <hr style="margin: 30px 0">
                    <div class="form-group">
                        <label for="">{{ trans('cruds.master-acp.invite_vendor') }}</label>
                        <div class="row">
                            <div class="col-lg-9">
                                <select name="search-vendor" id="search-vendor" class="form-control select2" value="{{ $vendor->code . ' - ' . $vendor->name }}">
                                    <option>-- Select --</option>
                                    @foreach ($vendors as $val)
                                    <option 
                                        value="{{ $val->code }}"
                                        data-id="{{ $val->id }}"
                                        data-title="{{ $val->title }}"
                                        data-name="{{ $val->name }}"
                                        data-email="{{ $val->email }}"
                                        data-street="{{ $val->street }}"
                                        data-city="{{ $val->city }}"
                                    >
                                        {{ $val->code . " - " . $val->name }}
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
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.master-acp.index') }}" type="button" class="btn btn-inverse"><i class="fa fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    const base_url = '{{ url('/') }}'

    function rowMaterial (vendor) {
        return `
            <tr>
                <td>
                    <select name="material_${vendor}[]" id="" class="choose-material form-control select2"></select>
                </td>
                <td class="price">
                    <input type="text" name="price_${vendor}[]" class="money form-control"/>
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
        const input_vendor = $search.val()

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
                        <input type="checkbox" name="winner_${input_vendor}" id="winner_${input_vendor}"/>
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
                    <td colspan="4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50%">Material Code</th>
                                    <th style="width: 30%">Price</th>
                                    <th class="text-right" style="width: 20%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody class="list-material-${input_vendor}"></tbody>
                        </table>
                    </td>
                </tr>
            `

            $('#vendors').append(template)
        } else {
            alert('No vendor selected')
        }
    })

    $(document).on('click', '.remove-vendor', function (e) {
        const vendor = $(this).data('vendor')

        $(this).closest('tr').remove()
        $('.material-' + vendor).remove()

        return false;
    })

    $(document).on('click', '.add_material', function (e) {
        e.preventDefault()

        const $tr = $(this).closest('tr').parent()
        const vendor = $(this).data('vendor')

        $(document).find('.list-material-' + vendor).append(rowMaterial(vendor))
        $('.select2').select2()
        $tr.find('input[type="number"]').addClass('form-control')

        $(document).find('.choose-material').select2({
            ajax: {
                url: base_url + '/admin/master-acp-material',
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
    })

    $(function() {
        $('.datetimepicker').datetimepicker({
            format: 'Y-m-d H:i',
            // mask: true
        }).trigger('change');
    });

    $('.money').mask('#.##0', { reverse: true })
</script>
@endsection