@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Direct Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Direct</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary" href="{{ route('admin.master-acp.index') }}">
                    <i class="fa fa-arrow-left"></i> Back To list
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.post-acp-approval') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="quotation_id" value="{{ $acp->id }}">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>ACP No.</th>
                                        <td>{{ $acp->acp_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Project</th>
                                        <td>{{ $acp->is_project == 1 ? 'Project' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Plant</th>
                                        <td>{{  \getplan($acp->plant_id)->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>File</th>
                                        @if(isset($acp->upload_file))
                                            <td>
                                                @php
                                                    $files = @unserialize($acp->upload_file);
                                                @endphp
                                                @if( is_array($files))
                                                    @foreach( unserialize((string)$acp->upload_file) as $fileUpload)
                                                        <a href="{{ asset('/files/uploads/'.$fileUpload) ??''}}" target="_blank" download>
                                                            {{ $fileUpload ??'' }}
                                                        </a>
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                </div>
                                </tbody>
                            </table>
                        </div> 
                    </div><br>
                    <div class="row">
                        <table class="table table-bordered table-condesed">
                            <thead>
                                <tr>
                                    <th><b>Vendor</b></th>
                                    <th><b>Winner</b></th>
                                    <th style="text-align:center;">Material</th>
                                    <th style="text-align:center;">Description</th>
                                    <th style="text-align:center;">Unit</th>
                                    <th style="text-align:center;">Per</th>
                                    <th style="text-align:center;">Currency</th>
                                    <th style="text-align:center;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($acp->detail as $rows)
                                @php
                                    $winner = '<span class="badge badge-danger">Lose</span>';
                                    if( $rows->is_winner == \App\Models\AcpTableDetail::Winner ) {
                                        $winner = '<span class="badge badge-primary">Winner</span>';
                                    }
                                    $rowSpan = count(\App\Models\AcpTableMaterial::getMaterialVendor($rows->vendor_code, $rows->master_acp_id));
                                @endphp
                                <tr>
                                    <td rowspan={{ $rowSpan }}>{{ $rows->vendor['name'] }}</td>
                                    <td rowspan={{ $rowSpan }}>{!! $winner !!}</td>
                                    @foreach (\App\Models\AcpTableMaterial::getMaterialVendor($rows->vendor_code, $rows->master_acp_id) as $row)
                                        <td>{{ $row->material_id ?? '-'}}</td>
                                        <td>{{ \App\Models\MasterMaterial::getMaterialName($row->material_id)->description ?? $row->material_id  }}</td>
                                        <td>{{ $row->uom_code }}</td>
                                        <td>{{ $row->qty }}</td>
                                        <td>{{ $row->currency }}</td>
                                        <td>{{ \toDecimal($row->price) }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-condesed">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Approve Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approval as $key => $value)
                            <tr>
                                <td>{{ $value->nik }}</td>
                                <td>{{ $value->getUser['name'] }}</td>
                                <td>
                                    @if($value->status == 0) 
                                        Waiting Approval 
                                    @elseif($value->status == 2) 
                                        Approved 
                                    @elseif($value->status == 3)
                                        Rejected 
                                    @endif
                                </td>
                                <td>{{ $value->approve_date ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Reason</label>
                    <textarea type="text" class="form-control form-control-line" name="description" disabled>{{ $acp->description }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent 
    <script>
    $('.reject').click(function(e){
        e.preventDefault();
        let id = $(this).data('id');

        swal("Input reason rejected !!!", {
            content: "input",
        })
        .then((value) => {
            $.ajax({
                type: "PUT",
                url: "{{ route('admin.billing-post-rejected') }}",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id : id,
                    reason : value
                },
                dataType:'json',
                success: function (data) {
                
                }
            });

            setTimeout(function() {
               // location.reload();
            },500)
        });
    });
</script>
@endsection