@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Billing</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Billing</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <a class="btn btn-primary btn-xs" href="{{ route('admin.billing') }}"><i class="fa fa-arrow-left"></i> Back To list</a>
            @if($billing->status == \App\Models\Vendor\Billing::WaitingApprove)
                <a class="btn btn-success btn-xs approve" data-id="{{ $billing->id }}" href="#"><i class="fa fa-check"></i> Approve</a>
                <a class="btn btn-danger btn-xs reject" data-id="{{ $billing->id }}" href="#"><i class="fa fa-times"></i> Reject</a>
            @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                No. Faktur
                            </th>
                            <td>
                                {{ $billing->no_faktur }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tgl. Faktur
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($billing->tgl_faktur)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                File
                            </th>
                            <td>
                                <a href="{{ asset('files/uploads', $billing->file_faktur) }}">
                                    {{ $billing->file_faktur }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                No. Invoice
                            </th>
                            <td>
                                {{ $billing->no_invoice }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tgl. Invoice
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($billing->tgl_invoice)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Nominal Setelah PPN
                            </th>
                            <td>
                                {{ $billing->nominal_inv_after_ppn }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                File Invoice
                            </th>
                            <td>
                                <a href="{{ asset('files/uploads', $billing->file_invoice) }}">
                                    {{ $billing->file_invoice }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                No. Surat Jalan
                            </th>
                            <td>
                                {{ $billing->no_surat_jalan }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tgl. Surat Jalan
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($billing->tgl_surat_jalan)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                PO
                            </th>
                            <td>
                                <a href="{{ asset('files/uploads', $billing->po) }}">
                                    {{ $billing->po }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Keterangan PO
                            </th>
                            <td>
                                {{ $billing->keterangan_po }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent 
    <script>
    $('.approve').click(function(e){
        e.preventDefault();
        let id = $(this).data('id')

        swal({
            title: "Are you sure?",
            text: "Approve this billings",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "PUT",
                    url: "{{ route('admin.billing-post-approved') }}",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        _token: "{{ csrf_token() }}",
                        id : id
                    },
                    dataType:'json',
                    success: function (response) {
                        location.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });
        
    });
        
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
                location.reload();
            },500)
        });
    });
</script>
@endsection