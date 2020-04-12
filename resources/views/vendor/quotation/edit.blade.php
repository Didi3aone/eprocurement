@extends('layouts.vendor')
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
                <form class="form-material m-t-40" method="POST" action="{{ route("vendor.quotation-save") }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $quotation->id }}">
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
                        <label>{{ trans('cruds.quotation.fields.vendor_leadtime') }}</label>
                        <div class="row">
                            <div class="col-lg-3">
                                <select name="leadtime_type" id="leadtime_type" class="form-control">
                                    <option value="0">Tanggal</option>
                                    <option value="1">Jumlah Hari</option>
                                </select>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="vendor_leadtime" class="form-control form-control-line {{ $errors->has('vendor_leadtime') ? 'is-invalid' : '' }}" name="vendor_leadtime" value="{{ old('vendor_leadtime', 0) }}" required> 
                                @if($errors->has('vendor_leadtime'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('vendor_leadtime') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.vendor_price') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('vendor_price') ? 'is-invalid' : '' }}" name="vendor_price" value="{{ old('vendor_price', '') }}" required> 
                        @if($errors->has('vendor_price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('vendor_price') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.upload_file') }}</label>
                        <input type="file" class="form-control form-control-line {{ $errors->has('upload_file') ? 'is-invalid' : '' }}" name="upload_file"> 
                        @if($errors->has('upload_file'))
                            <div class="invalid-feedback">
                                {{ $errors->first('upload_file') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.notes') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" required> 
                        @if($errors->has('notes'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notes') }}
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
$(document).ready(function () {
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
            $("#vendor_leadtime")
                .attr('type', 'date')
                .val(formatDate(new Date()))
                .focus()
        } else {
            $("#vendor_leadtime")
                .attr('type', 'number')
                .val(0)
                .focus()
        }
    }).trigger('change');
})    
</script>    
@endsection