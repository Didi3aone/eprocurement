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
                        <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
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
                        <input type="text" class="form-control form-control-line {{ $errors->has('po_no') ? 'is-invalid' : '' }}" name="po_no" value="{{ old('po_no', $po->po_no) }}" readonly> 
                        @if($errors->has('po_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('po_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.vendor_id') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id" value="{{ old('vendor_id', isset($po->vendor) ? $po->vendor->name : '') }}" readonly> 
                        @if($errors->has('vendor_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('vendor_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.purchase-order.fields.po_date') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('po_date') ? 'is-invalid' : '' }}" name="po_date" value="{{ old('po_date', date('Y-m-d')) }}"> 
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
                        <select name="" id="choose-tab" class="form-control">
                            <option value="0">Header</option>
                            <option value="1">Overview</option>
                            <option value="2">Detail</option>
                        </select>
                    </div>
                    <div class="form-group">
                        {{-- tab header --}}
                        <div class="tab-header">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-delivery-tab" data-toggle="tab" href="#nav-delivery" role="tab" aria-controls="nav-delivery" aria-selected="true">Delivery / Invoice</a>
                                    <a class="nav-item nav-link" id="nav-condition-tab" data-toggle="tab" href="#nav-condition" role="tab" aria-controls="nav-condition" aria-selected="false">Condition</a>
                                    <a class="nav-item nav-link" id="nav-text-tab" data-toggle="tab" href="#nav-text" role="tab" aria-controls="nav-text" aria-selected="false">Text</a>
                                    <a class="nav-item nav-link" id="nav-address-tab" data-toggle="tab" href="#nav-address" role="tab" aria-controls="nav-address" aria-selected="false">Address</a>
                                    <a class="nav-item nav-link" id="nav-communication-tab" data-toggle="tab" href="#nav-communication" role="tab" aria-controls="nav-communication" aria-selected="false">Communication</a>
                                    <a class="nav-item nav-link" id="nav-purchasing-group-tab" data-toggle="tab" href="#nav-purchasing-group" role="tab" aria-controls="nav-purchasing-group" aria-selected="false">Org. Data</a>
                                    <a class="nav-item nav-link" id="nav-status-tab" data-toggle="tab" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="false">Status</a>
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
                                .table-borderless th, .table-borderless td {
                                    border: none;
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
                                                            <select name="payment_terms" class="form-control">
                                                                <option value="Z030">Z030</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Payment in</td>
                                                        <td>
                                                            <input type="number" name="payment_in_days_1" value="{{ $poinvoice->payment_in_days_1 ?? 0 }}" class="form-control"> days
                                                        </td>
                                                        <td>
                                                            <input type="text" name="payment_in_percent_1" value="{{ $poinvoice->payment_in_percent_1 ?? 0.000 }}" class="form-control"> %
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Payment in</td>
                                                        <td>
                                                            <input type="number" name="payment_in_days_2" value="{{ $poinvoice->payment_in_days_2 ?? 0 }}" class="form-control"> days
                                                        </td>
                                                        <td>
                                                            <input type="text" name="payment_in_percent_2" value="{{ $poinvoice->payment_in_percent_2 ?? 0.000 }}" class="form-control"> %
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Payment in</td>
                                                        <td>
                                                            <input type="number" name="payment_in_days_3" value="{{ $poinvoice->payment_in_days_3 ?? 0 }}" class="form-control"> days
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
                                                            <input type="text" name="currency" class="form-control" value="{{ $poinvoice->currency ?? 'IDR' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Exchange Rate</td>
                                                        <td>
                                                            <input type="number" name="exchange_rate" value="{{ $poinvoice->exchange_rate ?? 0.000 }}" class="form-control">
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
                                                    <input type="text" name="sales_person" id="sales_person" class="form-control" value="{{ $poinvoice->sales_person ?? null }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>
                                                    <input type="text" name="phone" id="sales_phone" class="form-control" style="width: 30%" value="{{ $poinvoice->phone ?? null }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Language</td>
                                                <td>
                                                    <input type="text" name="language" id="sales_language" class="form-control" value="{{ $poinvoice->language ?? null }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Your Reference</td>
                                                <td>
                                                    <input type="text" name="your_reference" id="sales_your_reference" class="form-control" style="width: 50%" value="{{ $poinvoice->your_reference ?? null }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Our Reference</td>
                                                <td>
                                                    <input type="text" name="our_reference" id="sales_our_reference" class="form-control" style="width: 50%" value="{{ $poinvoice->our_reference ?? null }}">
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
                                                    <input type="text" name="pg_code" id="pg_code" class="form-control" style="width: 50%">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Company Code</td>
                                                <td>
                                                    <input type="text" name="pg_company_code" id="pg_company_code" class="form-control" style="width: 50%">
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
                            </div>
                        </div>

                        {{-- tab overview --}}
                        <div class="tab-overview row">
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

                        {{-- tab detail --}}
                        <div class="tab-detail row">
                            <div class="col-lg-12 table-responsive">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-material_data-tab" data-toggle="tab" href="#nav-material_data" role="tab" aria-controls="nav-material_data" aria-selected="true">Material Data</a>
                                        <a class="nav-item nav-link" id="nav-delivery_schedule-tab" data-toggle="tab" href="#nav-delivery_schedule" role="tab" aria-controls="nav-delivery_schedule" aria-selected="true">Delivery Schedule</a>
                                        <a class="nav-item nav-link" id="nav-d-delivery-tab" data-toggle="tab" href="#nav-d-delivery" role="tab" aria-controls="nav-d-delivery" aria-selected="true">Delivery</a>
                                        <a class="nav-item nav-link" id="nav-d-invoice-tab" data-toggle="tab" href="#nav-d-invoice" role="tab" aria-controls="nav-d-invoice" aria-selected="true">Invoice</a>
                                        <a class="nav-item nav-link" id="nav-d-condition-tab" data-toggle="tab" href="#nav-d-condition" role="tab" aria-controls="nav-d-condition" aria-selected="true">Condition</a>
                                        <a class="nav-item nav-link" id="nav-account_assignment-tab" data-toggle="tab" href="#nav-account_assignment" role="tab" aria-controls="nav-account_assignment" aria-selected="true">Account Assignment</a>
                                        <a class="nav-item nav-link" id="nav-po-history-tab" data-toggle="tab" href="#nav-po-history" role="tab" aria-controls="nav-po-history" aria-selected="true">PO History</a>
                                        <a class="nav-item nav-link" id="nav-d-text-tab" data-toggle="tab" href="#nav-d-text" role="tab" aria-controls="nav-d-text" aria-selected="true">Text</a>
                                        <a class="nav-item nav-link" id="nav-d-delivery_address-tab" data-toggle="tab" href="#nav-d-delivery_address" role="tab" aria-controls="nav-d-delivery_address" aria-selected="true">Delivery Address</a>
                                    </div>
                                </nav>
                                
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="nav-material_data">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Material Group</td>
                                                <td><input type="text" class="form-control" name="d_material_group" value="{{ 0 }}"></td>
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
                                    <div role="tabpanel" class="tab-pane fade" id="nav-delivery_schedule">
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
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="nav-d-delivery">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Over deliv Tol</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="text" class="form-control" name="dd_overdeliv_tol" value="{{ 0 }}">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="checkbox" name="dd_unlimited"><label for="">Unlimited</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>1st Rem./Exped.</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="number" class="form-control" name="dd_1st_rem" value="0">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="checkbox" name="dd_good_receipt"><label for="">Good Receipt</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Under deliv Tol</td>
                                                    <td><input type="text" class="form-control" name="dd_under_deliv_tol" value="{{ 0 }}"></td>
                                                    <td>2nd Rem./Exped.</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="number" class="form-control" name="dd_2nd_rem" value="0">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="checkbox" name="dd_gr_non_valuated"><label for="">GR Non-valuated</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Instr.</td>
                                                    <td><select name="dd_shipping_instr" id="" class="form-control"></select></td>
                                                    <td>3rd Rem./Exped.</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="number" class="form-control" name="dd_3rd_rem" value="0">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="checkbox" name="dd_deliv_compl"><label for="">Deliv Compl.</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>No Exped.</td>
                                                    <td><input type="number" class="form-control" name="dd_no_exped"></td>
                                                </tr>
                                                <tr>
                                                    <td>Stock Type</td>
                                                    <td><select name="dd_stock_type" id="" class="form-control"></select></td>
                                                    <td>Pl. Deliv. Time</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="number" class="form-control" name="dd_pl_deliv_time" value="0">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="checkbox" name="dd_part_del_item"><label for="">Part.Del./Item</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>GR Proc. Time</td>
                                                    <td><input type="number" class="form-control" name="dd_proc_time"></td>
                                                    <td>Latest GR Date</td>
                                                    <td><input type="text" class="form-control" name="dd_latest_gr_data"></td>
                                                </tr>
                                                <tr>
                                                    <td>Item Shelf. Life</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="text" name="dd_item_shelf_life" id="" class="form-control">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control" name="dd_item_shelf_life_detail" value="D">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>QA Control Key</td>
                                                    <td><select name="dd_qa_control_key" id="" class="form-control"></select></td>
                                                    <td>Certificate Type</td>
                                                    <td><input type="text" class="form-control" name="dd_certificate_type"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="nav-d-invoice">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><input type="checkbox" name="dd_inv_receipt" checked><label for="">Inv. Receipt</label></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                Tax Code
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <input type="text" name="dd_inv_version" value="V1" class="form-control">
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <button class="btn btn-warning"><i class="fa fa-money"></i> Taxes</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="dd_final_invoice"><label for="">Final Invoice</label></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="dd_gr_bsd_iv" checked><label for="">GR-Bsd IV</label></td>
                                                </tr>
                                                <tr>
                                                    <td>DP Category</td>
                                                    <td><select name="dd_dp_category" id="" class="form-control"></select></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="nav-d-condition">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Quantity</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="text" name="dd_quantity" class="form-control">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" name="dd_quantity_label" class="form-control" value="PC">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Net</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="text" name="dd_net" class="form-control">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" name="dd_net_currency" class="form-control" value="IDR">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <h5>Pricing Elements</h5>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>I</th>
                                                        <th>CnTy</th>
                                                        <th>Name</th>
                                                        <th>Amount</th>
                                                        <th>Crcy</th>
                                                        <th>per</th>
                                                        <th>Unit</th>
                                                        <th>Condition Value</th>
                                                        <th>Curr</th>
                                                        <th>Status</th>
                                                        <th>NumCCO</th>
                                                        <th>ATO/MTS Component</th>
                                                        <th>OUn</th>
                                                        <th>CConDe</th>
                                                        <th>Un</th>
                                                        <th>Condition Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>ZPBO</td>
                                                        <td>EG Gross Price</td>
                                                        <td>22.240.000</td>
                                                        <td>IDR</td>
                                                        <td>1</td>
                                                        <td>PC</td>
                                                        <td>22.340.000</td>
                                                        <td>IDR</td>
                                                        <td></td>
                                                        <td>1</td>
                                                        <td></td>
                                                        <td>PC</td>
                                                        <td>1</td>
                                                        <td>PC</td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="nav-account_assignment">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Acc Ass Cat</td>
                                                    <td>
                                                        <select name="dd_acc_ass_cat" id="dd_acc_ass_cat" class="form-control">
                                                            <option value="A">A Asset</option>
                                                            <option value="K">Cost Center</option>
                                                        </select>
                                                    </td>
                                                    <td>Distribution</td>
                                                    <td>
                                                        <select name="dd_distribution" id="" class="form-control">
                                                            <option value="SAA">Single Account Assignment</option>
                                                        </select>
                                                    </td>
                                                    <td>CoCode</td>
                                                    <td>
                                                        <select name="dd_cocode" id="" class="form-control">
                                                            <option value="1200">1200 PT. Sari E</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td class="dd_asset">Partial Inv.</td>
                                                    <td class="dd_asset">
                                                        <select name="dd_partial_inv" id="" class="form-control">
                                                            <option value="derive">Derive from Account Assignment</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="dd_asset">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>I</th>
                                                            <th>CnTy</th>
                                                            <th>Name</th>
                                                            <th>Amount</th>
                                                            <th>Crcy</th>
                                                            <th>per</th>
                                                            <th>Unit</th>
                                                            <th>Condition Value</th>
                                                            <th>Curr</th>
                                                            <th>Status</th>
                                                            <th>NumCCO</th>
                                                            <th>ATO/MTS Component</th>
                                                            <th>OUn</th>
                                                            <th>CConDe</th>
                                                            <th>Un</th>
                                                            <th>Condition Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>ZPBO</td>
                                                            <td>EG Gross Price</td>
                                                            <td>22.240.000</td>
                                                            <td>IDR</td>
                                                            <td>1</td>
                                                            <td>PC</td>
                                                            <td>22.340.000</td>
                                                            <td>IDR</td>
                                                            <td></td>
                                                            <td>1</td>
                                                            <td></td>
                                                            <td>PC</td>
                                                            <td>1</td>
                                                            <td>PC</td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="dd_non_asset">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td>Unloading Point</td>
                                                        <td><input type="text" name="dd_unloading_point" class="form-control"></td>
                                                        <td>Recipient</td>
                                                        <td><input type="text" name="dd_recipient" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>G/L Account</td>
                                                        <td><input type="text" name="dd_gl_account" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>CO Area</td>
                                                        <td><input type="text" name="dd_co_area" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cost Center</td>
                                                        <td><input type="text" name="dd_cost_center" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>Profit Segment</td>
                                                        <td>
                                                            <button class="btn btn-warning"><i class="fa fa-chevron-right"></i></button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="nav-po-history">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Sh.</th>
                                                        <th>Text</th>
                                                        <th>MvT</th>
                                                        <th>Material Document</th>
                                                        <th>Item</th>
                                                        <th>Posting Date</th>
                                                        <th>Quantity</th>
                                                        <th>Delivery Cost Quantity</th>
                                                        <th>OUn</th>
                                                        <th>Amt.in Loc.Cur.</th>
                                                        <th>L.Cur</th>
                                                        <th>Qty in OPUn</th>
                                                        <th>DelCostQty (OPUn)</th>
                                                        <th>Order Price Unit</th>
                                                        <th>Amount</th>
                                                        <th>Crcy</th>
                                                        <th>Reference</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>WE</td>
                                                        <td>&nbsp;</td>
                                                        <td>101</td>
                                                        <td>5000035545</td>
                                                        <td>1</td>
                                                        <td>03.04.2020</td>
                                                        <td>6</td>
                                                        <td>0</td>
                                                        <td>PC</td>
                                                        <td>81.996</td>
                                                        <td>IDR</td>
                                                        <td>6</td>
                                                        <td>0</td>
                                                        <td>PC</td>
                                                        <td>81.996</td>
                                                        <td>IDR</td>
                                                        <td>SBT/SJ/0078</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="nav-d-text">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <table class="table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Texts</th>
                                                            <th>Any</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;" id="dd_item_text">Item Text</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;" id="dd_info_record_po_text">Info Record PO Text</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;" id="dd_material_po_text">Material PO Text</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;" id="dd_delivery_text">Delivery Text</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;" id="dd_info_record_note">Info Record Note</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;" id="dd_mrp_cockpit">MRP Cockpit</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;" id="dd_item_text_for_spec2000">Item Text for SPEC2000</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-8">
                                                <textarea name="dd_text_detail" id="dd-text-detail" cols="30" rows="8" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="nav-d-delivery_address">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Title</td>
                                                    <td>
                                                        <select name="dd_title_pt" id="" class="form-control">
                                                            <option value="PT">PT</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2"><button class="btn btn-warning">Address Detail</button></td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td><input type="text" name="dd_name" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td><input type="text" name="dd_name2" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>Street/House Number</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="text" name="dd_street_house_number" class="form-control">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" name="dd_street_house_number2" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Postal Code/City</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <input type="text" name="dd_postal_code" class="form-control">
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="text" name="dd_postal_code2" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Address</td>
                                                    <td><input type="text" name="dd_address" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>Country</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <input type="text" name="dd_country" id="dd_country" class="form-control">
                                                            </div>
                                                            <div class="col-lg-3">Indonesia</div>
                                                            <div class="col-lg-3">Region</div>
                                                            <div class="col-lg-2">
                                                                <input type="text" name="dd_region" class="form-control" value="02">
                                                            </div>
                                                            <div class="col-lg-2">Bodetabek</div>
                                                        </div>
                                                    </td>
                                                    <td>Customer</td>
                                                    <td><input type="text" name="dd_customer" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>Supplier</td>
                                                    <td><input type="text" name="dd_supplier" class="form-control"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top: 20px">
                        <input type="hidden" name="purchase_order_invoice_id" value="{{ $poinvoice->id ?? null }}">
                        <input type="hidden" name="purchase_order_id" value="{{ $po->id }}">
                        <input type="hidden" name="request_id" value="{{ $po->request_id }}">
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

    $('.tab-header').hide()
    $('.tab-overview').hide()
    $('.tab-detail').hide()

    $('#choose-tab').on('change', function (e) {
        e.preventDefault()

        switch ($(this).val()) {
            case '0':
                $('.tab-header').show()
                $('.tab-overview').hide()
                $('.tab-detail').hide()
                break;
            case '1':
                $('.tab-header').hide()
                $('.tab-overview').show()
                $('.tab-detail').hide()
                break;
            case '2':
                $('.tab-header').hide()
                $('.tab-overview').hide()
                $('.tab-detail').show()
                break;
        }
    }).trigger('change')

    $('.dd_asset').hide()
    $('.dd_non_asset').hide()

    $('#dd_acc_ass_cat').on('change', function (e) {
        e.preventDefault()

        if ($(this).val() == 'A') {
            $('.dd_asset').show()
            $('.dd_non_asset').hide()
        } else if ($(this).val() == 'K') {
            $('.dd_asset').hide()
            $('.dd_non_asset').show()
        }
    }).trigger('change')

    $('#dd_item_text').click(function (e) {
        e.preventDefault()

        $('#dd-text-detail').val('')
        $('#dd-text-detail').focus()
        $('#dd-text-detail').val(`Terdiri dari 
Rak Multiplek Lubang
1. 3,06cm x 0,4xH2.4 + 
2. 2,29cm x 0,4xH2.4
dan Consumable dan Prepare of Produksi`)
    })

    $('#dd_info_record_po_text').click(function (e) {
        e.preventDefault()

        $('#dd-text-detail').val('')
        $('#dd-text-detail').focus()
    })

    $('#dd_material_po_text').click(function (e) {
        e.preventDefault()

        $('#dd-text-detail').val('')
        $('#dd-text-detail').focus()
    })

    $('#dd_delivery_text').click(function (e) {
        e.preventDefault()

        $('#dd-text-detail').val('')
        $('#dd-text-detail').focus()
    })

    $('#dd_info_record_note').click(function (e) {
        e.preventDefault()

        $('#dd-text-detail').val('')
        $('#dd-text-detail').focus()
    })

    $('#dd_mrp_cockpit').click(function (e) {
        e.preventDefault()

        $('#dd-text-detail').val('')
        $('#dd-text-detail').focus()
    })

    $('#dd_item_text_for_spec2000').click(function (e) {
        e.preventDefault()

        $('#dd-text-detail').val('')
        $('#dd-text-detail').focus()
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