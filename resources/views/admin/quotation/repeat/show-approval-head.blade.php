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
                                    <td>{{ $quotation->po_no }}</td>
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
                        @foreach($quotation->detail as $key => $value)
                            <tr>
                                <td>{{ $value->material." - ".$value->description }}</td>
                                <td>{{ $value->unit }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $value->currency }}</td>
                                <td>{{ $value->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="form-actions">
                    <a href="#" class="btn btn-success approve" onclick="approve('{{ $quotation->id }}')" id="save"> <i class="fa fa-check"></i> Approve</a>
                    <button type="button" class="btn btn-danger" onclick="reject('{{ $quotation->id }}')"><i class="fa fa-times"></i>  Reject</button>
                </div>
            </div>
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
                <label>Reason</label>
                <input type="hidden" name="ids" id="ids" value="">
                <textarea class="form-control" name="reason" id="reason"></textarea>
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
    function reject(id) 
    {
        $("#ids").val(id)
        $(".modal").modal('show')
    }

    function approve(id) 
    {
        let idss = btoa(id) 
        $('.approve').attr('href', '{{ url("admin/quotation/repeat/approve/head/") }}/' + idss)
    }

    $(".submits").click(function() {
        let value = $("#reason").val()

        $.ajax({
            type: "PUT",
            url: "{{ route('admin.quotation-repeat-rejected-head') }}",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token: "{{ csrf_token() }}",
                id : $("#ids").val(),
                reason : value
            },
           // dataType:'json',
            success: function (data) {
                //location.reload()
                location.href = '{{ route('admin.quotation-repeat-approval-head') }}'
            }
        });
    })
</script>
@endsection