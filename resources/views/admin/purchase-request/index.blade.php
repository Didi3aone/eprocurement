@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PR</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>PR No</th>
                                        <th>Request Date</th>
                                        <th>Material ID</th>
                                        <th>Unit</th>
                                        <th>Description</th>
                                        <th>Qty PR</th>
                                        <th>Qty PO</th>
                                        <th>Qty Open</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $key => $value)
                                        <tr>
                                            <input type="hidden" name="qty_pr[]" id="qty_pr_{{ $value->uuid }}" class="qty_pr" value="{{ $value->qty }}">
                                            <input type="hidden" name="qty_open[]" id="qty_open_{{ $value->uuid }}" class="qty_open" value="0">
                                            <td>
                                                <input type="checkbox" name="id[]" id="check_{{ $value->id }}" class="check_pr" value="{{ $value->uuid }}" _valold="{{ $value->id . ':' . $value->pr_no . ':' . $value->rn_no . ':' . $value->material_id }}">
                                                <label for="check_{{ $value->id }}">&nbsp;</label>
                                            </td>
                                            <td>{{ $value->pr_no }}</td>
                                            <td>{{ $value->request_date }}</td>
                                            <td>{{ $value->material_id }}</td>
                                            <td>{{ $value->unit }}</td>
                                            <td>{{ $value->description }}</td>
                                            <td style="text-align: right;">{{ $value->qty }}</td>
                                            <td><input type="text" class="money form-control qty qty_{{ $value->uuid }}" name="qty[]" value="{{ $value->qty }}" style="width: 70%;"></td>
                                            <td class="qty_open_text" style="text-align: right;"><span>0</span></td>
                                            <td>
                                                {{-- @if( $value->is_validate == 1 && $value->approval_status == 12) --}}
                                                {{-- <a class="open_modal_bidding btn btn-xs btn-success" id="open_modal" data-id="{{ $value->id }}" data-toggle="modal" data-target="#modal_create_po" href="javascript:;" >
                                                    <i class="fa fa-truck"></i> Create PO
                                                </a> --}}
                                                {{-- @endif --}}
                                                {{-- <a class="open_modal_bidding btn btn-xs btn-info" href="{{ route('admin.purchase-request-show',$value->id) }}" >
                                                    <i class="fa fa-eye"></i> Show
                                                </a>  --}}
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
                        <a 
                            class="open_modal_bidding btn btn-success" 
                            id="open_modal" 
                            data-toggle="modal" 
                            data-target="#modal_create_po" 
                            href="javascript:;"
                        >
                            <i class="fa fa-check"></i> Create PO
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_create_po" tabindex="-1" role="dialog" aria-labelledby="modalCreatePO" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImport">{{ 'Bidding Model' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <a href="#" class="bidding-online btn btn-primary btn-lg">Online</a>
                    </div>
                    <div class="col-lg-4 text-center">
                        <a href="#" class="bidding-repeat btn btn-info btn-lg">Repeat Order</a>
                    </div>
                    <div class="col-lg-4 text-center">
                        <a href="#" class="bidding-direct btn btn-success btn-lg">Direct Order</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });

    $('.money').mask('#.##0', { reverse: true });

    function countQty($this) {
        const $tr = $this.closest('tr')
        const $qty_pr = parseInt($tr.find('.qty_pr').val())
        let $qty_open_text = $tr.find('.qty_open_text')
        let $qty_open = $tr.find('.qty_open')

        if ($this.val() < 0) {
            alert('Your value cannot less than a zero')

            $this.val($qty_pr)
        } else if ($this.val() > $qty_pr) {
            alert('Your value cannot be more than Quantity')

            $this.val($qty_pr)
        } else {
            let total = $qty_pr - $this.val()
            
            $qty_open_text.html(total)
            $qty_open.val(total)
        }
    }

    $('.qty').on('change blur keyup', function (e) {
        e.preventDefault()
        countQty($(this))
    })

    $(document).on('click', '#open_modal', function (e) {
        e.preventDefault()

        const id = $(this).data('id')
        const check_pr = $('.check_pr:checked')

        let ids = []
        let quantities = []
        let prices = []
        
        for (let i = 0; i < check_pr.length; i++) {
            let id = check_pr[i].value
            ids.push(id)
            // quantities.push($('.qty_pr_' + id).val())
            quantities.push($('.qty_' + id).val())
            // quantities.push($('.qty_open_' + id).val())
        }
        console.log('quantities', quantities)

        ids = btoa(ids)
        quantities = btoa(quantities)

        $('.bidding-online').attr('href', '{{ url("admin/purchase-request-online") }}/' + ids)

        if (check_pr.length > 0) {
            $('.bidding-repeat').attr('href', '{{ url("admin/purchase-request-repeat") }}/' + ids + '/' + quantities)
            $('.bidding-direct').attr('href', '{{ url("admin/purchase-request-direct") }}/' + ids + '/' + quantities)
        } else {
            alert('Please check your material!')
            $('#modal_create_po').modal('hide')
            
            return false
        }
    })

    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        order: [[0, 'desc']],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });

    $(".approve").click(function(e) {
        e.preventDefault();

        swal({
            title: "Approve?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin.request-note.destroy') }}"+id ,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    });
</script>
@endsection