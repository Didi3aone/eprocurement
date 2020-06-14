@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.master-rfq.title') }}</a></li>
            <li class="breadcrumb-item active">Show</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <div class="table-responsive m-t-40">
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Purchasing Document</th>
                                <th>Company Code</th>
                                <th>Vendor</th>
                                <th>Payment Terms</th>
                                <th>Payment in 1</th>
                                <th>Payment in 2</th>
                                <th>Payment in 3</th>
                                <th>Disc Percent 1</th>
                                <th>Disc Percent 2</th>
                                <th>Currency</th>
                                <th>Exchange Rate</th>
                                <th>Last Changed</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rfq as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->purchasing_document }}</td>
                                <td>{{ $row->company_code }}</td>
                                <td>{{ isset($row->vendorDetail) ? $row->vendorDetail->code . ' - ' . $row->vendorDetail->name : '' }}</td>
                                <td>{{ $row->payment_terms }}</td>
                                <td>{{ $row->payment_in1 }}</td>
                                <td>{{ $row->payment_in2 }}</td>
                                <td>{{ $row->payment_in3 }}</td>
                                <td>{{ $row->disc_percent1 }}</td>
                                <td>{{ $row->disc_percent2 }}</td>
                                <td>{{ $row->currency }}</td>
                                <td>{{ $row->exchange_rate }}</td>
                                <td>{{ $row->last_changed }}</td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ url('admin/rfq-add-detail/' . $row->purchasing_document) }}">
                                        <i class="fa fa-plus"></i> {{ trans('global.add') }} Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection