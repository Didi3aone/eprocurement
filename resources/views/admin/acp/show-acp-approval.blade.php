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
                <a class="btn btn-primary btn-xs" href="{{ route('admin.acp-approval') }}">
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
                                                @else 
                                                    {{-- No file found --}}
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
                                    $totalPrice = 0;
                                @endphp
                                <tr>
                                    <td rowspan={{ $rowSpan }}>{{ $rows->vendor['name'] }}</td>
                                    <td rowspan={{ $rowSpan }}>{!! $winner !!}</td>
                                    @foreach (\App\Models\AcpTableMaterial::getMaterialVendor($rows->vendor_code, $rows->master_acp_id) as $key => $row)
                                        @php
                                            $total = (\removeComma($row->price) * $row->qty);
                                            $totalPrice += ($total);
                                            $data = count(\App\Models\AcpTableMaterial::getMaterialVendor($rows->vendor_code, $rows->master_acp_id));
                                           // dd($data);
                                        @endphp
                                        <td>{{ $row->material_id ?? $row->material_id }}</td>
                                        <td>{{ \App\Models\MasterMaterial::getMaterialName($row->material_id)->description ?? $row->material_id  }}</td>
                                        <td>{{ $row->uom_code }}</td>
                                        <td>{{ $row->qty }}</td>
                                        <td>{{ $row->currency }}</td>
                                        <td>{{ \toDecimal($row->price) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan={{ $rowSpan + 2 }}></td>
                                    <td colspan={{ $rowSpan + $rowSpan }}>
                                        <b style="color:black;font-size:17px;">{{ \toDecimal($totalPrice) }}</b>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea type="text" class="form-control form-control-line" name="description" disabled>{{ $acp->description }}</textarea>
                    </div>
                    @if($acp->status_approval != 2  && $acp->status_approval !=3)
                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success click" id="save"> <i class="fa fa-check"></i> Approve</button>
                                <a class="btn btn-danger reject" href="#" onclick="reject('{{ $acp->id }}')" data-id="{{ $acp->id }}"> <i class="fa fa-times"></i> Reject </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            {{-- <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condesed">
                            <thead>
                                <tr>
                                    <th><b>Employee ID</b></th>
                                    <th><b>Status</b></th>
                                    <th style="text-align:center;">Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
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
                    <label>Reason</label>
                    <input type="hidden" name="ids" id="ids" value="{{ $acp->id }}">
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

    $(".submits").click(function() {
        let value = $("#reason").val()

        $.ajax({
            type: "POST",
            url: "{{ route('admin.acp-post-rejected') }}",
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
                location.href = '{{ route('admin.acp-approval') }}'
            }
        });
    })
</script>
@endsection