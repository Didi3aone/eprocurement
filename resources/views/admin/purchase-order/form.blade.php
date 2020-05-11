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
                        <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', $quotation->po_no) }}" readonly> 
                        @if($errors->has('po_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('po_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.vendor_id') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id" value="{{ old('vendor_id', isset($quotation->vendor) ? $quotation->vendor->name . ' - ' . $quotation->vendor->email : '') }}" readonly> 
                        @if($errors->has('vendor_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('vendor_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.po_date') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('po_date') ? 'is-invalid' : '' }}" name="po_date" value="{{ old('po_date', date('Y-m-d')) }}" required> 
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
                        <div class="nav nav-tabs tabs-left" id="nav-big-tab" role="tablist">
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
                                                            <td colspan="2">
                                                                <select name="terms" class="form-control">
                                                                    <option value="Z030">Z030</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment in</td>
                                                            <td>
                                                                <input type="number" name="first_in" value="0" class="form-control"> days
                                                            </td>
                                                            <td>
                                                                <input type="text" name="first_in_percentage" value="0.000" class="form-control"> %
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment in</td>
                                                            <td>
                                                                <input type="number" name="second_in" value="0" class="form-control"> days
                                                            </td>
                                                            <td>
                                                                <input type="text" name="second_in_percentage" value="0.000" class="form-control"> %
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment in</td>
                                                            <td>
                                                                <input type="number" name="third_in" value="0" class="form-control"> days
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
                                                                <input type="text" name="currency" class="form-control" value="IDR">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Exchange Rate</td>
                                                            <td>
                                                                <input type="number" name="exchange_rate" value="0.000" class="form-control">
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
                                        <div class="nav nav-tab" role="tablist">
                                            <a href="#header_text" class="nav-item nav-link" role="tab" data-toggle="tab">Header Text</a>
                                            <a href="#header_note" class="nav-item nav-link" role="tab" data-toggle="tab">Header Note</a>
                                            <a href="#invoice_date" class="nav-item nav-link" role="tab" data-toggle="tab">Tanggal Faktur Pajak</a>
                                            <a href="#invoice_number" class="nav-item nav-link" role="tab" data-toggle="tab">Nomor Faktur Pajak</a>
                                        </div>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="header_text">
                                                <textarea name="header_text" id="header_text" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="header_note">
                                                <textarea name="header_note" id="header_note" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="invoice_date">
                                                <textarea name="invoice_date" id="invoice_date" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="invoice_number">
                                                <textarea name="invoice_number" id="invoice_number" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>
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
                                </div>
                            </div>

                            {{-- tab overview --}}
                            <div class="tab-pane fade" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                                <div class="tab-pane fade show active" id="nav-delivery" role="tabpanel" aria-labelledby="nav-delivery-tab">
                                    <div class="row">
                                        <div class="col-lg-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No item</th>
                                                        <th>Account assignment</th>
                                                        <th>Item Indicator</th>
                                                        <th>Material</th>
                                                        <th>Short text</th>
                                                        <th>PO QTY</th>
                                                        <th>Unit</th>
                                                        <th>Delivery date</th>
                                                        <th>Net Price</th>
                                                        <th>Currency</th>
                                                        <th>Per</th>
                                                        <th>Unit per</th>
                                                        <th>Material group</th>
                                                        <th>Plant</th>
                                                        <th>Sloc</th>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                        <th>Processor</th>
                                                        <th>Status</th>
                                                        <th>
                                                            <button type="button" id="add_get_overview_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="get_overview_items">
                                                    @foreach ($pr as $row)
                                                    <tr>
                                                        <td><input type="text" name="o_item_no[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_account_assignment[]" value="{{ $row->account_assignment }}" class="form-control"></td>
                                                        <td><input type="text" name="o_item_indicator[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_material_id[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_notes[]" value="{{ $row->notes }}" class="form-control"></td>
                                                        <td><input type="text" name="o_qty[]" value="{{ $row->qty }}" class="form-control"></td>
                                                        <td><input type="text" name="o_unit[]" value="{{ $row->unit }}" class="form-control"></td>
                                                        <td><input type="text" name="o_delivery_date[]" value="{{ $row->delivery_date }}" class="form-control"></td>
                                                        <td><input type="text" name="o_net_price[]" value="{{ $row->price }}" class="form-control"></td>
                                                        <td><input type="text" name="o_currency[]" value="IDR" class="form-control"></td>
                                                        <td><input type="text" name="o_per[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_unit_per[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_mg_code[]" value="{{ $row->mg_code }}" class="form-control"></td>
                                                        <td><input type="text" name="o_p_code[]" value="{{ $row->p_code }}" class="form-control"></td>
                                                        <td><input type="text" name="o_storage_location[]" value="{{ $row->storage_location }}" class="form-control"></td>
                                                        <td><input type="text" name="o_code[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_description[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_processor[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                        <td><input type="text" name="o_status[]" value="{{ $row->material_id }}" class="form-control"></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- tab detail --}}
                            <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                <div class="nav nav-tabs" role="tablist">
                                    <a href="#material_data" class="nav-item nav-link" role="tab" aria-controls="nav-material_data" aria-selected="false">Material Data</a>
                                    <a href="#delivery_schedule" class="nav-item nav-link" role="tab" aria-controls="nav-delivery_schedule" aria-selected="false">Delivery Schedule</a>
                                    <a href="#delivery" class="nav-item nav-link" role="tab" aria-controls="nav-delivery" aria-selected="false">Delivery</a>
                                    <a href="#invoice" class="nav-item nav-link" role="tab" aria-controls="nav-invoice" aria-selected="false">Invoice</a>
                                    <a href="#d-condition" class="nav-item nav-link" role="tab" aria-controls="nav-d-condition" aria-selected="false">Condition</a>
                                    <a href="#account-assignment" class="nav-item nav-link" role="tab" aria-controls="nav-account-assignment" aria-selected="false">Account Assignment</a>
                                    <a href="#po-history" class="nav-item nav-link" role="tab" aria-controls="nav-po-history" aria-selected="false">PO History</a>
                                    <a href="#d-text" class="nav-item nav-link" role="tab" aria-controls="nav-d-condition" aria-selected="false">Text</a>
                                </div>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="material_data">
                                        <table class="table">
                                            <tr>
                                                <td>Material Group</td>
                                                <td><input type="text" class="form-control" name="d_material_group" value="{{ '' }}"></td>
                                                <td>Revision Level</td>
                                                <td><input type="text" class="form-control" name="d_revision_level"></td>
                                            </tr>
                                            <tr>
                                                <td>Supplier Mat. No.</td>
                                                <td><input type="text" class="form-control" name="d_supplier_mat_no"></td>
                                            </tr>
                                            <tr>
                                                <td>Supplier subrange</td>
                                                <td><input type="text" class="form-control" name="d_supplier_subrange"></td>
                                            </tr>
                                            <tr>
                                                <td>Batch</td>
                                                <td><input type="text" class="form-control" name="d_batch"></td>
                                                <td>Supplier Batch</td>
                                                <td><input type="text" class="form-control" name="d_supplier_batch"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="delivery_schedule">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S</th>
                                                        <th>C</th>
                                                        <th>Delivery Date</th>
                                                        <th>Sched. Qty</th>
                                                        <th>Time</th>
                                                        <th>Stat.Del.Dte.</th>
                                                        <th>GR Qty</th>
                                                        <th>PR</th>
                                                        <th>N</th>
                                                        <th>Open Quantity</th>
                                                        <th>Sch</th>
                                                        <th>P</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="delivery">
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="invoice">
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="d-condition">
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="account-assignment">
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="po-history">
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in active" id="d-text">
                                    </div>
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

        $('#add_condition_item').on('click', function (e) {
            e.preventDefault()

            const condition_html = `
<tr>
    <td><input class="form-control" type="text" name="condition_item_code[]"></td>
    <td><input class="form-control" type="text" name="condition_material_type[]"></td>
    <td><input class="form-control" type="text" name="condition_name[]"></td>
    <td><input class="form-control" type="text" name="condition_amount[]"></td>
    <td><input class="form-control" type="text" name="condition_currency[]" value="IDR"></td>
    <td><input class="form-control" type="text" name="condition_per[]"></td>
    <td><input class="form-control" type="text" name="condition_unit[]"></td>
    <td><input class="form-control" type="text" name="condition_value[]"></td>
    <td><input class="form-control" type="text" name="condition_notes[]"></td>
    <td>
        <a href="javascript:;" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)" class="remove-item btn btn-danger btn-sm">
            <i class="fa fa-times"></i> hapus
        </a>
    </td>
</tr>
            `

            $('#condition_items').append(condition_html)
        })
       
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

        $('add_condition_item').on('click', function (e) {
            e.preventDefault()

            const condition_html = `
<tr>
    <td>
        <select name="condition_item_code[]" id="condition_${index}" class="condition_item_code form-control"></select>
    </td>
    <td>
        <input class="form-control" type="text" id="condition_material_type_${index}" name="condition_material_type[]">
    </td>
    <td>Name
        <input class="form-control" type="text" id="condition_material_type_description_${index}" name="condition_material_type_description[]">
    </td>
    <th style="width: 10%">Amount</td>
    <th style="width: 10%">Currency</td>
    <th style="width: 10%">Per</td>
    <th style="width: 10%">Unit</td>
    <th style="width: 10%">Condition Value</td>
    <td>Notes</td>
    <td>
        <button type="button" id="add_condition_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
    </td>
</tr>
            `
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