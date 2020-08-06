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
            <div class="card-header">
                <a href="{{ route('admin.quotation-repeat.index') }}" class="btn btn-primary btn-xs">Back To List</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>PO Eprocurement</th>
                                    <td>{{ $quotation->po_no }}</td>
                                </tr>
                                <tr>
                                    <th>Plant</th>
                                    <td>{{ \getplan($quotation->detail[0]['plant_code'])->description }}</td>
                                </tr>
                                <tr>
                                    <th>Vendor</th>
                                    <td>{{ $quotation->getVendor['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>Document Type</th>
                                    <td>{{ $quotation->doc_type }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Terms</th>
                                    <td>{{ $quotation->getTerm['own_explanation'] }}</td>
                                </tr>
                                <tr>
                                    <th>Terms Of Payment description</th>
                                    <td>{{ $quotation->notes }}</td>
                                </tr>
                                <tr>
                                    <th>
                                        Upload File
                                    </th>
                                    @if(isset($quotation->upload_file))
                                        @php
                                            $files = @unserialize($quotation->upload_file);
                                        @endphp
                                        @if( $files !== false )
                                            <td>
                                                @foreach( unserialize((string)$quotation->upload_file) as $fileUpload)
                                                    <a href="{{ asset('files/uploads/'.$fileUpload) }}" target="_blank" download>
                                                        {{ $fileUpload ??'' }}
                                                    </a>
                                                    <br>
                                                @endforeach
                                            </td>
                                        @endif
                                    @endif
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
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotation->detail as $key => $value)
                            @php
                                $getQtyAcp = \App\Models\AcpTableMaterial::where('master_acp_id', $value->acp_id)
                                    ->where('material_id', $value->material)
                                    ->first();

                                $perQty = ($value->qty/$getQtyAcp->qty);
                                $totalPrices = (\removeComma($value->price) * $perQty);
                            @endphp
                            <tr>
                                <td>{{ $value->material." - ".$value->short_text }}</td>
                                <td>{{ \App\Models\UomConvert::where('uom_1', $value->unit)->first()->uom_2 ?? $value->unit }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $quotation->currency }}</td>
                                <td>{{ \toDecimal($value->price) }}</td>
                                <td>{{ \toDecimal($totalPrices) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>History Approval</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $quotation->getUserAss['user_id'] }}</td>
                            <td>{{ $quotation->getUserAss['name'] }}</td>
                            <td>
                                @php
                                    if( $quotation->approval_status == \App\Models\Vendor\Quotation::Waiting ) {
                                        echo "Waiting For Approval";
                                    } else if( $quotation->approval_status == \App\Models\Vendor\Quotation::ApprovalAss 
                                        OR $quotation->approval_status == \App\Models\Vendor\Quotation::ApprovalHead) {
                                        echo "Approved";
                                    } else if( $quotation->approval_status == \App\Models\Vendor\Quotation::Rejected ) {
                                        echo 'Rejected';
                                    }
                                @endphp
                            </td>
                            <td>{{ $quotation->approved_date_ass ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>{{  'PROCUREMENT01' }}</td>
                            <td>{{ $quotation->getUserHead['name'] }}</td>
                            <td>
                                @php
                                    if( $quotation->approval_status == \App\Models\Vendor\Quotation::Waiting ) {
                                        echo "Waiting For Approval";
                                    } else if( $quotation->approval_status == \App\Models\Vendor\Quotation::ApprovalHead ) {
                                        echo "Approved";
                                    } else if( $quotation->approval_status == \App\Models\Vendor\Quotation::Rejected ) {
                                        echo 'Rejected';
                                    }
                                @endphp
                            </td>
                            <td>{{ $quotation->approved_date_head ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection