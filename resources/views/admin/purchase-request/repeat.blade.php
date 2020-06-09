@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Quotation</h3>
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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>PR No</th>
                                        <th>Request Date</th>
                                        <th>RN No</th>
                                        <th>Material ID</th>
                                        <th>Unit</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 10%">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
                                        <tr>
                                            <td><input type="text" class="form-control" name="pr_no[]" readonly value="{{ $value->pr_no }}"></td>
                                            <td><input type="text" class="form-control" name="request_date[]" readonly value="{{ $value->request_date }}"></td>
                                            <td><input type="text" class="form-control" name="rn_no[]" readonly value="{{ $value->request_no }}"></td>
                                            <td><input type="text" class="form-control" name="material_id[]" readonly value="{{ $value->material_id }}"></td>
                                            <td><input type="text" class="form-control" name="unit[]" readonly value="{{ $value->unit }}"></td>
                                            <td><input type="text" class="form-control" name="qty[]" readonly value="{{ empty($value->qty) ? 0 : $value->qty }}"></td>
                                            <td><input type="text" class="form-control" name="price[]" readonly value="{{ $value->price }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>    
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('cruds.purchase-order.invite_vendor') }}</label>
                        <div class="row">
                            <div class="col-lg-6">
                                <select name="vendor_id" class="form-control select2">
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
                        {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
                        <input type="hidden" name="id" value="{{ $uri['ids'] }}">
                        <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
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
</script>
@endsection