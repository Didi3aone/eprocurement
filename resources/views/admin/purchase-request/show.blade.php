@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PR Project Verify</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<form class="form-rn m-t-40" action="{{ route('admin.purchase-request-project-approval') }}" enctype="multipart/form-data" method="post">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.purchase-request-project') }}"><i class="fa fa-arrow-left"></i> Back To list</a>
                    <button class="btn btn-success btn-xs approve" type="submit"><i class="fa fa-check"></i> Verify</button>
                    <a class="btn btn-danger btn-xs reject" href="#" data-id="{{ $prProject->id }}"><i class="fa fa-times"></i> Reject</a>
                    <br/><br>
                    <table class="table table-bordered table-striped">
                        <input type="hidden" name="pr_id" value="{{ $prProject->id }}">
                        <tbody>
                            <tr>
                                <th>
                                    Request No
                                </th>
                                <td>
                                    {{ $prProject->request_no }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Request Date
                                </th>
                                <td>
                                    {{ $prProject->request_date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Notes
                                </th>
                                <td>
                                    {{ $prProject->notes }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Project
                                </th>
                                <td>
                                    {{ \App\Models\PurchaseRequest::TypeProject[$prProject->is_project] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Urgensi
                                </th>
                                <td>
                                    {!! \App\Models\PurchaseRequest::TypeUrgent[$prProject->is_urgent] !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Attachment URS
                                </th>
                                @if(isset($prProject->upload_file))
                                    @php
                                        $files = @unserialize($prProject->upload_file);
                                    @endphp
                                    @if( $files !== false )
                                        <td>
                                            @foreach( unserialize((string)$prProject->upload_file) as $fileUpload)
                                                <a href="{{ 'https://employee.enesis.com/public/uploads/'.$fileUpload }}" target="_blank" download>
                                                    {{ $fileUpload ??'' }}
                                                </a>
                                                <br>
                                            @endforeach
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Material ID</th>
                                <th>Material Description</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prProject->purchaseDetail as $key => $value)
                            <tr>
                                <input type="hidden" name="idDetail[]" value="{{ $value->id }}">
                                <td>{{ $value->material_id }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $value->unit }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
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
                url: "{{ route('admin.purchase-request-project-rejected') }}",
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
                location.href = '{{ route('admin.purchase-request-project') }}'
            },500)
        });
    });
</script>
@endsection