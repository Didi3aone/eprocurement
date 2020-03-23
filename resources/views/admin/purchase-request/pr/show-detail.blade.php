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
                <div class="form-group">
                    <label>{{ trans('cruds.request-note.fields.request_no') }}</label>
                    <input type="text" class="form-control form-control-line" name="request_no" readonly value="{{ $pr->request_no ?? old('request_no', '') }}"> 
                    @if($errors->has('request_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('request_no') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ 'Request Date' }} *</label>
                    <input type="text" class="form-control datepicker form-control-line" name="date" readonly value="{{ $pr->request_date ?? old('date', '') }}"> 
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.purchase-request.fields.notes') }} *</label>
                    <input type="text" class="form-control form-control-line" name="notes" readonly value="{{  $pr->notes ?? old('notes', '') }}"> 
                </div>
                <div class="form-group">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
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
                                @foreach($prDetail as $key => $value)
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
                <div class="form-group">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width: 10%">NIK</th>
                                    <th style="width: 10%">Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="rn_items">
                                @foreach($papproval as $key => $value)
                                   <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->nik }}</td>
                                        <td>{{ ($value->status == 0) ? 'waiting approval' : 'approved' }}</td>
                                        <td>{{ $value->approve_date }}</td>
                                   </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-inverse">Cancel</button>
                </div>
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