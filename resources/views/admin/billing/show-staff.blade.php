@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Detail</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.billing.title') }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form class="form-material m-t-40" action="{{ route("admin.billing-post-approved") }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{ $billing->id }}">
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Attachment</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ trans('cruds.billing.fields.file_invoice') }}</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->file_invoice) }}">{{ $billing->file_invoice }}</a></td>
                            </tr>
                            <tr>
                                <th>File PO</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->po) }}">{{ $billing->po  }}</a> </td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.billing.fields.file_faktur') }}</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->file_faktur ) }}">{{ $billing->file_faktur }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.billing.fields.file_skp') }}</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->surat_ket_bebas_pajak) }}">{{ $billing->surat_ket_bebas_pajak }}</a></td>
                            </tr>
                            <tr>
                                <th>No Surat jalan</th>
                                <td><a href="{{ asset('file/uploads/'.$billing->no_surat_jalan) }}">{{ $billing->no_surat_jalan }}</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Detail Billing</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.vendor_id') }}</label>
                            <input type="text" class="form-control form-control-line" name="vendor_id" value="{{ $billing->vendor_id }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>{{ trans('cruds.billing.fields.proposal_id') }}</label>
                            <input type="text" class="form-control form-control-line" name="billing_no" value="{{ $billing->billing_no ?? old('billing_no', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No Faktur Pajak</label>
                            <input type="text" class="form-control form-control-line" name="no_faktur" value="{{ $billing->no_faktur ?? old('no_faktur', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Faktur Pajak</label>
                            <input type="text" id="mdate" class="form-control form-control-line" name="tgl_faktur" value="{{ $billing->tgl_faktur ?? old('tgl_faktur', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Invoice</label>
                            <input type="text" class="form-control form-control-line" name="no_invoice" value="{{ $billing->no_invoice ?? old('no_invoice', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Tanggal Invoice</label>
                            <input type="text" class="form-control mdate2 form-control-line" name="tgl_invoice" value="{{ $billing->tgl_invoice ?? old('tgl_invoice', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Nominal Invoice Sesudah PPN</label>
                            <input type="text" class="form-control form-control-line" name="nominal_inv_after_ppn" value="{{ $billing->nominal_inv_after_ppn ?? old('nominal_inv_after_ppn', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>PPN</label>
                            <input type="text" class="form-control form-control-line" name="ppn" value="{{ $billing->ppn ?? old('ppn', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>DPP</label>
                            <input type="text" class="form-control form-control-line" name="dpp" id="dpp" value="{{ $billing->dpp ?? old('dpp', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>No. Rekening </label>
                            <input type="text" class="form-control form-control-linn" name="no_rekening" value="{{ $billing->no_rekening ?? old('no_rekening', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>NPWP</label>
                            <input type="text" id="" class="form-control form-control-line" name="npwp" value="{{ $billing->npwp ?? old('npwp', '') }}" readonly> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Keterangan PO</label>
                            <input type="text" id="" class="form-control form-control-line" name="keterangan_po" value="{{ $billing->keterangan_po ?? old('keterangan_po', '') }}" readonly> 
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="title col-lg-8">Purchase Order List</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="datatables-run">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">Qty</th>
                                        <th>Value</th>
                                        <th>Material</th>
                                        <th>PO No</th>
                                        <th>PO Item</th>
                                        <th>GR Doc</th>
                                        <th>GR No</th>
                                        <th>GR Date</th>
                                    </tr>
                                </thead>
                                <tbody id="billing-detail">
                                    @foreach ($billing->detail as $val)
                                    <tr>
                                        <input type="hidden" value="{{ $val->id }}" name="iddetail[]">
                                        <input type="hidden" name="po_no" value="{{ $val->po_no }}">
                                        <td>{{ $val->qty }}</td>
                                        <td>{{ $val->amount }}</td>
                                        <td>{{ $val->material_id." - ".$val->material->description }}</td>
                                        <td>{{ $val->po_no }}</td>
                                        <td>{{ $val->PO_ITEM }}</td>
                                        <td>{{ $val->doc_gr }}</td>
                                        <td>{{ $val->item_gr }}</td>
                                        <td>{{ $val->gr_date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-actions">
                        @if($billing->status == \App\Models\Vendor\Billing::WaitingApprove)
                        <a href="javascript:;" id="approval" type="button" class="btn btn-success"> <i class="fa fa-check"></i> {{ 'approved' }}</a>
                        <a href="javascript:;" id="reject" data-toggle="modal" data-id="{{ $billing->id }}" data-target="#modal_rejected_reason" type="button" class="btn btn-danger"> 
                            <i class="fa fa-times"></i> {{ trans('global.reject') }}
                        </a>
                        @elseif($billing->status == \App\Models\Vendor\Billing::Approved )
                        <a href="javascript:;" id="verify" type="button" class="btn btn-success"> <i class="fa fa-check"></i> {{ 'verify' }}</a>
                        <a href="javascript:;" id="rejects" data-toggle="modal" data-id="{{ $billing->id }}" data-target="#modal_rejected_reasons" type="button" class="btn btn-warning"> 
                        <i class="fa fa-times"></i> {{ 'Incomplete' }}</a>
                        @endif
                        <a href="{{ route('admin.billing-spv-list') }}" type="button" class="btn btn-inverse"><i class="fa fa-arrow-left"></i>Back To List</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal_rejected_reason" tabindex="-1" role="dialog" aria-labelledby="modal_rejected_reason" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejected Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.billing-post-rejected') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="billing-id" value="">
                    <textarea name="reason" id="reason" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_rejected_reasons" tabindex="-1" role="dialog" aria-labelledby="modal_rejected_reasons" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Incomplete Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.billing-post-incompleted') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="billing-id" value="">
                    <textarea name="reason" id="reason" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>

    $(document).on('click', '#approval', function (result) {
        $form = $('.form-material')
        $form.attr('action', '{{ route('admin.billing-post-approved') }}')
        $form.submit()
    })


    $(document).on('click', '#verify', function (result) {
        $form = $('.form-material')
        $form.attr('action', '{{ route('admin.billing-post-verify') }}')
        $form.submit()
    })

    $(document).on('click', '#reject', function (result) {
        const $modal = $('#modal_rejected_reason')
        $modal.find('#billing-id').val($(this).data('id'))
        $modal.modal('show')
    })

    $(document).on('click', '#rejects', function (result) {
        const $modal = $('#modal_rejected_reasons')
        $modal.find('#billing-id').val($(this).data('id'))
        $modal.modal('show')
    })

    $(document).on('click', '#submit', function (result) {
        $form = $('.form-material')
        $form.attr('action', '{{ route('admin.billing-store') }}')
        $form.submit()
    })

    $("#check_1").click(function() {
        if(this.checked) {
            if( this.value == 1) {
                $("#taxAmount").attr('readonly',true)
                $("#nominal_invoice_staff").attr('readonly',true)
            } 
        } else {
            $("#nominal_invoice_staff").attr('readonly',false)
            $("#taxAmount").attr('readonly',false)
        }
    })

    $(function() {
     
    })

</script>
@endsection