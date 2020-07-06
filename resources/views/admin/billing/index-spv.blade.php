@extends('layouts.admin')
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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Vendor</th>
                                <th>Faktur No.</th>
                                <th>Invoice No.</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billing as $key => $rows)
                                <tr>
                                    <td>{{ isset($rows->vendor) ? $rows->vendor->name : '' }}</td>
                                    <td>{{ $rows->no_faktur }}</td>
                                    <td>{{ $rows->no_invoice }}</td>
                                    <td>{{ App\Models\Vendor\Billing::TypeStatus[$rows->status] }}</td>
                                    <td>
                                        <a href="{{ route('admin.billing-show',$rows->id) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Show</a>
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