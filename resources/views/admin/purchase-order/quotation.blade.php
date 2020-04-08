@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.purchase-order-quotation.title_singular') }}</a></li>
            <li class="breadcrumb-item active">Create Quotation</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order-quotation.fields.id') }}
                                </th>
                                <th>
                                    PO No.
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order-quotation.fields.po_date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order-quotation.fields.vendor_id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.purchase-order-quotation.fields.request_date') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $key => $val)
                                <tr data-entry-id="{{ $val->id }}">
                                    <td>

                                    </td>
                                    <td>{{ $val->id ?? '' }}</td>
                                    <td>{{ $val->po_no }}</td>
                                    <td>{{ $val->po_date }}</td>
                                    <td>{{ !empty($val->vendor_id) ? $val->vendor->name . ' - ' . $val->vendor->email : '' }}</td>
                                    <td>{{ $val->po_date ?? '' }}</td>
                                    <td>
                                        {{-- @can('purchase_order_approval')                                             --}}
                                            <a class="btn btn-xs btn-success" href="{{ route('admin.purchase-order-quotation-approval', $val->id) }}">
                                                {{ trans('cruds.purchase-order-quotation.approval') }}
                                            </a>
                                        {{-- @endcan
                                        @can('purchase_request_show') --}}
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.purchase-order-quotation-show', $val->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        {{-- @endcan --}}
                                        {{-- @can('purchase_request_edit') --}}
                                            {{-- <a class="btn btn-xs btn-info" href="{{ route('admin.purchase-order-quotation.edit', $val->id) }}">
                                                {{ trans('global.edit') }}
                                            </a> --}}
                                        {{-- @endcan --}}
                                        @can('purchase_request_delete')
                                            <form action="{{ route('admin.purchase-order-quotation.destroy', $val->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan
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
@endsection