@extends('layouts.vendor')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.quotation.title') }}</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('vendor.quotation-save-bid') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $quotation->id }}">
                    <input type="hidden" name="detail_id" value="{{ $quotation->detail_id }}">
                    <input type="hidden" name="model" value="{{ $quotation->model }}">

                    <div id="prices-box"></div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td>{{ trans('cruds.quotation.fields.po_no') }}</td>
                                        <td>{{ $quotation->po_no }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.quotation.fields.model') }}</td>
                                        <td>{{ $quotation->model == 1 ? 'Open' : 'Close' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.quotation.fields.leadtime_type') }}</td>
                                        <td>{{ $quotation->leadtime_type == 0 ? 'Date' : 'Day Count' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</td>
                                        <td>{{ $quotation->purchasing_leadtime }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.quotation.fields.start_date') }}</td>
                                        <td>{{ $quotation->start_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.quotation.fields.expired_date') }}</td>
                                        <td>{{ $quotation->expired_date }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Material ID</th>
                                            <th>Material Desc</th>
                                            <th>Unit</th>
                                            <th style="width: 10%">Qty</th>
                                            <th style="width: 20%">Net Price</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    {{-- get from rfq,  net_order_price untuk pricenya --}}
                                    <tbody>
                                        @foreach($data as $key => $value) 
                                            <input type="hidden" name="id[]" value="{{ $value->id }}">
                                            <tr>
                                                <input type="hidden" name="plant_code[]" id="plant_code" value="{{ $value->plant_code }}">
                                                <input type="hidden" class="form-control" name="pr_no[]" readonly value="{{ $value->pr_no }}">
                                                <input type="hidden" class="form-control" name="request_date[]" readonly value="{{ $value->request_date }}">
                                                <input type="hidden" class="form-control" name="rn_no[]" readonly value="{{ $value->request_no }}">
                                                <input type="hidden" class="form-control" name="is_assets[]" readonly value="{{ $value->is_assets }}">
                                                <input type="hidden" class="form-control" name="assets_no[]" readonly value="{{ $value->assets_no }}">
                                                <input type="hidden" class="form-control" name="text_id[]" readonly value="{{ $value->text_id }}">
                                                <input type="hidden" class="form-control" name="text_form[]" readonly value="{{ $value->text_form }}">
                                                <input type="hidden" class="form-control" name="text_line[]" readonly value="{{ $value->text_line }}">
                                                <input type="hidden" class="form-control" name="delivery_date_category[]" readonly value="{{ $value->delivery_date_category }}">
                                                <input type="hidden" class="form-control" name="account_assignment[]" readonly value="{{ $value->account_assignment }}">
                                                <input type="hidden" class="form-control" name="purchasing_group_code[]" readonly value="{{ $value->purchasing_group_code }}">
                                                <input type="hidden" class="form-control" name="preq_name[]" readonly value="{{ $value->preq_name }}">
                                                <input type="hidden" class="form-control" name="gl_acct_code[]" readonly value="{{ $value->gl_acct_code }}">
                                                <input type="hidden" class="form-control" name="cost_center_code[]" readonly value="{{ $value->cost_center_code }}">
                                                <input type="hidden" class="form-control" name="profit_center_code[]" readonly value="{{ $value->profit_center_code }}">
                                                <input type="hidden" class="form-control" name="storage_location[]" readonly value="{{ $value->storage_location }}">
                                                <input type="hidden" class="form-control" name="material_group[]" readonly value="{{ $value->material_group }}">
                                                <input type="hidden" class="form-control" name="preq_item[]" readonly value="{{ $value->preq_item }}">
                                                <td><input type="text" class="form-control material_id" name="material_id[]"  id="material_id" readonly value="{{ $value->material }}"></td>
                                                <td><input type="text" class="form-control" name="description[]" readonly value="{{ $value->description }}"></td>
                                                <td><input type="text" class="form-control" name="unit[]" readonly value="{{ $value->unit }}"></td>
                                                <td><input type="text" class="form-control" name="qty[]" readonly value="{{ empty($value->qty) ? 0 : $value->qty }}"></td>
                                                <td><input type="text" class="form-control net_price" name="net_price[]" id="net_price" value="{{ $value->price }}" {{ $quotation->model == 0 ? 'readonly' : '' }}></td>
                                                <td>
                                                    <a 
                                                        href="javascript:;" 
                                                        class="open_modal btn btn-success" 
                                                        data-material="{{ $value->material }}" 
                                                        data-notes="{{ $value->notes }}" 
                                                        data-target="#wholesale_modal" 
                                                        data-toggle="modal"
                                                    ><i class="fa fa-truck"></i> Set Price</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        @if ($quotation->status != 0)
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i> Bid
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="wholesale_modal" tabindex="-1" role="dialog" aria-labelledby="wholesale_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Wholesale Prices for <span id="material_code"></span> <span id="material_notes"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="material_code" class="material_code" value="">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Varian</th>
                                    <th>Min</th>
                                    <th>Max</th>
                                    <th>Price</th>
                                    <th>
                                        <button id="add_varian" class="btn btn-primary"><i class="fa fa-plus"></i> Add Varian</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="wholesales">
                                <tr>
                                    <td><input type="text" data-name="name" class="name" name="name[]" value="Price" style="width: 100%"></td>
                                    <td><input type="number" data-name="min" class="min" name="min[]" value="" style="width: 100%" required></td>
                                    <td><input type="number" data-name="max" class="max" name="max[]" value="" style="width: 100%" required></td>
                                    <td><input type="number" data-name="price" class="price" name="price[]" value="" style="width: 100%" required></td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" id="save-prices" data-material="" class="btn btn-success">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#add_varian').on('click', function (e) {
        e.preventDefault()

        const html = `
            <tr>
                <td><input type="text" class="name" data-name="name" name="name[]" value="Price" style="width: 100%"></td>
                <td><input type="number" class="min" data-name="min" name="min[]" value="" style="width: 100%" required></td>
                <td><input type="number" class="max" data-name="max" name="max[]" value="" style="width: 100%" required></td>
                <td><input type="number" class="price" data-name="price" name="price[]" value="" style="width: 100%" required></td>
                <td>
                    <button type="button" class="remove btn btn-danger btn-xs" onclick="this.parentNode.parentNode.remove();">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                </td>
            </tr>
        `

        $('#wholesales').append(html)
    })

    $('.open_modal').click(function (e) {
        e.preventDefault()

        const material_code = $(this).data('material')

        $(document).find('#material_code').html(material_code)
        $('.material_code').val(material_code)
    })

    function checkIfNull ($material, $input) {
        if ($input.val() == '' || $input.val() == 0) {
            alert($input.data('name') + ' cannot be zero!')
            $input.focus()

            return false
        } else {
            return `<input type="hidden" name="${$input.data('name')}[]" value="${$material}-${$input.val()}">`
        }
    }

    $(document).on('click', '#save-prices', function (e) {
        e.preventDefault()

        let prices = ''
        $.each($('.min'), function () {
            const $tr = $(this).closest('tr')
            const $modal_header = $(document).find('.modal-header')
            const $material = $modal_header.find('.material_code').val()
            const $name = $tr.find('.name')
            const $min = $tr.find('.min')
            const $max = $tr.find('.max')
            const $price = $tr.find('.price')

            prices += checkIfNull($material, $name)
            prices += checkIfNull($material, $min)
            prices += checkIfNull($material, $max)
            prices += checkIfNull($material, $price)
        })

        const $prices_box = $(document).find('#prices-box')
        $prices_box.empty()
        $prices_box.append(prices)

        $('.modal').modal('hide')
    })

    $('.money').mask('#.##0', { reverse: true });
</script>
@endsection