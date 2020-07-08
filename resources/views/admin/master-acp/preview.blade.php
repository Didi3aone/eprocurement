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
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <h4>Upload File</h4>
                        @foreach($images as $image)
                            <img src="{{ $image }}" class="rounded img-responsive"/>
                        @endforeach
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <dl class="row mt-4">
                            <dt class="col-sm-3">Material From PR</dt>
                            <dd class="col-sm-9">{{ $data['is_from_pr'] ? 'Yes' : 'No' }}</dd>
                            <dt class="col-sm-3">Project</dt>
                            <dd class="col-sm-9">{{ $data['is_project'] ? 'Yes' : 'No' }}</dd>
                            <dt class="col-sm-3">Reference Acp No</dt>
                            <dd class="col-sm-9">{{ $data['reference_acp_no'] }}</dd>
                            <dt class="col-sm-3">Start Date</dt>
                            <dd class="col-sm-9">{{ $data['start_date'] }}</dd>
                            <dt class="col-sm-3">End Date</dt>
                            <dd class="col-sm-9">{{ $data['end_date'] }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="row mt-4">
                    @foreach($vendors as $vendor)
                        <div class="col-12 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-3">Vendor Code</dt>
                                        <dd class="col-sm-9">{{ $vendor->code }}</dd>
                                        <dt class="col-sm-3">Vendor Name</dt>
                                        <dd class="col-sm-9">{{ $vendor->name }}</dd>
                                        <dt class="col-sm-3">Email</dt>
                                        <dd class="col-sm-9">{{ $vendor->email }}</dd>
                                        <dt class="col-sm-3">Winner</dt>
                                        @if(isset($data['winner_'.$vendor->code]))
                                            <dd class="col-sm-9">{{ $data['winner_'.$vendor->code] ? 'Yes' : 'No' }}</dd>
                                        @else
                                            <dd class="col-sm-9">No</dd>
                                        @endif
                                    </dl>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Material Code</th>
                                                <th>Currency</th>
                                                <th>Price</th>
                                                <th>Per</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['material_'.$vendor->code] as $key => $material)
                                            <tr>
                                                <td>{{ \App\Models\MasterMaterial::where('code', $material)->first()->description ?? 'Undefined' }}</td>
                                                <td>{{ $data['currency_'.$vendor->code][$key] }}</td>
                                                <td>{{ $data['price_'.$vendor->code][$key] }}</td>
                                                <td>{{ $data['qty_'.$vendor->code][$key] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success pull-right approve">Approve</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent 
    <script>
    $('.approve').on('click', function(){
        window.close();
    })
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