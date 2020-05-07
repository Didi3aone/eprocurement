@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.quotation.title') }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" method="POST" action="{{ route("admin.quotation.update", [$quotation->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.po_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', $quotation->po_no) }}" readonly> 
                        @if($errors->has('po_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('po_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</label>
                        <div class="row">
                            <div class="col-lg-3">
                                <select name="leadtime_type" id="leadtime_type" class="form-control">
                                    <option value="0" {{ $quotation->leadtime_type == 0 ? 'selected' : '' }}>Tanggal</option>
                                    <option value="1" {{ $quotation->leadtime_type == 1 ? 'selected' : '' }}>Jumlah Hari</option>
                                </select>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="purchasing_leadtime" class="form-control form-control-line {{ $errors->has('purchasing_leadtime') ? 'is-invalid' : '' }}" name="purchasing_leadtime" value="{{ old('purchasing_leadtime', $quotation->purchasing_leadtime) }}"> 
                                @if($errors->has('purchasing_leadtime'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('purchasing_leadtime') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.target_price') }}</label>
                        <input type="text" class="money form-control form-control-line {{ $errors->has('target_price') ? 'is-invalid' : '' }}" name="target_price" value="{{ old('target_price', $quotation->target_price) }}"> 
                        @if($errors->has('target_price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('target_price') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.expired_date') }}</label>
                        <input type="text" id="datetimepicker" class="form-control form-control-line {{ $errors->has('expired_date') ? 'is-invalid' : '' }}" name="expired_date" value="{{ old('expired_date', $quotation->expired_date) }}"> 
                        @if($errors->has('expired_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('expired_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.quotation.index') }}" type="button" class="btn btn-inverse">Cancel</a>
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
    $('.money').mask('#.##0', { reverse: true });

    $(function() {
        $('#datetimepicker').datetimepicker({
            format: 'Y-m-d H:i',
            mask: true
        }).trigger('change');
    });
</script>    
@endsection