@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Material</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.material.update", $material->id) }}" enctype="multipart/form-data" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ $material->code ?? old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.description') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" value="{{ $material->description ?? old('description', '') }}"> 
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_group_id') }}</label>
                        <select class="form-control {{ $errors->has('material_group_code') ? 'is-invalid' : '' }}" name="material_group_code" id="material_group_code">
                            @foreach($materialGroups as $id => $mg)
                                <option value="{{ $mg->code }}" {{ $mg->code == $material->material_group_code ? 'selected' : '' }}>{{ $mg->code }} - {{ $mg->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_type_id') }}</label>
                        <select class="form-control {{ $errors->has('material_type_code') ? 'is-invalid' : '' }}" name="material_type_code" id="material_type_code">
                            @foreach($materialTypes as $id => $mt)
                                <option value="{{ $mt->code }}" {{ $mt->code == $material->material_type_code ? 'selected' : '' }}>{{ $mt->code }} - {{ $mt->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <select class="form-control select2 {{ $errors->has('uom_code') ? 'is-invalid' : '' }}" name="uom_code" id="uom_code">
                            @foreach($unit as $id => $mt)
                                <option value="{{ $mt->code }}" {{ $mt->code == $material->uom_code ? 'selected' : ''  }}>{{ $mt->uom }} - {{ $mt->text }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_plant_id') }}</label>
                        <select class="form-control {{ $errors->has('plant_code') ? 'is-invalid' : '' }}" name="plant_code" id="plant_code">
                            @foreach($plants as $id => $pl)
                                <option value="{{ $pl->code }}" {{ $pl->code == $material->plant_code ? 'selected' : '' }}>{{ $pl->code }} - {{ $pl->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_purchasing_id') }}</label>
                        <select class="form-control {{ $errors->has('purchasing_group_code') ? 'is-invalid' : '' }}" name="purchasing_group_code" id="purchasing_group_code">
                            @foreach($purchasingGroups as $id => $pg)
                                <option value="{{ $pg->code }}" {{ $pg->code == $material->purchasing_group_code ? 'selected' : '' }}>{{ $pg->code }} - {{ $pg->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_profit_id') }}</label>
                        <select class="form-control {{ $errors->has('profit_center_code') ? 'is-invalid' : '' }}" name="profit_center_code" id="profit_center_code">
                            @foreach($profitCenters as $id => $pc)
                                <option value="{{ $pc->code }}" {{ $pc->code == $material->profit_center_code ? 'selected' : '' }}>{{ $pc->code }} - {{ $pc->description }}</option>
                            @endforeach
                        </select>
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