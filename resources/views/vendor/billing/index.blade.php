@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Billing</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Billing</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-6">
        <a class="btn btn-success" href="{{ route("vendor.billing-create") }}">
            <i class='fa fa-plus'></i> Create Billing
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Faktur No.</th>
                                <th>Invoice No.</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billing as $key => $rows)
                                <tr>
                                    <td>{{ $rows->no_faktur }}</td>
                                    <td>{{ $rows->no_invoice }}</td>
                                    <td>{{ App\Models\Vendor\Billing::TypeStatus[$rows->status] }}</td>
                                    <td>
                                        @if($rows->status != \App\Models\Vendor\Billing::Approved)
                                        {{-- <a href="{{ route('vendor.billing-edit',$rows->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Show</a> --}}
                                        {{-- <a href="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a> --}}
                                        {{-- <a href="{{ route('vendor.billing-show',$rows->id) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Show</a> --}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <thead>
                            <tr>
                                <th>PO No</th>
                                <th>Material</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Plant</th>
                                <th>Profit Center</th>
                                <th>Store loc</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_orders as $po)
                            <tr>
                                <td>{{ $po->PO_NUMBER }}</td>
                                <td>{{ $po->material_id }}</td>
                                <td>{{ $po->price }}</td>
                                <td>{{ $po->qty }}</td>
                                <td>{{ $po->unit }}</td>
                                <td>{{ $po->plant_code }}</td>
                                <td>{{ $po->storage_location }}</td>
                                <td>
                                    <a href="{{ route('vendor.billing-show', $po->id) }}" class="href btn btn-info btn-xs">
                                        <i class="fa fa-eye"></i> Show
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection