@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.rfq.title') }}</a></li>
            <li class="breadcrumb-item active">Create Detail</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.rfq-save-detail") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_document') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('purchasing_document') ? 'is-invalid' : '' }}" name="purchasing_document" value="{{ $code }}" readonly> 
                        @if($errors->has('purchasing_document'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_document') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.item') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('item') ? 'is-invalid' : '' }}" name="item" value=""> 
                        @if($errors->has('item'))
                            <div class="invalid-feedback">
                                {{ $errors->first('item') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.document_item') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('document_item') ? 'is-invalid' : '' }}" name="document_item" value=""> 
                        @if($errors->has('document_item'))
                            <div class="invalid-feedback">
                                {{ $errors->first('document_item') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.deletion_indicator') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('deletion_indicator') ? 'is-invalid' : '' }}" name="deletion_indicator" value=""> 
                        @if($errors->has('deletion_indicator'))
                            <div class="invalid-feedback">
                                {{ $errors->first('deletion_indicator') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.status') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" value=""> 
                        @if($errors->has('status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.short_text') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('short_text') ? 'is-invalid' : '' }}" name="short_text" value=""> 
                        @if($errors->has('short_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('short_text') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.material') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('material') ? 'is-invalid' : '' }}" name="material" value=""> 
                        @if($errors->has('material'))
                            <div class="invalid-feedback">
                                {{ $errors->first('material') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.company_code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('company_code') ? 'is-invalid' : '' }}" name="company_code" value=""> 
                        @if($errors->has('company_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.plant') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('plant') ? 'is-invalid' : '' }}" name="plant" value=""> 
                        @if($errors->has('plant'))
                            <div class="invalid-feedback">
                                {{ $errors->first('plant') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.storage_location') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('storage_location') ? 'is-invalid' : '' }}" name="storage_location" value=""> 
                        @if($errors->has('storage_location'))
                            <div class="invalid-feedback">
                                {{ $errors->first('storage_location') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.req_tracking_number') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('req_tracking_number') ? 'is-invalid' : '' }}" name="req_tracking_number" value=""> 
                        @if($errors->has('req_tracking_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('req_tracking_number') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.material_group') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('material_group') ? 'is-invalid' : '' }}" name="material_group" value=""> 
                        @if($errors->has('material_group'))
                            <div class="invalid-feedback">
                                {{ $errors->first('material_group') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_info_rec') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('purchasing_info_rec') ? 'is-invalid' : '' }}" name="purchasing_info_rec" value=""> 
                        @if($errors->has('purchasing_info_rec'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_info_rec') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.supplier_material_number') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('supplier_material_number') ? 'is-invalid' : '' }}" name="supplier_material_number" value=""> 
                        @if($errors->has('supplier_material_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('supplier_material_number') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.target_quantity') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('target_quantity') ? 'is-invalid' : '' }}" name="target_quantity" value=""> 
                        @if($errors->has('target_quantity'))
                            <div class="invalid-feedback">
                                {{ $errors->first('target_quantity') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.order_quantity') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('order_quantity') ? 'is-invalid' : '' }}" name="order_quantity" value=""> 
                        @if($errors->has('order_quantity'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_quantity') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.order_unit') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('order_unit') ? 'is-invalid' : '' }}" name="order_unit" value=""> 
                        @if($errors->has('order_unit'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_unit') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.order_price_unit') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('order_price_unit') ? 'is-invalid' : '' }}" name="order_price_unit" value=""> 
                        @if($errors->has('order_price_unit'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_price_unit') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.quantity_conversion') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('quantity_conversion') ? 'is-invalid' : '' }}" name="quantity_conversion" value=""> 
                        @if($errors->has('quantity_conversion'))
                            <div class="invalid-feedback">
                                {{ $errors->first('quantity_conversion') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.equal_to') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('equal_to') ? 'is-invalid' : '' }}" name="equal_to" value=""> 
                        @if($errors->has('equal_to'))
                            <div class="invalid-feedback">
                                {{ $errors->first('equal_to') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.denominal') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('denominal') ? 'is-invalid' : '' }}" name="denominal" value=""> 
                        @if($errors->has('denominal'))
                            <div class="invalid-feedback">
                                {{ $errors->first('denominal') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.net_order_price') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('net_order_price') ? 'is-invalid' : '' }}" name="net_order_price" value=""> 
                        @if($errors->has('net_order_price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('net_order_price') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.price_unit') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('price_unit') ? 'is-invalid' : '' }}" name="price_unit" value=""> 
                        @if($errors->has('price_unit'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price_unit') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.net_order_value') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('net_order_value') ? 'is-invalid' : '' }}" name="net_order_value" value=""> 
                        @if($errors->has('net_order_value'))
                            <div class="invalid-feedback">
                                {{ $errors->first('net_order_value') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.gross_order_value') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('gross_order_value') ? 'is-invalid' : '' }}" name="gross_order_value" value=""> 
                        @if($errors->has('gross_order_value'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gross_order_value') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.quotation_deadline') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('quotation_deadline') ? 'is-invalid' : '' }}" name="quotation_deadline" value=""> 
                        @if($errors->has('quotation_deadline'))
                            <div class="invalid-feedback">
                                {{ $errors->first('quotation_deadline') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.gr_processing_item') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('gr_processing_item') ? 'is-invalid' : '' }}" name="gr_processing_item" value=""> 
                        @if($errors->has('gr_processing_item'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gr_processing_item') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.tax_code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('tax_code') ? 'is-invalid' : '' }}" name="tax_code" value=""> 
                        @if($errors->has('tax_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tax_code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.base_unit_of_measures') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('base_unit_of_measures') ? 'is-invalid' : '' }}" name="base_unit_of_measures" value=""> 
                        @if($errors->has('base_unit_of_measures'))
                            <div class="invalid-feedback">
                                {{ $errors->first('base_unit_of_measures') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.shipping_intr') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('shipping_intr') ? 'is-invalid' : '' }}" name="shipping_intr" value=""> 
                        @if($errors->has('shipping_intr'))
                            <div class="invalid-feedback">
                                {{ $errors->first('shipping_intr') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.oa_target_value') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('oa_target_value') ? 'is-invalid' : '' }}" name="oa_target_value" value=""> 
                        @if($errors->has('oa_target_value'))
                            <div class="invalid-feedback">
                                {{ $errors->first('oa_target_value') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.non_deductible') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('non_deductible') ? 'is-invalid' : '' }}" name="non_deductible" value=""> 
                        @if($errors->has('non_deductible'))
                            <div class="invalid-feedback">
                                {{ $errors->first('non_deductible') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.stand_rel_order_qty') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('stand_rel_order_qty') ? 'is-invalid' : '' }}" name="stand_rel_order_qty" value=""> 
                        @if($errors->has('stand_rel_order_qty'))
                            <div class="invalid-feedback">
                                {{ $errors->first('stand_rel_order_qty') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.price_date') }}</label>
                        <input type="date" class="form-control form-control-line {{ $errors->has('price_date') ? 'is-invalid' : '' }}" name="price_date" value=""> 
                        @if($errors->has('price_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.purchasing_doc_category') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('purchasing_doc_category') ? 'is-invalid' : '' }}" name="purchasing_doc_category" value=""> 
                        @if($errors->has('purchasing_doc_category'))
                            <div class="invalid-feedback">
                                {{ $errors->first('purchasing_doc_category') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.net_weight') }}</label>
                        <input type="number" class="form-control form-control-line {{ $errors->has('net_weight') ? 'is-invalid' : '' }}" name="net_weight" value=""> 
                        @if($errors->has('net_weight'))
                            <div class="invalid-feedback">
                                {{ $errors->first('net_weight') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.unit_of_weight') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('unit_of_weight') ? 'is-invalid' : '' }}" name="unit_of_weight" value=""> 
                        @if($errors->has('unit_of_weight'))
                            <div class="invalid-feedback">
                                {{ $errors->first('unit_of_weight') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.rfq-detail.fields.material_type') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('material_type') ? 'is-invalid' : '' }}" name="material_type" value=""> 
                        @if($errors->has('material_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('material_type') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.rfq.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection