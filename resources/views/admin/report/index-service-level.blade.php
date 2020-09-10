@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Report</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Service Level</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row col-12">
                        <div class="form-group">
                            <label>Current Date</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{date('d-m-Y')}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Total Doc Out Standing</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $total_doc }}" readonly>
                        </div>
                    </div>
                </form>
                <div class="table-responsive m-t">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                               <th>Purchasing Group</th>
                               <th>Description</th>
                               <th>Doc Outstanding</th>
                               <th>Average (Days)</th>
                               <th>Max Outstanding</th>
                               <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service as $key => $value)
                                <tr>
                                    <td>{{ $value->purchasing_group_code }}</td>
                                    <td>{{ $value->pg_desc }}</td>
                                    <td>{{ $value->total }}</td>
                                    <td>{{ $value->rata }}</td>
                                    <td>{{ $value->max_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.report-service-level-detail', $value->purchasing_group_code) }}" class="btn btn-primary" >Detail</a>
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
    pageLength: 50,
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection