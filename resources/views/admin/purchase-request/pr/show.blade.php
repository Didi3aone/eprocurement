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
                <form class="form-rn m-t-40" action="{{ route("admin.purchase-request-save-validate-pr") }}" enctype="multipart/form-data" method="post">
                    @csrf
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
                                        <th>is Assets ?</th>
                                    </tr>
                                </thead>
                                <tbody id="rn_items">
                                    @foreach($pr as $key => $value)
                                        <input type="hidden" class="form-control" name="purchase_id" readonly value="{{ $value->purchase_id }}">
                                        <tr>
                                            <td><input type="text" class="form-control" name="rn_description[]" readonly value="{{ $value->description }}"></td>
                                            <td><input type="number" class="form-control" name="rn_qty[]" readonly value="{{ $value->qty }}" required></td>
                                            <td><input type="text" class="form-control" name="rn_unit[]" readonly value="{{ $value->unit }}" required></td>
                                            <td><input type="text" class="form-control" name="rn_notes[]" readonly value="{{ $value->notes }}"></td>
                                            <td><input type="number" class="form-control" name="rn_price[]" readonly value="{{ $value->price }}" required></td>
                                            <td>
                                                <select name="is_assets[]" class="form-control">
                                                    <option value="1">Assets</option>
                                                    <option value="2">Non-Assets</option>
                                                </select>
                                            </td>
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

@section('scripts')
<script>
    $(document).ready(function () {
        $('.datepicker').datepicker()
    })
</script>
@endsection