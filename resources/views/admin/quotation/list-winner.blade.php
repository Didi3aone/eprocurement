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
{{-- @can('quotation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route("admin.quotation.create") }}">
                <i class='fa fa-plus'></i> {{ trans('global.add') }} {{ trans('cruds.quotation.title_singular') }}
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_import">
                <i class="fa fa-download"></i> {{ trans('cruds.quotation.import') }}
            </button>
        </div>
    </div>
@endcan --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
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
                                            <td>{{ $val->id ?? '' }}</td>
                                            <td>{{ $val->po_no ?? '' }}</td>
                                            <td>{{ $val->name . ' - ' . $val->email ?? '' }}</td>
                                            <td>{{ $val->target_price ?? '' }}</td>
                                            <td>
                                                @php $is_expired = '#67757c' @endphp
                                                @if (time() > strtotime($val->expired_date))
                                                    @php $is_expired = 'red'; @endphp
                                                @elseif (time() > strtotime('-2 days', strtotime($val->expired_date)) && time() <= strtotime($val->expired_date))
                                                    @php $is_expired = 'orange'; @endphp
                                                @endif
                                                <span style="color: {{ $is_expired }}">{{ $val->expired_date ?? '' }}</span>
                                            </td>
                                            <td>{{ $val->vendor_leadtime ?? '' }}</td>
                                            <td>{{ $val->vendor_price ?? '' }}</td>
                                            <td>{{ $val->qty ?? '' }}</td>
                                            <td>
                                                @can('quotation_approve')
                                                    <a class="btn btn-xs btn-success approve" id="save_{{ $key }}" data-row="{{ $key }}" data-req="{{ $val->id }}" data-id="{{ $val->approval_id }}" href="javascript:;">
                                                        <i class="fa fa-check"></i> Approve
                                                    </a>
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

                <div class="row" style="margin-top: 20px">
                    <div class="col-lg-12">
                        <div class="form-actions">
                            {{-- <input type="hidden" name="total" value="{{ $total }}"> --}}
                            {{-- <button type="submit" class="btn btn-success click"> <i class="fa fa-check"></i> {{ trans('global.winner') }}</button> --}}
                            <button type="button" class="btn btn-inverse">Cancel</button>
                            <img id="image_loading" src="{{ asset('img/ajax-loader.gif') }}" alt="" style="display: none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('cruds.quotation.import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.quotation.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" name="xls_file" id="xls_file">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
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
        var row = $(this).data("row");
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        // console.log(id, no, row, CSRF_TOKEN)

        swal({   
            title: "Are you sure?",   
            text: "Approve this PR",   
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