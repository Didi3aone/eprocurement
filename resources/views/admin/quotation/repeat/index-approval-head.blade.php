@extends('layouts.admin')
@section('content')
<style>

</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Po Approval</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Direct</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>PO Eprocurement</th>
                                        <th>Created at</th>
                                        {{-- <th>#</th> --}}
                                        <th>Po Item</th>
                                        <th>Free Item</th>
                                        <th>Material</th>
                                        <th>Short Text</th>
                                        <th>Qty</th>
                                        <th>Material Group</th>
                                        <th>Storage Location</th>
                                        <th>Purchasing Group</th>
                                        <th>Plant</th>
                                        <th>PR No</th>
                                        <th>PR Item</th>
                                        <th>Requisioner</th>
                                        <th>Delivery Date</th>
                                        <th>Rfq/Acp No</th>
                                        <th>Tax Code</th>
                                        <th>Currency</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach($quotation as $key => $val)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="id[]" id="check_{{ $key ?? '' }}" class="check_po" value="{{ $key ?? '' }}" _valold="{{ $key ?? '' }}">
                                                <label for="check_{{ $key ?? '' }}">&nbsp;</label>
                                            </td>
                                            <td>{{ $key }}</td>
                                            {{-- <td>{{ $key }}</td> --}}
                                            @php
                                                $sumTotal = 0;
                                            @endphp
                                            @foreach($val as $key => $value)
                                                @php
                                                    $qtyAcp   = \App\Models\AcpTableMaterial::getQtyAcp($value->material, $value->acp_id);
                                                    if( null != $qtyAcp ) {
                                                        $perQty     = ($value->qty/$qtyAcp->qty);
                                                        $totalPrice = (\removeComma($value->price) * $perQty);
                                                    } else {
                                                        $totalPrice = ($value->price * $value->qty);
                                                    }
                                                    $sumTotal += $totalPrice;

                                                    $free = ' - ' ;
                                                    if ($value->is_free_item) {
                                                        $free = 'Free Of Charge' ;
                                                    }
                                                @endphp
                                                @if($key > 0)
                                                    @php
                                                        $cols = 3;
                                                    @endphp
                                                @else 
                                                    @php
                                                        $cols = "";
                                                    @endphp
                                                @endif 
                                                <td colspan="{{ $cols }}" style="text-align:right;">
                                                    {{ \Carbon\Carbon::parse($value->created_at)->format('d-m-Y') }}
                                                </td>
                                                {{-- <td>{{ $value->status }}</td> --}}
                                                <td>{{ $value->PO_ITEM }}</td>
                                                <td>{{ $free }}</td>
                                                <td>{{ $value->material ?? '-' }}</td>
                                                <td>{{ $value->short_text ?? '' }}</td>
                                                <td>{{ $value->qty ?? '' }}</td>
                                                <td>{{ $value->material_group ?? '' }}</td>
                                                <td>{{ $value->storage_location ?? '' }}</td>
                                                <td>{{ $value->purchasing_group_code ?? '' }}</td>
                                                <td>{{ $value->plant_code ?? '' }}</td>
                                                <td>{{ $value->PR_NO ?? '' }}</td>
                                                <td>{{ $value->PREQ_ITEM ?? '' }}</td>
                                                <td>{{ $value->preq_name ?? '' }}</td>
                                                <td>{{ $value->delivery_date ?? '' }}</td>
                                                <td>{{ $value->purchasing_document ?? '' }}</td>
                                                <td>{{ $value->tax_code ?? '' }}</td>
                                                <td>{{ $value->currency ?? '' }}</td>
                                                <td>{{ \toDecimal($value->price) ?? '' }}</td>
                                                <td>{{ \toDecimal($totalPrice) }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-xs" href="{{ route('admin.quotation-repeat-show-approval-head', $value->id) }}">
                                                        <i class="fa fa-eye"></i> {{ trans('global.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan=19></td>
                                            <td style="font-size:18px;"><b>{{ \toDecimal($sumTotal) }}</b></td>
                                            <td></td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {{ $quotation->links() }} --}}
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
            $('.approval_po_repeat').attr('href', '{{ url("admin/quotation/repeat/approve/head/") }}/' + ids)
        } else {
            alert('Please check your PO!')
            $('#modal_approval_po').modal('hide')
            
            return false
        }
    })
</script>
@endsection