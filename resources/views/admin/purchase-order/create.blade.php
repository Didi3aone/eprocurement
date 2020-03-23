@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ 'PO' }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("admin.purchase-order.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" value="{{ $pr->id }}" name="request_id">
                    <input type="hidden" value="0" name="status">
                    <div class="form-group">
                        <label>Bidding ?</label>
                        <div class="">
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-active" type="radio" value="1"
                                    name="bidding">
                                <label class="form-check-label" for="inline-radio-active">Yes</label>
                            </div>
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-non-active" type="radio" value="0"
                                    name="bidding" checked>
                                <label class="form-check-label" for="inline-radio-non-active">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="vendors">
                        <label>Vendor</label>
                        <select class="form-control select2 {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id" id="vendor_id">
                            @foreach($vendor as $id => $val)
                                <option value="{{ $val->id }}" {{ in_array($val->id, old('vendor_id', [])) ? 'selected' : '' }}>{{ $val->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('vendor_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('vendor_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>PO NO</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', '') }}"> 
                        @if($errors->has('request_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('request_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>PO Date</label>
                        <input type="text" class="form-control datepicker form-control-line {{ $errors->has('date') ? 'is-invalid' : '' }}" name="po_date" value="{{ old('po_date', '') }}"> 
                        @if($errors->has('date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.notes') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" value="{{ old('notes', '') }}"> 
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
                                <tbody id="rn_items">
                                    @foreach($prDetail as $key => $value)
                                        <tr>
                                            <td><input type="text" class="form-control" name="description[]" readonly value="{{ $value->description }}"></td>
                                            <td><input type="number" class="form-control" name="qty[]" readonly value="{{ $value->qty }}" required></td>
                                            <td><input type="text" class="form-control" name="unit[]" readonly value="{{ $value->unit }}" required></td>
                                            <td><input type="text" class="form-control" name="notes_detail[]" readonly value="{{ $value->notes }}"></td>
                                            <td><input type="number" class="form-control" name="price[]" readonly value="{{ $value->price }}" required></td>
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
        $('.datepicker').datepicker();
        $("#vendors").hide();
        $("input[name='bidding']").change(function(){
            var bidding = $(this).val();

            if( bidding == 1 ) {
                $("#vendors").show();
            } else {
                $("#vendors").hide();
            }
        });
    })
</script>
@endsection