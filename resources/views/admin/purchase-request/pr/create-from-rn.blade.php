@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ 'PR' }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("admin.purchase-request-save-from-rn") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.request-note.fields.request_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('request_no') ? 'is-invalid' : '' }}" name="request_no" value="{{ $rn->request_no ?? old('request_no', '') }}"> 
                        @if($errors->has('request_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('request_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-request.fields.request_date') }}</label>
                        <input type="text" class="form-control datepicker form-control-line {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" value="{{ $rn->date ?? old('date', '') }}"> 
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
                                    @php $total = 0 @endphp
                                    @foreach($rnDetail as $key => $value)
                                        <tr>
                                            <td><input type="text" class="form-control" name="rn_description[]" readonly value="{{ $value->description }}"></td>
                                            <td><input type="number" class="form-control" name="rn_qty[]" readonly value="{{ $value->qty }}" required></td>
                                            <td><input type="text" class="form-control" name="rn_unit[]" readonly value="{{ $value->unit }}" required></td>
                                            <td><input type="text" class="form-control" name="rn_notes[]" readonly value="{{ $value->notes }}"></td>
                                            <td><input type="number" class="form-control" name="rn_price[]" readonly value="{{ $value->price }}" required></td>
                                        </tr>
                                        @php $total += (int) $value->price; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="total" value="{{ $total }}">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <button type="button" class="btn btn-inverse">Cancel</button>
                        <h3 class="float-right">Total {{ $total }}</h3>
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
        $('.datepicker').datepicker()
    })
</script>
@endsection