@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Issue Transaction</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('cruds.request-note.title') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("admin.request-note.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.request-note.fields.request_no') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('request_no') ? 'is-invalid' : '' }}" name="request_no" value="{{ old('request_no', '') }}"> 
                        @if($errors->has('request_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('request_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Request Date</label>
                        <input type="text" class="form-control datepicker form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" value="{{ old('notes', '') }}"> 
                        @if($errors->has('notes'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notes') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.request-note.fields.category_id') }}</label>
                        <select class="form-control select2 {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                            @foreach($purchasingGroups as $id => $pg)
                                <option value="{{ $pg->code }}" {{ in_array($pg->code, old('category_id', [])) ? 'selected' : '' }}>{{ $pg->code }} - {{ $pg->description }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('category_id') }}
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
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-material-tab" data-toggle="tab" href="#nav-material" role="tab" aria-controls="nav-material" aria-selected="true">Material</a>
                                <a class="nav-item nav-link" id="nav-asset-tab" data-toggle="tab" href="#nav-asset" role="tab" aria-controls="nav-asset" aria-selected="false">Asset</a>
                                <a class="nav-item nav-link" id="nav-plant-tab" data-toggle="tab" href="#nav-plant" role="tab" aria-controls="nav-plant" aria-selected="false">Plant</a>
                                <a class="nav-item nav-link" id="nav-purchasing-group-tab" data-toggle="tab" href="#nav-purchasing-group" role="tab" aria-controls="nav-purchasing-group" aria-selected="false">Purchasing Group</a>
                                <a class="nav-item nav-link" id="nav-material-group-tab" data-toggle="tab" href="#nav-material-group" role="tab" aria-controls="nav-material-group" aria-selected="false">Material Group</a>
                                <a class="nav-item nav-link" id="nav-requestor-tab" data-toggle="tab" href="#nav-requestor" role="tab" aria-controls="nav-requestor" aria-selected="false">Requestor</a>
                                <a class="nav-item nav-link" id="nav-text-tab" data-toggle="tab" href="#nav-text" role="tab" aria-controls="nav-text" aria-selected="false">Text</a>
                                <a class="nav-item nav-link" id="nav-other-tab" data-toggle="tab" href="#nav-other" role="tab" aria-controls="nav-other" aria-selected="false">Other</a>
                            </div>
                        </nav>
                        
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="nav-material" role="tabpanel" aria-labelledby="nav-material-tab">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Description</th>
                                            <th style="width: 10%">Qty</th>
                                            <th style="width: 10%">Unit</th>
                                            <th>Notes</th>
                                            <th>
                                                <button type="button" id="add_material_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="material_items"></tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-asset" role="tabpanel" aria-labelledby="nav-asset-tab">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>
                                                <button type="button" id="add_asset_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="asset_items"></tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-plant" role="tabpanel" aria-labelledby="nav-plant-tab">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>
                                                <button type="button" id="add_plant_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="plant_items"></tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-purchasing-group" role="tabpanel" aria-labelledby="nav-purchasing-group-tab">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>
                                                <button type="button" id="add_purchasing_group_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchasing_group_items"></tbody>
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