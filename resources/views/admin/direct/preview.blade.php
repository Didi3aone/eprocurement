@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Direct Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Direct Order</a></li>
            <li class="breadcrumb-item active">Show</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <div class="table-responsive m-t-40">
                    <form action="{{ route('admin.quotation-save-direct') }}" method="post">
                        @csrf
                        <input type="hidden" name="po_no" value="{{ $po_no }}">
                        <input type="hidden" name="vendor" value="{{ $vendor->code }}">
                        <input type="hidden" name="upload_files" value="{{ $upload_files }}">
                        <input type="hidden" name="notes" value="{{ $notes }}">
                        <table class="table table-striped">
                            <tr>
                                <td>PO No</td>
                                <td>{{ $po_no }}</td>
                            </tr>
                            <tr>
                                <td>Vendor</td>
                                <td>{{ $vendor->code }} - {{ $vendor->name }}</td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td>{{ $notes }}</td>
                            </tr>
                            <tr>
                                <td>Files</td>
                                <td>{{ $upload_files }}</td>
                            </tr>
                        </table>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Purchase Request No</th>
                                    <th>Request Date</th>
                                    <th>Request Number</th>
                                    <th>Material</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                <tr>
                                    <input type="hidden" name="pr_no[]" value="{{ $row['pr_no'] }}">
                                    <input type="hidden" name="request_date[]" value="{{ $row['request_date'] }}">
                                    <input type="hidden" name="rn_no[]" value="{{ $row['rn_no'] }}">
                                    <input type="hidden" name="material_id[]" value="{{ $row['material_id'] }}">
                                    <input type="hidden" name="description[]" value="{{ $row['description'] }}">
                                    <input type="hidden" name="unit[]" value="{{ $row['unit'] }}">
                                    <input type="hidden" name="qty[]" value="{{ $row['qty'] }}">
                                    <td>{{ $row['pr_no'] }}</td>
                                    <td>{{ $row['request_date'] }}</td>
                                    <td>{{ $row['rn_no'] }}</td>
                                    <td>{{ $row['material_id'] }}</td>
                                    <td>{{ $row['description'] }}</td>
                                    <td>{{ $row['unit'] }}</td>
                                    <td>{{ $row['qty'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-actions">
                            {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
                            <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                            <a href="{{ route('admin.purchase-request.index') }}" class="btn btn-inverse">Cancel</a>
                            <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection