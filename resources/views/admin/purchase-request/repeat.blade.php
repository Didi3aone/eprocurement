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
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" value="{{ $pr->id }}" name="request_id">
                    <input type="hidden" value="0" name="status">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>{{ trans('cruds.purchase-order.fields.request_no') }}</label>
                                <input type="text" class="form-control form-control-line {{ $errors->has('request_no') ? 'is-invalid' : '' }}" name="request_no" value="{{ old('request_no', $pr->request_no) }}" readonly> 
                                @if($errors->has('request_no'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('request_no') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="javascript:;" data-toggle="modal" data-target="#modal_material" class="btn btn-primary">{{ trans('cruds.purchase-order.show_modal') }}</a>
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('cruds.purchase-order.invite_vendor') }}</label>
                        <div class="row">
                            <div class="col-lg-9">
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
                        <label for="qty">Quantity Order</label>
                        <input type="text" class="money form-control" name="qty">
                    </div>

                    <div class="form-actions">
                        {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
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
                                @foreach($prDetail as $key => $value)
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

    $('.money').mask('#.##0', { reverse: true });
</script>
@endsection