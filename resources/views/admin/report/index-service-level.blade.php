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
                    {{-- <div class="form-group">
                        <label>{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    </div> --}}
                </form>
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                               <th>Purchasing Group</th>
                               <th>Description</th>
                               <th>Doc Outstanding</th>
                               <th>Average (Days)</th>
                               <th>Max Outstanding</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service as $key => $value)
                                <tr>
                                    <td>{{ $value->PurchasingGroup }}</td>
                                    <td>{{ $value->description }}</td>
                                    <td>{{ $value->docoutstanding }}</td>
                                    <td>{{ '' }}</td>
                                    <td>{{ '' }}</td>
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