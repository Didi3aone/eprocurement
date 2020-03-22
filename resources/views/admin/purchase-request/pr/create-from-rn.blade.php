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
                <form class="form-rn m-t-40" action="{{ route("admin.request-note.store") }}" enctype="multipart/form-data" method="post">
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
                        <label>Purchase request date</label>
                        <input type="date" class="form-control form-control-line" name="" value="{{ old('notes', '') }}"> 
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
                                        <th>
                                            Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="rn_items">
                                    @foreach($rnDetail as $key => $value)
                                        <tr>
                                            <td><input type="text" class="form-control" readonly value="{{ $value->description }}"></td>
                                            <td><input type="text" class="form-control" readonly value="{{ $value->qty }}"></td>
                                            <td><input type="text" class="form-control" readonly value="{{ $value->unit }}"></td>
                                            <td><input type="text" class="form-control" readonly value="{{ $value->notes }}"></td>
                                            <td><input type="text" class="form-control" readonly value="{{ $value->price }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <button type="button" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection