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
                <a 
                    class="open_modal_bidding btn btn-success" 
                    id="open_modal" 
                    data-toggle="modal" 
                    data-target="#modal_create_po" 
                    href="javascript:;"
                >
                    <i class="fa fa-truck"></i> Create PO
                </a>
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Purchase Requisition</th>
                                        <th>Doc. Type</th>
                                        <th>Item Of Requisition</th>
                                        <th>Release Date</th>
                                        <th>Material</th>
                                        <th>Short Text</th>
                                        <th>Qty Requested</th>
                                        <th>Unit</th>
                                        <th>Plant</th>
                                        <th>Storage Location</th>
                                        <th>Qty Ordered</th>
                                        <th>Qty Open</th>
                                        <th>Deliv. Date Category</th>
                                        <th>Material Group</th>
                                        <th>Purchasing Group</th>
                                        <th>Requisitioner</th>
                                        <th>Last PO</th>
                                        <th>Req Tracking Number</th>
                                        <th>Delivery Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
                <h5 class="modal-title" id="modalImport">{{ 'Purchase Order Model' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-lg-4 text-center">
                        <a href="#" class="bidding-online btn btn-primary btn-lg">Online</a>
                    </div> --}}
                    <div class="col-lg-6 text-center">
                        <a href="#" class="bidding-repeat btn btn-info btn-lg">Repeat Order</a>
                    </div>
                    <div class="col-lg-6 text-center">
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
<script id="hidden_input" type="text/x-custom-template">
    <input type="checkbox" name="id[]" class="check_pr">
    <label>&nbsp;</label>
    <input type="hidden" name="qty_pr[]" class="qty_pr">
    <input type="hidden" name="qty_open[]" class="qty_open" value="0">
</script>
<script id="hidden_qty" type="text-x-custom-template">
    <input type="text" class="money form-control qty" name="qty[]" style="width: 70%;">
</script>
<script id="hidden_doc" type="text-x-custom-template">
    <input type="text" class="form-control doctype" readonly name="doctype[]" style="width: 70%;">
</script>
<script id="hidden_group" type="text-x-custom-template">
    <input type="text" class="form-control groups" readonly name="group[]" style="width: 70%;">
</script>
<script id="hidden_dialog" type="text-x-custom-template">
<a 
    class="modal_link"
    href="javascript:;"
>value</a>
<div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="modalCreatePO" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImport">{{ 'History Approval' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Status</th>
                            <th>Approved Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</script>
<script>
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });

    $('.money').mask('#.##0', { reverse: true });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
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
        let docs = []
        let groups = []
        
        for (let i = 0; i < check_pr.length; i++) {
            let id = check_pr[i].value
            ids.push(id)
            // quantities.push($('.qty_pr_' + id).val())
            quantities.push($('.qty_' + id).val())
            docs.push($('.docs_' + id).val())
            groups.push($('.groups_' + id).val())
            // quantities.push($('.qty_open_' + id).val())
        }
        console.log('ids', ids, 'quantities', quantities,'docs',docs,'groups',groups)

        ids = btoa(ids)
        quantities = btoa(quantities)
        docs = btoa(docs)
        groups = btoa(groups)

        $('.bidding-online').attr('href', '{{ url("admin/purchase-request-online") }}/' + ids + '/' + quantities)

        if (check_pr.length > 0) {
            $('.bidding-repeat').attr('href', '{{ url("admin/purchase-request-repeat") }}/' + ids + '/' + quantities +'/'+ docs + '/' + groups)
            $('.bidding-direct').attr('href', '{{ url("admin/purchase-request-direct") }}/' + ids + '/' + quantities +'/'+ docs + '/' + groups)
        } else {
            alert('Please check your material!')
            $('#modal_create_po').modal('hide')
            
            return false
        }
    })

    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        processing: true,
        serverSide: true,
        pageLength: 50,
        scrollY         : "800px",
        scrollCollapse  : true,
        ajax: "/admin/purchase-request",
        "createdRow": function( row, data, dataIndex ) {
            var tp1 = $('#hidden_input').html()
            var tp2 = $('#hidden_qty').html()
            var tp3 = $('#hidden_dialog').html()
            var tp4 = $("#hidden_doc").html()
            var tp5 = $("#hidden_group").html()

            // console.log(row,data,dataIndex)
            $modal = $(row).children('td')[1]
            $($modal).html(tp3)
            $($modal).children('a').text(data[1])
            $tbody = $($modal).find('.modal tbody')
            $tbody.append('<tr></tr>')
            data[20].map(function(list){
                $tbody.children('tr').append(`<td>${list}</td>`)
            })
            $($modal).children('a').on('click', function() {
                $(this).parent().children('.modal').modal('toggle')
            })
            console.log(data[20][3])
            $tp1 = $(row).children('td')[0]
            $tp2 = $(row).children('td')[11]
            $tp4 = $(row).children('td')[2]
            $tp5 = $(row).children('td')[15]
            $open = $(row).children('td')[12]
            $($open).addClass('qty_open_text')
            $($tp1).html(tp1)
            $($tp2).html(tp2)
            $($tp4).html(tp4)
            $($tp5).html(tp5)
            $input = $($tp2).children('input')
            $inputs = $($tp4).children('input')
            $inputss = $($tp5).children('input')
            $input.addClass(`qty_${data[20][0]}`)
            $input.val(data[20][1])
            $inputs.addClass(`docs_${data[20][0]}`)
            $inputs.val(data[20][2])
            $inputss.addClass(`groups_${data[20][0]}`)
            $inputss.val(data[20][3])
            $input.on('change blur keyup', function (e) {
                e.preventDefault()
                countQty($(this))
            })
            $check = $($tp1).children('.check_pr')
            $check.attr('id', `check_${data[20][0]}`)
            $check.val(data[20][0])
            $pr = $($tp1).children('.qty_pr')
            $pr.val(data[20][1])
            $($tp1).children('label').attr('for', `check_${data[20][0]}`)
        },
        searchDelay: 750,
        order: [[0, 'desc']],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });
</script>
@endsection