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
                                            <td>
                                                <input type="text" name="name[]" value="Price" style="width: 100%">
                                            </td>
                                            <td>
                                                <input type="number" class="min" name="min[]" value="" style="width: 100%" required>
                                            </td>
                                            <td>
                                                <input type="number" class="max" name="max[]" value="" style="width: 100%" required>
                                            </td>
                                            <td>
                                                <input type="number" class="price" name="price[]" value="" style="width: 100%" required>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
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
@endsection

@section('scripts')
<script>
    $('#add_varian').on('click', function (e) {
        e.preventDefault()

        const html = `
            <tr>
                <td>
                    <input type="text" name="name[]" value="Price" style="width: 100%">
                </td>
                <td>
                    <input type="number" class="min" name="min[]" value="" style="width: 100%" required>
                </td>
                <td>
                    <input type="number" class="max" name="max[]" value="" style="width: 100%" required>
                </td>
                <td>
                    <input type="number" class="price" name="price[]" value="" style="width: 100%" required>
                </td>
                <td>
                    <button type="button" class="remove btn btn-danger btn-xs" onclick="this.parentNode.parentNode.remove();">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                </td>
            </tr>
        `

        $('#wholesales').append(html)
    })

    $('.money').mask('#.##0', { reverse: true });
</script>
@endsection