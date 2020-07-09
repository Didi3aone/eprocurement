@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Quotation</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.quotation.title') }}</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>PO Eprocurement</th>
                                    <td>{{ $poNo }}</td>
                                </tr>
                                <tr>
                                    <th>Vendor</th>
                                    <td>{{ $vendor->name }}</td>
                                </tr>
                                <tr>
                                    <th>Document Type</th>
                                    <td>{{ $docType->code }} - {{ $docType->description }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Terms</th>
                                    <td>{{ $paymentTerm->own_explanation }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Currency</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['id'] as $key => $value)
                            @php
                                $material = \App\Models\PurchaseRequestsDetail::where('material_id', $data['material_id'][$key])->first();
                            @endphp
                            <tr>
                                <td>{{ $material->material_id." - ".$material->description }}</td>
                                <td>{{ $data['unit'][$key] }}</td>
                                <td>{{ $data['qty'][$key] }}</td>
                                <td>{{ $data['original_currency'][$key] }}</td>
                                <td>{{ $data['original_price'][$key] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success pull-right approve">Approve</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent 
    <script>
    $('.approve').on('click', function(){
        window.close();
    })
    </script>
@endsection