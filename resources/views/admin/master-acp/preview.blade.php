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
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>ACP No.</th>
                                    <td>{{ $data['reference_acp_no'] }}</td>
                                </tr>
                                <tr>
                                    <th>Project</th>
                                    <td>{{ $data['is_project'] ? 'Project' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>File</th>
                                    @foreach($images as $image)
                                        <td>
                                            <a href="{{ $image ?? ''}}" target="_blank" download>
                                                {{ $image ??'' }}
                                            </a>
                                            <br>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
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
                        @foreach($vendors as $vendor)
                            @php
                                $count = count($data['material_'.$vendor->code]);
                            @endphp
                            <tr>
                                <td rowspan={{ $count }}>{{ $vendor->name }}</td>
                                @if(isset($data['winner_'.$vendor->code]))
                                    <td rowspan={{ $count }}>{!! $data['winner_'.$vendor->code] ? '<span class="badge badge-primary">Winner</span>' : '<span class="badge badge-danger">Lose</span>' !!}</td>
                                @else
                                    <td rowspan={{ $count }}><span class="badge badge-danger">Lose</span></td>
                                @endif
                                @foreach($data['material_'.$vendor->code] as $key => $material)
                                    @php
                                        $row = \App\Models\MasterMaterial::where('code', $material)->first();
                                    @endphp
                                    <td>{{ $row->code ?? $material }}</td>
                                    <td>{{ $row->description ?? $material  }}</td>
                                    <td>{{ $row->uom_code ?? '-' }}</td>
                                    <td>{{ $data['qty_'.$vendor->code][$key] }}</td>
                                    <td>{{ $data['currency_'.$vendor->code][$key] }}</td>
                                    <td>{{ number_format($data['price_'.$vendor->code][$key], 2) }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success pull-right approve">Confirm</button>
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