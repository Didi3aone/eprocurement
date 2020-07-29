@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">PR Project</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.profit_center.title') }}</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="dispcay nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">
                                    #
                                </th>
                                <th>
                                    Request No
                                </th>
                                <th>
                                    Request Date
                                </th>
                                <th>
                                    Urgensi
                                </th>
                                <th>
                                    Notes
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prProject as $key => $proj)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>{{ $proj->request_no ?? '' }}</td>
                                    <td>{{ $proj->request_date ?? '' }}</td>
                                    <td>{!! \App\Models\PurchaseRequest::TypeUrgent[$proj->is_urgent] !!}</td>
                                    <td>{{ $proj->notes ?? '' }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin.purchase-request.show', $proj->id) }}">
                                            <i class="fa fa-eye"></i> Show
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
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection