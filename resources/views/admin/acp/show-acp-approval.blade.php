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
                <a class="btn btn-primary" href="{{ route('admin.acp-approval') }}">
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
                                        <th>Currency</th>
                                        <td>{{ $acp->currency }}</td>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Winner</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($acp->detail as $rows)
                                @php
                                    $winner = 'No';
                                    if( $rows->is_winner == \App\Models\AcpTableDetail::Winner ) {
                                        $winner = 'Yes';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $rows->vendor['name'] }}</td>
                                    <td>{{ $rows->vendor['email'] }}</td>
                                    <td>{{ $rows->vendor['address'] }}</td>
                                    <td>{{ $winner }}</td>
                                    <td>
                                            <a 
                                                class="open_modal_bidding btn btn-success" 
                                                id="open_modal" 
                                                data-toggle="modal" 
                                                data-target="#modal_create_po_{{ $rows->vendor_code }}" 
                                                href="javascript:;"
                                            >
                                                <i class="fa fa-cubes"></i> 
                                                Show Detail
                                            </a>
                                        <div class="modal fade" id="modal_create_po_{{ $rows->vendor_code }}" tabindex="-1" role="dialog" aria-labelledby="modalCreatePO" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalImport">{{ 'ACP VIEW' }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Material ID</th>
                                                                    <th>Descriptiom</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach (\App\Models\AcpTableMaterial::getMaterialVendor($rows->vendor_code, $rows->master_acp_id) as $row)
                                                                    <tr>
                                                                        <td>{{ $row->material_id }}</td>
                                                                        <td>{{ $row->description }}</td>
                                                                        <td>{{ number_format($row->price,2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success click" id="save"> <i class="fa fa-check"></i> Approve</button>
                                <a class="btn btn-danger reject" href="#"> <i class="fa fa-times"></i> Reject </a>
                            </div>
                        </div>
                    </div>
                </form>
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