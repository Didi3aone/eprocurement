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
                        <label>{{ trans('cruds.request-note.fields.notes') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" notes="notes" value="{{ old('notes', '') }}"> 
                        @if($errors->has('notes'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notes') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.request-note.fields.category') }}</label>
                        <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" id="category" required>
                            @foreach($purchasingGroups as $id => $pg)
                                <option value="{{ $pg->code }}" {{ in_array($pg->code, old('category', [])) ? 'selected' : '' }}>{{ $pg->code }} - {{ $pg->description }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category'))
                            <div class="invalid-feedback">
                                {{ $errors->first('category') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Code</th>
                                        <th>Description</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 10%">Unit</th>
                                        <th>Notes</th>
                                        <th>
                                            <button type="button" id="add_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="rn_items"></tbody>
                            </table>
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
    let index = 1

    $(document).ready(function () {
        let inc = 1
       
        $('#add_item').on('click', function (e) {
            e.preventDefault()

            const html = `
<tr>
    <td>
        <input type="text" class="form-control" name="rn_no[]" value="${inc}" disabled="disabled">
    </td>
    <td>
        <select name="material_id[]" id="material_${inc}" class="material_id form-control"></select>
    </td>
    <td>
        <input class="form-control" type="text" name="rn_description[]">
    </td>
    <td>
        <input class="form-control" type="number" name="rn_qty[]">
    </td>
    <td>
        <input class="form-control" type="number" name="rn_unit[]">
    </td>
    <td>
        <input class="form-control" type="text" name="rn_notes[]">
    </td>
    <td>
        <a href="javascript:;" class="remove-item btn btn-danger btn-sm">
            <i class="fa fa-times"></i> hapus
        </a>
    </td>
</tr>
            `

            $('#rn_items').append(html)

            listMaterial($('#category').val(), inc)
            inc++
        })

        const url = '{{ route('admin.material.select') }}'

        function listMaterial (code, i) {
            $.getJSON(url, { code: code }, function (items) {
                var newOptions = '<option value="">-- Select --</option>';

                for (var id in items) {
                    newOptions += '<option value="'+ id +'">'+ items[id] +'</option>';
                }

                if (i > 0) {
                    $('#material_' + i).html(newOptions)
                }
            })
        }

        $('#category').on('change', function (e) {
            e.preventDefault()

            const code = $(this).val()

            listMaterial(code, 0)
        })

        $(document).on('click', 'a.remove_item', function (e) {
            console.log($(this))
            e.stopPropagation()
            e.stopImmediatePropagation()
            e.preventDefault()

            inc--

            $(this).parent().parent().remove()
        })
    })
</script>
@endsection