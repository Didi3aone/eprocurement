@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.rfq.title') }}</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('cruds.rfq.fields.id') }}</th>
                            <td>{{ $rfq->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.rfq.fields.code') }}</th>
                            <td>{{ $rfq->code }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.rfq.fields.description') }}</th>
                            <td>{{ $rfq->description }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.rfq.fields.created_at') }}</th>
                            <td>{{ $rfq->created_at }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.rfq.fields.updated_at') }}</th>
                            <td>{{ $rfq->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if (count($rfq->details) > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3>RFQ Detail</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="datatable table table-striped">
                    <thead>
                        <tr>
                            <th>Purchasing Document</th>
                            <th>Company Code</th>
                            <th>Vendor</th>
                            <th>Payment Terms</th>
                            <th>Payment in 1</th>
                            <th>Payment in 2</th>
                            <th>Payment in 3</th>
                            <th>Disc Percent 1</th>
                            <th>Discount Percent 2</th>
                            <th>Currency</th>
                            <th>Exchange Rate</th>
                            <th>Last Changed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rfq->details as $row)
                        <tr>
                            <td>{{ $row->purchasing_document }}</td>
                            <td>{{ $row->company_code }}</td>
                            <td>{{ $row->vendor }}</td>
                            <td>{{ $row->payment_terms }}</td>
                            <td>{{ $row->payment_in1 }}</td>
                            <td>{{ $row->payment_in2 }}</td>
                            <td>{{ $row->payment_in3 }}</td>
                            <td>{{ $row->disc_percent1 }}</td>
                            <td>{{ $row->disc_percent2 }}</td>
                            <td>{{ $row->currency }}</td>
                            <td>{{ $row->exchange_rate }}</td>
                            <td>{{ $row->last_changed }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection