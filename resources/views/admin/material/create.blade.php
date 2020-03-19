@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Material</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.material.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.code') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" value="{{ old('code', '') }}"> 
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.small_description') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('small_description') ? 'is-invalid' : '' }}" name="small_description" value="{{ old('small_description', '') }}"> 
                        @if($errors->has('small_description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('small_description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.description') }}</label>
                        <input type="text" class="form-control form-control-line {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" value="{{ old('description', '') }}"> 
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_group_id') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('m_group_id') ? 'is-invalid' : '' }}" name="m_group_id" id="m_group_id" required>
                            @foreach($materialGroups as $id => $mg)
                                <option value="{{ $id }}" {{ old('m_group_id', '') ? 'selected' : '' }}>{{ $mg->code }} - {{ $mg->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_type_id') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('m_type_id') ? 'is-invalid' : '' }}" name="m_type_id" id="m_type_id" required>
                            @foreach($materialTypes as $id => $mt)
                                <option value="{{ $id }}" {{ old('m_type_id', '') ? 'selected' : '' }}>{{ $mt->code }} - {{ $mt->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_plant_id') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('m_plant_id') ? 'is-invalid' : '' }}" name="m_plant_id" id="m_plant_id" required>
                            @foreach($plants as $id => $pl)
                                <option value="{{ $id }}" {{ old('m_plant_id', '') ? 'selected' : '' }}>{{ $pl->code }} - {{ $pl->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_purchasing_id') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('m_purchasing_id') ? 'is-invalid' : '' }}" name="m_purchasing_id" id="m_purchasing_id" required>
                            @foreach($purchasingGroups as $id => $pg)
                                <option value="{{ $id }}" {{ old('m_purchasing_id', '') ? 'selected' : '' }}>{{ $pg->code }} - {{ $pg->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.masterMaterial.fields.m_profit_id') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('m_profit_id') ? 'is-invalid' : '' }}" name="m_profit_id" id="m_profit_id" required>
                            @foreach($profitCenters as $id => $pc)
                                <option value="{{ $id }}" {{ old('m_profit_id', '') ? 'selected' : '' }}>{{ $pc->code }} - {{ $pc->description }}</option>
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