@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Billing</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Billing</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <a class="btn btn-primary btn-xs" href="{{ route('vendor.billing') }}"><i class="fa fa-arrow-left"></i> Back To list</a>
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
                                Billing ID
                            </th>
                            <td>
                                {{ $billing->billing_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tax Invoice Number
                            </th>
                            <td>
                                {{ $billing->no_faktur }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tax Invoice Date
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($billing->tgl_faktur)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tax Invoice File
                            </th>
                            <td>
                                <a target="_blank" href="{{ asset('files/uploads/'.$billing->file_faktur) }}">
                                    {{ $billing->file_faktur }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Invoice Number
                            </th>
                            <td>
                                {{ $billing->no_invoice }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                 Invoice Date
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($billing->tgl_invoice)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                               DPP
                            </th>
                            <td>
                                {{ \toDecimal(\removeComma($billing->dpp)) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                               VAT
                            </th>
                            <td>
                                @if($billing->ppn == 'V1' )
                                    10%
                                @else 
                                    None
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Nominal Invoice After VAT
                            </th>
                            <td>
                                {{ \toDecimal(\removeComma($billing->nominal_inv_after_ppn)) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Invoice File
                            </th>
                            <td>
                                <a target="_blank" href="{{ asset('files/uploads/'.$billing->file_invoice) }}">
                                    {{ $billing->file_invoice }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Delivery Order
                            </th>
                            <td>
                                <a target="_blank" href="{{ asset('files/uploads/'.$billing->no_surat_jalan ) }}">
                                    {{ $billing->no_surat_jalan }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Delivery Date
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($billing->tgl_surat_jalan)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                PO 
                            </th>
                            <td>
                                <a target="_blank" href="{{ asset('files/uploads/'.$billing->po) }}">
                                    {{ $billing->po }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Description PO
                            </th>
                            <td>
                                {{ $billing->keterangan_po }}
                            </td>
                        </tr>
                        @if($billing->status == \App\Models\Vendor\Billing::Rejected OR $billing->status == \App\Models\Vendor\Billing::Incompleted)
                        <tr>
                            <th>
                                Reason Rejected
                            </th>
                            <td>
                                {{ $billing->reason_rejected }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <p>Detail Billing</p>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="">Qty GR</th>
                            <th style="">Qty Billing</th>
                            <th style="">Material</th>
                            <th style="">PO No</th>
                            <th style="">PO Item</th>
                            <th style="">GR Doc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billing->detail as $key => $value)
                            <tr>
                                <td>{{ $value->qty_old }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $value->material['description'] }}</td>
                                <td>{{ $value->po_no }}</td>
                                <td>{{ $value->PO_ITEM }}</td>
                                <td>{{ $value->doc_gr }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection