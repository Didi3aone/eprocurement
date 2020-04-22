@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Create PO</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.purchase-order.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("admin.purchase-order.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.type') }}</label>
                        <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                            @foreach($types as $id => $type)
                                <option value="{{ $type->code }}" {{ in_array($type->code, old('type', [])) ? 'selected' : '' }}>{{ $type->code }} - {{ $type->description }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('type') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.po_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', '') }}" readonly> 
                        @if($errors->has('po_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('po_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.vendor') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('vendor') ? 'is-invalid' : '' }}" name="vendor" value="{{ old('vendor', isset($quotation->vendor) ? $quotation->vendor->code . ' - ' . $quotation->vendor->name : '') }}" readonly> 
                        @if($errors->has('vendor'))
                            <div class="invalid-feedback">
                                {{ $errors->first('vendor') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.po_date') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('po_date') ? 'is-invalid' : '' }}" name="po_date" value="{{ old('po_date', '') }}" required> 
                        @if($errors->has('po_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('po_date') }}
                            </div>
                        @endif
                    </div>

                    <style>
                        .nav-tabs li {
                            margin: 0 2px;
                            border-top: 1px solid #ccc;
                            padding: 8px 16px;
                            border-top-left-radius: 8px;
                            border-top-right-radius: 8px;
                            border-left: 1px solid #ccc;
                            border-right: 1px solid #ccc;
                        }
                    </style>
                    <div class="form-group">
                        {{-- the big tab --}}
                        <div class="nav nav-tabs" id="nav-big-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-header-tab" data-toggle="tab" href="#nav-header" role="tab" aria-controls="nav-header" aria-selected="true">Header</a>
                            <a class="nav-item nav-link" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">Overview</a>
                            <a class="nav-item nav-link" id="nav-detail-tab" data-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="true">Detail</a>
                        </div>

                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="nav-header" role="tabpanel" aria-labelledby="nav-header-tab">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-delivery-tab" data-toggle="tab" href="#nav-delivery" role="tab" aria-controls="nav-delivery" aria-selected="true">Delivery / Invoice</a>
                                        <a class="nav-item nav-link" id="nav-condition-tab" data-toggle="tab" href="#nav-condition" role="tab" aria-controls="nav-condition" aria-selected="false">Condition</a>
                                        <a class="nav-item nav-link" id="nav-text-tab" data-toggle="tab" href="#nav-text" role="tab" aria-controls="nav-text" aria-selected="false">Text</a>
                                        <a class="nav-item nav-link" id="nav-address-tab" data-toggle="tab" href="#nav-address" role="tab" aria-controls="nav-address" aria-selected="false">Address</a>
                                        <a class="nav-item nav-link" id="nav-communication-tab" data-toggle="tab" href="#nav-communication" role="tab" aria-controls="nav-communication" aria-selected="false">Communication</a>
                                        <a class="nav-item nav-link" id="nav-purchasing-group-tab" data-toggle="tab" href="#nav-purchasing-group" role="tab" aria-controls="nav-purchasing-group" aria-selected="false">Org. Data</a>
                                        <a class="nav-item nav-link" id="nav-status-tab" data-toggle="tab" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="false">Status</a>
                                        <a class="nav-item nav-link" id="nav-release-strategy-tab" data-toggle="tab" href="#nav-release-strategy" role="tab" aria-controls="nav-release-strategy" aria-selected="false">Release Strategy</a>
                                    </div>
                                </nav>
                                
                                <style>
                                    .tab-content {
                                        padding: 20px;
                                        border-left: 1px solid #ddd;
                                        border-right: 1px solid #ddd;
                                        border-bottom: 1px solid #ddd;
                                        border-bottom-left-radius: 5px;
                                        border-bottom-right-radius: 5px;
                                    }
                                </style>
                                <div class="tab-content">
                                    {{-- header tab --}}
                                    <div class="tab-pane fade show active" id="nav-delivery" role="tabpanel" aria-labelledby="nav-delivery-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td>Payment Terms</td>
                                                            <td>
                                                                <select name="terms" class="form-control">
                                                                    <option value="Z030">Z030</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment in</td>
                                                            <td>
                                                                <input type="number" name="first_in" class="form-control"> days
                                                            </td>
                                                            <td>
                                                                <input type="number" name="first_in_percentage" class="form-control"> %
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment in</td>
                                                            <td>
                                                                <input type="number" name="second_in" class="form-control"> days
                                                            </td>
                                                            <td>
                                                                <input type="number" name="second_in_percentage" class="form-control"> %
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment in</td>
                                                            <td>
                                                                <input type="number" name="third_in" class="form-control"> days
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td>Currency</td>
                                                            <td>
                                                                <input type="number" name="currency" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Exchange Rate</td>
                                                            <td>
                                                                <input type="number" name="exchange_rate" class="form-control">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-condition" role="tabpanel" aria-labelledby="nav-condition-tab">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Item Code</th>
                                                    <th>Material Type</th>
                                                    <th>Name</th>
                                                    <th style="width: 10%">Amount</th>
                                                    <th style="width: 10%">Currency</th>
                                                    <th style="width: 10%">Per</th>
                                                    <th style="width: 10%">Unit</th>
                                                    <th style="width: 10%">Condition Value</th>
                                                    <th>Notes</th>
                                                    <th>
                                                        <button type="button" id="add_condition_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="condition_items"></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-text" role="tabpanel" aria-labelledby="nav-text-tab">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Header Text</td>
                                                    <td>
                                                        <textarea name="header_text" id="header_text" cols="30" rows="10" class="form-control"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Street / House Number</td>
                                                    <td>
                                                        <input type="text" name="street" id="street" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Postal Code / City</td>
                                                    <td>
                                                        <input type="text" name="postal_code" id="postal_code" class="form-control" style="width: 30%">
                                                        <input type="text" name="city" id="city" class="form-control" style="width: 70%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Country</td>
                                                    <td>
                                                        <input type="text" name="country" id="country" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>
                                                        <input type="text" name="phone" id="phone" class="form-control" style="width: 50%">
                                                        <input type="text" name="extension_phone" id="extension_phone" class="form-control" style="width: 50%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Fax</td>
                                                    <td>
                                                        <input type="text" name="fax" id="fax" class="form-control" style="width: 50%">
                                                        <input type="text" name="extension_fax" id="extension_fax" class="form-control" style="width: 50%">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-communication" role="tabpanel" aria-labelledby="nav-communication-tab">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Sales Person</td>
                                                    <td>
                                                        <input type="text" name="sales_person" id="sales_person" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>
                                                        <input type="text" name="sales_phone" id="sales_phone" class="form-control" style="width: 30%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Language</td>
                                                    <td>
                                                        <input type="text" name="sales_language" id="sales_language" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Your Reference</td>
                                                    <td>
                                                        <input type="text" name="sales_your_reference" id="sales_your_reference" class="form-control" style="width: 50%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Our Reference</td>
                                                    <td>
                                                        <input type="text" name="sales_our_reference" id="sales_our_reference" class="form-control" style="width: 50%">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-purchasing-group" role="tabpanel" aria-labelledby="nav-purchasing-group-tab">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Purch. Org.</td>
                                                    <td>
                                                        <input type="text" name="pg_org" id="pg_org" class="form-control" style="width: 50%" value="0000">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Code</td>
                                                    <td>
                                                        <input type="text" name="pg_code" id="pg_code" class="form-control" style="width: 50%" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Company Code</td>
                                                    <td>
                                                        <input type="text" name="pg_company_code" id="pg_company_code" class="form-control" style="width: 50%" required>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-status" role="tabpanel" aria-labelledby="nav-status-tab">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td><i class="fa fa-info"></i> Release Completed</td>
                                                    <td>Ordered</td>
                                                    <td>
                                                        <input type="number" name="status_ordered" id="status_ordered" class="form-control"> IDR
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-flag"></i> Released, Changeable</td>
                                                    <td>Delivered</td>
                                                    <td>
                                                        <input type="number" name="status_delivered" id="status_delivered" class="form-control" style="width: 30%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-print"></i> Not Yet Sent</td>
                                                    <td>Still to Deliv.</td>
                                                    <td>
                                                        <input type="number" name="status_still" id="status_still" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-truck"></i> Fully Delivered</td>
                                                    <td>Invoiced</td>
                                                    <td>
                                                        <input type="number" name="status_invoiced" id="status_invoiced" class="form-control" style="width: 50%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-sum"></i> Not Invoiced</td>
                                                    <td>Down Payment</td>
                                                    <td>
                                                        <input type="number" name="status_dp" id="status_dp" class="form-control" style="width: 50%">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-release-strategy" role="tabpanel" aria-labelledby="nav-release-strategy-tab">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Release Group</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="rs_group"> Release Group for PO
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Release Strategy</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="rs_strategy"> Release PO 0 - 500jt
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Release Indicator</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="rs_indicator"> Released, Changeable
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Description</th>
                                                    <th>Processor</th>
                                                    <th>Status</th>
                                                    <th>
                                                        <button type="button" id="add_release_strategy_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="release_strategy_items">
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" name="rs_code[]" value="01">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="rs_description[]" value="PURCHASING HEAD">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="rs_processor[]" value="PURCHASING MANAGER">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-control" name="rs_status[]" checked>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-material-group" role="tabpanel" aria-labelledby="nav-material-group-tab">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Description</th>
                                                    <th>
                                                        <button type="button" id="add_material_group_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="material_group_items"></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-requestor" role="tabpanel" aria-labelledby="nav-requestor-tab">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th>Short Text</th>
                                                    <th>
                                                        <button type="button" id="add_asset_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="asset_items"></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-text" role="tabpanel" aria-labelledby="nav-text-tab">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Text ID</th>
                                                    <th>Text Form</th>
                                                    <th>Text Line</th>
                                                    <th>
                                                        <button type="button" id="add_text_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="text_items"></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-other" role="tabpanel" aria-labelledby="nav-other-tab">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Purchasing Group</th>
                                                    <th>Tracking No</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Delivery Date Category</th>
                                                    <th>Delivery Date</th>
                                                    <th>Release Date</th>
                                                    <th>Account Assignment Category</th>
                                                    <th>GR IND</th>
                                                    <th>IR IND</th>
                                                    <th>
                                                        <button type="button" id="add_other_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="other_items"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- tab overview --}}
                            <div class="tab-pane fade" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                                overview
                            </div>

                            {{-- tab detail --}}
                            <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                detail
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <button type="button" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    })

    $('#v-pills-tabContent a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    $(document).ready(function () {
        let index = 1
       
        $('#add_material_item').on('click', function (e) {
            e.preventDefault()

            const material_html = `
<tr>
    <td>
        <select name="material_id[]" id="material_${index}" class="material_id form-control"></select>
    </td>
    <td>
        <input class="form-control" type="text" name="material_description[]">
    </td>
    <td>
        <input class="form-control" type="number" name="material_qty[]">
    </td>
    <td>
        <input class="form-control" type="number" name="material_unit[]">
    </td>
    <td>
        <input class="form-control" type="text" name="material_notes[]">
    </td>
    <td>
        <a href="javascript:;" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)" class="remove-item btn btn-danger btn-sm">
            <i class="fa fa-times"></i> hapus
        </a>
    </td>
</tr>
            `

            $('#material_items').append(material_html)

            listMaterial($('#category_id').val(), index)
            index++
        })
       
        $('#add_asset_item').on('click', function (e) {
            e.preventDefault()

            const asset_html = `
<tr>
    <td>
        <select name="asset_code[]" data-id="${index}" id="asset_${index}" class="asset_code form-control"></select>
    </td>
    <td>
        <input id="asset_description_${index}" class="asset_description form-control" type="text" name="asset_description[]" readonly>
    </td>
    <td>
        <a href="javascript:;" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)" class="remove-item btn btn-danger btn-sm">
            <i class="fa fa-times"></i> hapus
        </a>
    </td>
</tr>
            `

            $('#asset_items').append(asset_html)

            listAsset($('#category_id').val(), index)
            index++
        })

        const material_url = '{{ route('admin.material.select') }}'
        const asset_url = '{{ route('admin.asset.select') }}'

        function listMaterial (code, i) {
            $.getJSON(material_url, { code: code }, function (items) {
                var newOptions = '<option value="">-- Select --</option>';

                for (var id in items) {
                    newOptions += '<option value="'+ id +'">'+ items[id] +'</option>';
                }

                if (i > 0) {
                    $('#material_' + i).html(newOptions)
                }
            })
        }

        function listAsset (code, i) {
            $.getJSON(asset_url, { code: code }, function (items) {
                var newOptions = '<option value="">-- Select --</option>';

                for (var id in items) {
                    newOptions += '<option value="'+ id +'">'+ items[id] +'</option>';
                }

                if (i > 0) {
                    $('#asset_' + i).html(newOptions)
                }
            })
        }

        $(document).on('change', '.asset_code', function (e) {
            const id = $(this).data('id')
            $(this).closest('tr').find('#asset_description_' + id).val($(this).val())
        })

        $('#category_id').on('change', function (e) {
            e.preventDefault()

            const code = $(this).val()

            listMaterial(code, 0)
            listAsset(code, 0)
        })
    })
</script>
@endsection