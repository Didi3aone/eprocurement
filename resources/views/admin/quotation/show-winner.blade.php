@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">List Winner</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.quotation.approve') }}" method="post">
                    @csrf
                    <input type="hidden" name="quotation_id" value="{{ $id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive m-t-40">
                                <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.vendor_id') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.target_price') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.expired_date') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.vendor_leadtime') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.vendor_price') }}</th>
                                            <th>{{ trans('cruds.quotation.fields.qty') }}</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quotation as $key => $val)
                                            <tr data-entry-id="{{ $val->id }}">
                                                <input type="hidden" name="vendor_price[]" value="{{ $val->vendor_price }}">
                                                <input type="hidden" name="id[]" value="{{ $val->id }}">
                                                <td>
                                                    <input type="checkbox" name="vendor_id[]" id="check_{{ $val->vendor_id }}" value="{{ $val->vendor_id }}">
                                                    <label for="check_{{ $val->vendor_id }}">&nbsp;</label>
                                                </td>
                                                <td>{{ $val->id ?? '' }}</td>
                                                <td>{{ $val->quotation->po_no ?? '' }}</td>
                                                <td>{{ $val->vendor->name . ' - ' . $val->vendor->email ?? '' }}</td>
                                                <td>{{ number_format($val->quotation->target_price, 0, '', '.') ?? '' }}</td>
                                                <td>
                                                    @php $is_expired = '#67757c' @endphp
                                                    @if (time() > strtotime($val->quotation->expired_date))
                                                        @php $is_expired = 'red'; @endphp
                                                    @elseif (time() > strtotime('-2 days', strtotime($val->quotation->expired_date)) && time() <= strtotime($val->quotation->expired_date))
                                                        @php $is_expired = 'orange'; @endphp
                                                    @endif
                                                    <span style="color: {{ $is_expired }}">{{ $val->quotation->expired_date ?? '' }}</span>
                                                </td>
                                                <td>{{ $val->vendor_leadtime ?? '' }}</td>
                                                <td>{{ number_format($val->vendor_price, 0, '', '.') ?? '' }}</td>
                                                <td>{{ number_format($val->qty, 0, '', '.') ?? '' }}</td>
                                                <td>
                                                    @can('quotation_approve')
                                                        {{-- <a class="btn btn-xs btn-success approve" id="save_{{ $key }}" data-row="{{ $key }}" data-req="{{ $val->id }}" data-id="{{ $val->approval_id }}" href="javascript:;">
                                                            <i class="fa fa-check"></i> Approve
                                                        </a> --}}
                                                    @endcan

                                                    {{-- @can('quotation_edit')
                                                        <a class="btn btn-xs btn-info" href="{{ route('admin.quotation.edit', $val->id) }}">
                                                            {{ trans('global.edit') }}
                                                        </a>
                                                    @endcan --}}

                                                    @can('quotation_delete')
                                                        {{-- <form action="{{ route('admin.quotation.destroy', $val->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                        </form> --}}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check"></i> Approve</button>
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
    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $('.approve').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var no = $(this).data('req');
        var row = $(this).data('row');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        // console.log(id, no, row, CSRF_TOKEN)

        swal({   
            title: "Are you sure?",   
            text: "Approve the Winner?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes",   
            cancelButtonText: "No!",   
            closeOnConfirm: true,   
            closeOnCancel: true 
        }).then(() => {
            $("#save_"+row).attr('disabled', 'disabled');
            $('#save_'+row).text('Please wait ...')
            
            $.ajax({
                type: "PUT",
                url: "{{ route('admin.quotation.approve') }}",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _token: CSRF_TOKEN,
                    id : id,
                    req_id : no
                },
                dataType:'json',
                success: function (data) {
                    if( data.success == true ) {
                        swal("Success!", "Winner has been approved.", "success");   
                        location.reload();
                    } else {
                        swal('Error!',"Something went wrong","error");
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            // } else {     
                // swal("Cancelled", "Your imaginary file is safe :)", "error");   
            // } 
        });
    });
</script>
@endsection