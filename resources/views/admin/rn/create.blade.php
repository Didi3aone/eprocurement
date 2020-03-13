@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Issue Transaction</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">RN</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-rn m-t-40" action="{{ route("admin.rn.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.inputRN.fields.code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.inputRN.fields.notes') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('notes') ? 'is-invalid' : '' }}" notes="notes" value="{{ old('notes', '') }}"> 
                        @if($errors->has('notes'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notes') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.inputRN.fields.category') }}</label>
                        <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" id="category" required>
                            @foreach($category as $id => $cat)
                                <option value="{{ $cat->id }}" {{ in_array($cat->id, old('category', [])) ? 'selected' : '' }}>{{ $cat->name }}</option>
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
                                            <button type="button" id="add_item" class="btn btn-primary btn-sm">Add Item</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="rn_items">
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>
                                            <select class="form-control" name="rn_item" id="rn_item">
                                                @foreach($material as $id => $mat)
                                                    <option value="{{ $mat->id }}" {{ in_array($mat->id, old('material', [])) ? 'selected' : '' }}>{{ $mat->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="rn_description" id="rn_description">
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" name="rn_qty" id="rn_qty">
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" name="rn_unit" id="rn_unit">
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="rn_notes" id="rn_notes">
                                        </td>
                                        <td><a href="javascript:;" class="add-item btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Add</a></td>
                                    </tr> --}}
                                </tbody>
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

    document.getElementById('add_item').addEventListener('click', function (e) {
        e.preventDefault()

        createItem(index)
    })

    let createItem = function (idx) {
        let tr = document.createElement('tr')

        let add_select = function (name, id) {
            let td = document.createElement('td')
            let select = document.createElement('select')

            select.id = name + '_' + id
            select.name = name + '_' + id
            select.classList = 'form-control'

            td.appendChild(select)

            return td
        }

        let add_item = function (name, type, id) {
            let td = document.createElement('td')
            let input = document.createElement('input')

            input.type = 'text'
            input.value = name == 'no' ? id : ''
            input.type = type == 'number' ? 'number' : ''
            input.id = name + '_' + id
            input.name = name + '_' + id
            input.classList = 'form-control'

            td.appendChild(input)

            return td
        }

        let add_remove_button = function (id) {
            let td = document.createElement('td')
            let button = document.createElement('button')

            button.id = 'remove_' + id
            button.name = 'remove_' + id
            button.type = 'button'
            button.innerHTML = '<i className="fa fa-times"></i> Delete'
            button.setAttribute('data-id', id)
            button.classList = 'btn btn-danger btn-sm'
            button.addEventListener('click', function (e) {
                e.preventDefault()

                this.parentNode.parentNode.remove()
                index--
            })

            td.appendChild(button)

            return td
        }

        td_no = add_item('no', 'input', idx)
        td_item = add_select('item', idx)
        td_description = add_item('description', 'input', idx)
        td_qty = add_item('qty', 'number', idx)
        td_unit = add_item('unit', 'number', idx)
        td_note = add_item('note', 'input', idx)
        td_remove = add_remove_button(idx)

        tr.appendChild(td_no)
        tr.appendChild(td_item)
        tr.appendChild(td_description)
        tr.appendChild(td_qty)
        tr.appendChild(td_unit)
        tr.appendChild(td_note)
        tr.appendChild(td_remove)

        document.getElementById('rn_items').appendChild(tr)

        index++
    }
</script>
@endsection