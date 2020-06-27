@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Repeat Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PO Repeat</a></li>
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
                <a 
                    class="open_modal_bidding btn btn-success" 
                    id="open_modal"
                    href="javascript:;"
                >
                    <i class="fa fa-check"></i> Approval PO
                </a>
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                        <th>Notes</th>
                                        <th>{{ trans('cruds.quotation.fields.status') }} Head</th>
                                        <th>{{ trans('cruds.quotation.fields.status') }} Assistant</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotation as $key => $val)
                                        <tr data-entry-id="{{ $val->id }}">
                                            <td>
                                                @if($val->approval_status == 0 and $val->is_check)
                                                    <input type="checkbox" name="id[]" id="check_{{ $val->id }}" class="check_po" value="{{ $val->id }}" _valold="{{ $val->id }}">
                                                    <label for="check_{{ $val->id }}">&nbsp;</label>
                                                @endif
                                            </td>
                                            <td>{{ $val->id ?? '' }}</td>
                                            <td>{{ $val->po_no ?? '' }}</td>
                                            <td>{{ $val->notes ?? '' }}</td>
                                            <td>
                                                @if($val->approval_status == 1) 
                                                    <span class="badge badge-success"> Approved </span>
                                                @elseif( $val->approval_status == 0)
                                                    <span class="badge badge-primary"> Waiting For Approval </span>
                                                @elseif( $val->approval_status == 2)
                                                    <span class="badge badge-success"> Vendor Confirm </span>
                                                @elseif( $val->approval_status == 3)
                                                    <span class="badge badge-danger"> Rejected </span>
                                                @elseif( $val->approval_status == 4)
                                                    <span class="badge badge-danger"> Vendor Rejected </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($val->approved_asspro == 0)
                                                    <span class="badge badge-primary"> Waiting For Approval </span>
                                                @else
                                                    <span class="badge badge-success"> Approved </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-warning" href="{{ route('admin.quotation-show-repeat', $val->id) }}">
                                                    <i class="fa fa-eye"></i> Show
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_approval_po" tabindex="-1" role="dialog" aria-labelledby="modalCreatePO" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImport">{{ 'Confirm Approval' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Are you sure approval that's PO your selected?</h4>
            </div>
            <div class="modal-footer">
                <a href="#" class="approval_po_repeat btn btn-primary">Yes</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        order: [[0, 'desc']],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $(document).on('click', '#open_modal', function (e) {
        e.preventDefault()

        const id = $(this).data('id')
        const check_po = $('.check_po:checked')

        let ids = []
        
        for (let i = 0; i < check_po.length; i++) {
            let id = check_po[i].value
            ids.push(id)
        }

        ids = btoa(ids)

        $('.approval_po_repeat').attr('href', '#')

        if (check_po.length > 0) {
            $('#modal_approval_po').modal('show')
            $('.approval_po_repeat').attr('href', '{{ url("admin/quotation/repeat/approve") }}/' + ids)
        } else {
            alert('Please check your PO!')
            $('#modal_approval_po').modal('hide')
            
            return false
        }
    })
</script>
@endsection