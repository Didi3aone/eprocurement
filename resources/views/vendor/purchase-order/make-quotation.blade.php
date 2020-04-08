@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Make Quotation</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ 'Quotation' }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("vendor.purchase-order-save-quotation") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" value="{{ $purchaseOrder->id }}" name="request_id">
                    <div class="form-group">
                        <label>PR NO</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', $purchaseOrder->po_no) }}"> 
                        @if($errors->has('request_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('request_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>PR Date</label>
                        <input type="text" class="form-control datepicker form-control-line {{ $errors->has('date') ? 'is-invalid' : '' }}" name="po_date" value="{{ old('po_date', $purchaseOrder->po_date) }}"> 
                        @if($errors->has('date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.notes') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" value="{{ old('notes', $purchaseOrder->notes) }}"> 
                        @if($errors->has('notes'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notes') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
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
                                    @foreach($purchaseOrderDetails as $key => $value)
                                        <tr>
                                            <td><input type="text" class="form-control" name="description[]" readonly value="{{ $value->description }}"></td>
                                            <td><input type="number" class="form-control" name="qty[]" readonly value="{{ $value->qty }}" required></td>
                                            <td><input type="text" class="form-control" name="unit[]" readonly value="{{ $value->unit }}" required></td>
                                            <td><input type="text" class="form-control" name="notes_detail[]" readonly value="{{ $value->notes }}"></td>
                                            <td><input type="number" class="form-control" name="price[]" value="" required></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-actions">
                        {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <button type="button" class="btn btn-inverse">Cancel</button>
                        <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    })
</script>
@endsection