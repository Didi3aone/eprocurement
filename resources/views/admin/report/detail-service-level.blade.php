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
{{-- {{ dd($data) }} --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <a href="{{ route('admin.report-service-level') }}" class="btn btn-secondary">Back to list </a>
                </form>
                <div class="table-responsive m-t">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                               <th>No</th>
                               <th>PG</th>
                               <th>PG Desc</th>
                               <th>NO PR</th>
                               <th>PR Realese</th>
                               <th>Difference</th>
                               <th>PR Item</th>
                               <th>Doc Type</th>
                               <th>Meterial ID</th>
                               <th>Description</th>
                               <th>Short Text</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1 ;
                            @endphp
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $value->code }}</td>
                                    <td>{{ $value->pg_desc }}</td>
                                    <td>{{ $value->PR_NO }}</td>
                                    <td>{{ $value->realese_pr }}</td>
                                    <td>{{ $value->date_diff }}</td>
                                    <td>{{ $value->preq_item }}</td>
                                    <td>{{ $value->doc_type }}</td>
                                    <td>{{ $value->material_id }}</td>
                                    <td>{{ $value->description }}</td>
                                    <td>{{ $value->short_text }}</td>
                                </tr>
                                @php
                                    $no++ ;
                                @endphp
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