@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">PO Repeat</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Repeat</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-primary" href="{{ route('vendor.purchase-order-repeat') }}"><i class="fa fa-arrow-left"></i> Back To list</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                PO Number
                            </th>
                            <td>
                                {{ $poDirect->PO_NUMBER }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Payment Term
                            </th>
                            <td>
                                {{ $poDirect->payment_term }} days
                            </td>
                        </tr>
                        <tr>
                            <th>
                                PO Date
                            </th>
                            <td>
                                {{ $poDirect->po_date }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
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
                        @foreach($poDirect->orderDetail as $key => $value)
                        <tr>
                            <td>{{ $value->description }}</td>
                            <td>{{ $value->unit }}</td>
                            <td>{{ $value->qty }}</td>
                            <td>{{ $value->currency }}</td>
                            <td>{{ \toDecimal($value->price) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection