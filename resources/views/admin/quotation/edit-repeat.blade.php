@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Repeat</a></li>
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
                    <input type="hidden" name="status" value="0">
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
                        <label>{{ trans('cruds.quotation.fields.qty') }}</label>
                        <input type="text" class="money form-control form-control-line {{ $errors->has('qty') ? 'is-invalid' : '' }}" name="qty" value="{{ old('qty', $quotation->qty) }}"> 
                        @if($errors->has('qty'))
                            <div class="invalid-feedback">
                                {{ $errors->first('qty') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.quotation.repeat') }}" type="button" class="btn btn-inverse">Cancel</a>
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
</script>    
@endsection