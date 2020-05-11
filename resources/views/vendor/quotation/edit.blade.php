@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Vendor</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Bidding Online</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <form class="form-material m-t-40" method="POST" action="{{ route("vendor.quotation-save") }}" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <input type="hidden" name="id" value="{{ $quotation->id }}">
                    <input type="hidden" name="target_price" value="{{ $quotation->target_price }}">
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
                        <label>
                            {{ trans('cruds.quotation.fields.vendor_leadtime') }}
                            <span class="text-right label label-success">Purchasing Leadtime: {{ $quotation->purchasing_leadtime }}</span>
                        </label>
                        <div class="row">
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="leadtime_type" value="{{ $quotation->leadtime_type == 0 ? 'Tanggal' : 'Jumlah Hari' }}" readonly>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="vendor_leadtime" class="form-control form-control-line {{ $errors->has('vendor_leadtime') ? 'is-invalid' : '' }}" name="vendor_leadtime" value="{{ old('vendor_leadtime', $quotation->vendor_leadtime) }}" required> 
                                @if($errors->has('vendor_leadtime'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('vendor_leadtime') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.quotation.fields.vendor_price') }} <span class="text-right label label-success">Target Price: {{ number_format($quotation->target_price, 0, '', '.') }}</span></label>
                        <input type="text" class="money form-control form-control-line {{ $errors->has('vendor_price') ? 'is-invalid' : '' }}" name="vendor_price" value="{{ old('vendor_price', $quotation->vendor_price) }}" required> 
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
                        <input type="text" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" value="{{ old('notes', $quotation->notes) }}" required> 
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
                </div>
            </div>

            @if (!empty($vendors))
            <div class="card">
                <div class="card-header">
                    <h3>Kompetitor</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hovered">
                            <thead>
                                <tr>
                                    <th>Leadtime</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendors as $row)
                                <tr>
                                    <td>{{ $row->vendor_leadtime }}</td>
                                    <td>{{ number_format($row->vendor_price, 0, '', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $('.money').mask('#.##0', { reverse: true });

    @if ($quotation->leadtime_type == 1)
        $("#vendor_leadtime")
            .attr('type', 'number')
            .val({{ $quotation->vendor_leadtime }})
            .focus()
    @else
        $("#vendor_leadtime")
            .attr('type', 'date')
            .val(formatDate(new Date()))
            .focus()
    @endif
</script>    
@endsection