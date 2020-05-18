@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Quotation</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ 'Quotation Online' }}</a></li>
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
                <form class="form-rn m-t-40" action="{{ route("admin.quotation-save-online") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>{{ trans('cruds.purchase-order.fields.PR_NO') }}</label>
                                <input type="text" class="form-control form-control-line {{ $errors->has('PR_NO') ? 'is-invalid' : '' }}" name="PR_NO" value="{{ old('PR_NO', $po_no) }}" readonly> 
                                @if($errors->has('PR_NO'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('PR_NO') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="javascript:;" data-toggle="modal" data-target="#modal_material" class="btn btn-primary">{{ trans('cruds.purchase-order.show_modal') }}</a>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.purchasing_leadtime') }}</label>
                        <div class="row">
                            <div class="col-lg-3">
                                <select name="leadtime_type" id="leadtime_type" class="form-control">
                                    <option value="0">Tanggal</option>
                                    <option value="1">Jumlah Hari</option>
                                </select>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="purchasing_leadtime" class="form-control form-control-line {{ $errors->has('purchasing_leadtime') ? 'is-invalid' : '' }}" name="purchasing_leadtime" value="{{ old('purchasing_leadtime', 0) }}">
                                @if($errors->has('purchasing_leadtime'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('purchasing_leadtime') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.target_price') }}</label>
                        <input type="text" class="money form-control form-control-line {{ $errors->has('target_price') ? 'is-invalid' : '' }}" name="target_price" value="{{ old('target_price', 0) }}">
                        @if($errors->has('target_price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('target_price') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.expired_date') }}</label>
                        <input type="text" id="datetimepicker" class="form-control form-control-line {{ $errors->has('expired_date') ? 'is-invalid' : '' }}" name="expired_date" value="{{ old('expired_date', date('Y-m-d H:i', strtotime('+3 months', time()))) }}">
                        @if($errors->has('expired_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('expired_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('cruds.purchase-order.invite_vendor') }}</label>
                        <div class="row">
                            <div class="col-lg-9">
                                <select name="search-vendor" id="search-vendor" class="form-control select2">
                                    @foreach ($vendor as $val)
                                    <option 
                                        value="{{ $val->id }}"
                                        data-id="{{ $val->id }}"
                                        data-name="{{ $val->name }}"
                                        data-email="{{ $val->email }}"
                                        data-address="{{ $val->address }}"
                                        data-npwp="{{ $val->npwp }}"
                                    >
                                        {{ $val->name }}
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
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>NPWP</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="vendors"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.purchase-request.index') }}" class="btn btn-inverse">Cancel</a>
                        <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_material" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('cruds.masterMaterial.title_singular') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row" style="padding: 0 15px 15px 15px;">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th style="width: 10%">Qty</th>
                                    <th style="width: 10%">Unit</th>
                                    <th>Notes</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td><input type="text" class="form-control" name="description[]" readonly value="{{ $value->description }}"></td>
                                        <td><input type="text" class="form-control" name="qty[]" readonly value="{{ number_format($value->qty, 0, '', '.') }}"></td>
                                        <td><input type="text" class="form-control" name="unit[]" readonly value="{{ $value->unit }}"></td>
                                        <td><input type="text" class="form-control" name="notes_detail[]" readonly value="{{ $value->notes }}"></td>
                                        <td><input type="text" class="form-control" name="price[]" readonly value="{{ number_format($value->price, 0, '', '.') }}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    let index = 1

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

    $("#leadtime_type").change(function() {
        const leadtime_type = $(this).val();

        if( leadtime_type == 0 ) {
            $("#purchasing_leadtime")
                .attr('type', 'date')
                .val(formatDate(new Date()))
                .focus()
        } else {
            $("#purchasing_leadtime")
                .attr('type', 'number')
                .val(0)
                .focus()
        }
    }).trigger('change');

    $('#btn-search-vendor').on('click', function (e) {
        e.preventDefault()

        const $search = $('#search-vendor').children('option:selected')
        const input_vendor = $search.val()
        const id_vendor = $search.data('id')
        const name_vendor = $search.data('name')
        const email_vendor = $search.data('email')
        const address_vendor = $search.data('address')
        const npwp_vendor = $search.data('npwp')

        let template = `
            <tr>
                <td>${name_vendor}</td>
                <td>${email_vendor}</td>
                <td>${address_vendor}</td>
                <td>${npwp_vendor}</td>
                <td>
                    <input type="hidden" name="vendor_id[]" value="${id_vendor}">
                    <button 
                        className="remove-vendor btn btn-xs btn-danger" 
                        onclick="document.getElementById('btn-search-vendor').removeAttribute('disabled'); this.parentNode.parentNode.remove()"
                    >
                        <i className="fa fa-trash"></i> Remove
                    </button>
                </td>
            </tr>
        `

        $('#vendors').append(template)
    })

    $(function() {
        $('#datetimepicker').datetimepicker({
            format: 'Y-m-d H:i',
            mask: true
        }).trigger('change');
    });

    $('.money').mask('#.##0', { reverse: true });
</script>
@endsection