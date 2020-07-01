@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.purchase-order.title') }}</a></li>
            <li class="breadcrumb-item active">Index</li>
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
                                <th>{{ trans('cruds.purchase-order.fields.id') }}</th>
                                <th>PO Number</th>
                                <th>PO Date</th>
                                <th>Vendor</th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($po as $key => $q)
                                <tr>
                                    <td>{{ $q->id ?? '' }}</td>
                                    <td>{{ $q->PO_NUMBER }}</td>
                                    <td>{{ $q->po_date }}</td>
                                    <td>{{ $q->vendors['name'] ?? '' }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.purchase-order.show', $q->id) }}">
                                            <i class="fa fa-eye"></i> {{ trans('global.view') }}
                                        </a>
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.purchase-order.edit', $q->id) }}">
                                            <i class="fa fa-edit"></i> {{ trans('global.edit') }}
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
@section('scripts')
@parent
<script>
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection