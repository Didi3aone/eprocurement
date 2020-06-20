@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchase Request Approval</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<form class="form-rn m-t-40" action="{{ route('admin.purchase-request-project-approval') }}" enctype="multipart/form-data" method="post">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.purchase-request-project') }}"><i class="fa fa-arrow-left"></i> Back To list</a>
                    <button class="btn btn-success btn-xs approve" type="submit"><i class="fa fa-check"></i> Approve</button>
                    <a class="btn btn-danger btn-xs reject" href="#"><i class="fa fa-times"></i> Reject</a>
                    <br/><br>
                    <table class="table table-bordered table-striped">
                        <input type="hidden" name="pr_id" value="{{ $prProject->id }}">
                        <tbody>
                            <tr>
                                <th>
                                    Request No
                                </th>
                                <td>
                                    {{ $prProject->request_no }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Request Date
                                </th>
                                <td>
                                    {{ $prProject->request_date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Urgensi
                                </th>
                                <td>
                                    {!! \App\Models\PurchaseRequest::TypeUrgent[$prProject->is_urgent] !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Notes
                                </th>
                                <td>
                                    {{ $prProject->notes }}
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
                                <th>Category</th>
                                <th>Material ID</th>
                                <th>Material Description</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prProject->purchaseDetail as $key => $value)
                            <tr>
                                <input type="hidden" name="idDetail[]" value="{{ $value->id }}">
                                <td>
                                    @if($value->material_id != '')
                                        {{ 'Material Item' }}
                                    @elseif($value->material_id == '' && $value->category == \App\Models\PurchaseRequest::STANDART)
                                        {{ 'Material Text' }}
                                    @else 
                                        {{ 'Service' }}
                                    @endif
                                </td>
                                <td>{{ $value->material_id }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $value->unit }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection