@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Quotation</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Online</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ trans('cruds.quotation.fields.id') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.po_no') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.leadtime_type') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.purchasing_leadtime') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.target_price') }}</th>
                                        <th>{{ trans('cruds.quotation.fields.expired_date') }}</th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotation as $key => $val)
                                        <tr data-entry-id="{{ $val->id }}">
                                            <td>{{ $val->id ?? '' }}</td>
                                            <td>{{ $val->po_no ?? '' }}</td>
                                            <td>{{ $val->leadtime_type == 0 ? 'Date' : 'Day Count' }}</td>
                                            <td>{{ $val->purchasing_leadtime ?? '' }}</td>
                                            <td>{{ number_format($val->target_price, 0, '', '.') ?? '' }}</td>
                                            <td>
                                                @php
                                                $is_expired = '#67757c';
                                                @endphp
                                                @if (time() > strtotime($val->expired_date))
                                                    @php $is_expired = 'red'; @endphp
                                                @elseif (time() > strtotime('-2 days', strtotime($val->expired_date)) && time() <= strtotime($val->expired_date))
                                                    @php $is_expired = 'orange'; @endphp
                                                @endif
                                                <span style="color: {{ $is_expired }}">{{ $val->expired_date ?? '' }}</span>
                                            </td>
                                            <td>
                                                @can('quotation_show')
                                                @if (time() <= strtotime($val->expired_date))
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.quotation.show', $val->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endif
                                                @endcan

                                                @can('quotation_edit')
                                                    <a class="btn btn-xs btn-info" href="{{ route('admin.quotation.edit', $val->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('quotation_delete')
                                                    {{-- <form action="{{ route('admin.quotation.destroy', $val->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                    </form> --}}
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
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$('#datatables-run').DataTable({
    dom: 'Bfrtip',
    order: [[0, 'desc']],
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
@endsection