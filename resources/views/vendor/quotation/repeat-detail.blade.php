@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
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
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.id') }}</td>
                            <td>{{ $quotation->id }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.po_no') }}</td>
                            <td>{{ $quotation->po_no }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.status') }}</td>
                            <td>{{ $quotation->status == 0 ? 'PO repeat' : ($quotation->status == 1 ? 'Online' : 'Penunjukkan Langsung') }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.quotation.fields.qty') }}</td>
                            <td>{{ number_format($quotation->qty, 0, '', '.') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-actions">
                    @if ($quotation->status != 0)
                    <a href="{{ route('vendor.quotation-edit', $quotation->id) }}" class="btn btn-inverse">Bid</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection