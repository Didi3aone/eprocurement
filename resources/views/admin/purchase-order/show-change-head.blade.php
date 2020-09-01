@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchase Order</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary" href="{{ route('admin.purchase-order.index') }}">
                    <i class="fa fa-arrow-left"></i> Back To list
                </a>
            </div>
            <form action="{{ route('admin.purchase-order-approval-change-head') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="is_approve" id="is_approve" value="1">
                <input type="hidden" name="id" id="idss" value="{{ $purchaseOrder->id }}">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>{{ trans('cruds.purchasing_group.fields.id') }}</th>
                                <td>{{ $purchaseOrder->id }}</td>
                            </tr>
                            <tr>
                                <th>PO Number</th>
                                <td>{{ $purchaseOrder->PO_NUMBER }}</td>
                            </tr>
                            <tr>
                                <th>Notes</th>
                                <td>{{ $purchaseOrder->notes }}</td>
                            </tr>
                            <tr>
                                <th>Vendor</th>
                                <td>{{ $purchaseOrder->vendors['name'] }}</td>
                            </tr>
                            <tr>
                                <th>Payment Term</th>
                                <td>{{ $purchaseOrder->payment_term }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Unit</th>
                                <th>Qty Old</th>
                                <th>Qty New</th>
                                <th>Price Old</th>
                                <th>Price New</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchaseOrder->orderDetail as $key => $value)
                            <tr>
                                <td>{{ $value->material_id." - ".$value->description }}</td>
                                <td>{{ \getUomCode($value->unit) }}</td>
                                <td>{{ $value->qty_old }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $value->original_price }}</td>
                                <td>{{ $value->price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success clicks" id="save"> <i class="fa fa-check"></i> Approve</button>
                                <a class="btn btn-danger reject" href="#" data-approve='0' onclick="reject('{{ $purchaseOrder->id }}')"> <i class="fa fa-times"></i> Reject </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure ? </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @method('put')
                    <input type="hidden" name="is_approve" value="0" id="is_approves">
                    <label>Reason</label>
                    <input type="hidden" name="id" id="ids" value="{{ $purchaseOrder->id }}">
                    <textarea class="form-control" name="reason" id="reason"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary submits">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent 
    <script>
    function reject(id) {
        $(".modal").modal('show')
    }

    function approve(id) {
        $(".modals").modal('show')
    }

    $(".submits").click(function() {
        let value = $("#reason").val()
        let appr = $("#is_approves").val()
        let ids = $("#ids").val()

        $.ajax({
            type: "PUT",
            url: "{{ route('admin.purchase-order-approval-change-head') }}",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token: "{{ csrf_token() }}",
                id : $("#ids").val(),
                reason : value,
                is_approve : appr,
                id : ids
            },
           // dataType:'json',
            success: function (data) {
                //location.reload()
                location.href = '{{ route('admin.purchase-order-change-head') }}'
            }
        });
    })
</script>
@endsection