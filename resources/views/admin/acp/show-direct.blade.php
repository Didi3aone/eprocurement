@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Direct Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Direct</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.post-acp-direct') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="quotation_id" value="{{ $model->id }}">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                        <td>{{ $model->po_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.doc_type') }}</th>
                                        <td>{{ $model->doc_type }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Winner</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($acp->detail as $rows)
                                        @php
                                            $winner = 'No';
                                            if( $rows->vendor_code == $model->vendor_id ) {
                                                $winner = 'Yes';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $rows->vendor_code ." - ". $rows->vendor['name'] }}</td>
                                            <td>{{ $rows->vendor['email'] }}</td>
                                            <td>{{ $rows->vendor['street'] }}</td>
                                            <td>{{ $winner }}</td>
                                            <td>
                                                <a 
                                                    class="open_modal_bidding btn btn-success" 
                                                    id="open_modal" 
                                                    data-toggle="modal" 
                                                    data-target="#modal_create_po_{{ $rows->vendor_code }}" 
                                                    href="javascript:;"
                                                >
                                                    <i class="fa fa-cubes"></i> 
                                                    Show Detail
                                                </a>
                                                <div class="modal fade" id="modal_create_po_{{ $rows->vendor_code }}" tabindex="-1" role="dialog" aria-labelledby="modalCreatePO" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalImport">{{ 'ACP VIEW' }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Material ID</th>
                                                                            <th>Descriptiom</th>
                                                                            <th>Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach (\App\Models\AcpTableMaterial::getMaterialVendor($rows->vendor_code, $rows->master_acp_id) as $row)
                                                                            <tr>
                                                                                <td>{{ $row->material_id }}</td>
                                                                                <td>{{ $row->description }}</td>
                                                                                <td>{{ number_format($row->price,2) }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> Approve</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection