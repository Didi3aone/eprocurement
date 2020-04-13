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
                                <th>
                                    {{ trans('cruds.quotation.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.po_no') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.vendor_id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.leadtime_type') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.purchasing_leadtime') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.target_price') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.expired_date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.vendor_leadtime') }}
                                </th>
                                <th>
                                    {{ trans('cruds.quotation.fields.vendor_price') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $key => $val)
                                <tr data-entry-id="{{ $val->id }}">
                                    <td>{{ $val->id ?? '' }}</td>
                                    <td>{{ $val->po_no ?? '' }}</td>
                                    <td>{{ isset($val->vendor_id) ? $val->vendor->name . ' - ' . $val->vendor->email : '' }}</td>
                                    <td>{{ $val->leadtime_type == 0 ? 'Date' : 'Day Count' }}</td>
                                    <td>{{ $val->purchasing_leadtime ?? '' }}</td>
                                    <td>{{ $val->target_price ?? '' }}</td>
                                    <td>
                                        @if (time() > strtotime($val->expired_date))
                                            @php $is_expired = 'red'; @endphp
                                        @elseif (time() > strtotime('-2 days', strtotime($val->expired_date)) && time() <= strtotime($val->expired_date))
                                            {{-- @dd(time(), strtotime('-2 days', strtotime($val->expired_date))) --}}
                                            @php $is_expired = 'orange'; @endphp
                                        @endif
                                        <span style="color: {{ $is_expired }}">{{ $val->expired_date ?? '' }}</span>
                                    </td>
                                    <td>{{ $val->vendor_leadtime ?? '' }}</td>
                                    <td>{{ $val->vendor_price ?? '' }}</td>
                                    <td>
                                        @can('quotation_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.quotation.show', $val->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('quotation_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.quotation.edit', $val->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('quotation_delete')
                                            <form action="{{ route('admin.quotation.destroy', $val->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $('.table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
@endsection