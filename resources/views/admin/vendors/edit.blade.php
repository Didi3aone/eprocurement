@extends('layouts.admin')
@section('content')
<style>
    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    .accordion:hover {
        background-color: #ccc; 
    }

    .panel {
        display: none;
        background-color: white;
        overflow: hidden;
    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.code') }}
                            </th>
                            <td style="font-weight: bold;">
                                {{ $vendors->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.email') }} (Active)
                            </th>
                            <td style="font-weight: bold;">
                                {{ $vendors->email }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <form class="form-material " method="POST" action="{{ route("admin.vendors.update", [$vendors->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <button type="button" class="accordion m-b-40">Click for edit email</button>
                    <div class="panel">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vendors.fields.email') }}
                                    </th>
                                    <th>
                                        is Default
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendors->vendor_email as $i => $row)
                                <tr>
                                    <td>
                                        <input type="hidden" name="vendor_email_id[]" value="{{ $row->id }}">
                                        <input class="form-control" style="width: 70%;" type="text" name="email[]" value="{{ $row->email }}" placeholder="Type email here" {{ $i==0 ? 'required=""':'' }}>
                                    </td>
                                    <td>
                                        <input class="form-check-input" style="left: 85%; opacity: 100%;" type="radio" value="1" name="is_default[]" {{ $row->is_default == 1 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row" style="padding: 0 15px;">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Vendor Name *</label>
                                    <input class="form-control" type="text" name="name" value="{{ $vendors->name ?? old('name') }}" required=""> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Vendor Title *</label>
                                    <select class="form-control" name="vendor_title_id" required>
                                        <option value="" selected="" disabled="">Select Title</option>
                                        @foreach($vendor_title as $row)
                                        <option value="{{ $row->id }}" {{ $vendors->vendor_title_id==$row->id?'selected=""':'' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">BP Group *</label>
                                    <select class="form-control" name="vendor_bp_group_id" required>
                                        <option value="" selected="" disabled="">Select BP Group</option>
                                        @foreach($vendor_bp_group as $row)
                                        <option value="{{ $row->id }}" {{ $vendors->vendor_bp_group_id==$row->id?'selected=""':'' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Specialize *</label>
                                    <select class="form-control" name="specialize" required>
                                        <option value="" selected="" disabled="">Specialization of Business</option>
                                        <option value="INDIRECT" {{ $vendors->specialize=='INDIRECT'?'selected=""':'' }}>Indirect</option>
                                        <option value="RAW" {{ $vendors->specialize=='RAW'?'selected=""':'' }}>Raw Material</option>
                                        <option value="PACKAGING" {{ $vendors->specialize=='PACKAGING'?'selected=""':'' }}>Packaging Material</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Company Name *</label>
                                    <input class="form-control" type="text" name="company_name" required value="{{ $vendors->company_name ?? old('company_name') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address *</label>
                                    <input class="form-control" type="text" name="street" required value="{{ $vendors->street ?? old('street') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 2</label>
                                    <input class="form-control" type="text" name="street_2" value="{{ $vendors->street_2 ?? old('street_2') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 3</label>
                                    <input class="form-control" type="text" name="street_3" value="{{ $vendors->street_3 ?? old('street_3') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 4</label>
                                    <input class="form-control" type="text" name="street_4" value="{{ $vendors->street_4 ?? old('street_4') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 5</label>
                                    <input class="form-control" type="text" name="street_5" value="{{ $vendors->street_5 ?? old('street_5') }}"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Postal Code *</label>
                                    <input class="form-control" type="text" name="postal_code" required value="{{ $vendors->postal_code ?? old('postal_code') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">City *</label>
                                    <input class="form-control" type="text" name="city" required value="{{ $vendors->city ?? old('city') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Country *</label>
                                    <select class="form-control" name="country" required="">
                                        <option value="" selected="" disabled="">Select Country</option>
                                        @foreach($vendor_country as $row)
                                        <option value="{{ $row->code }}" {{ $vendors->country==$row->code?'selected=""':'' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Company Web</label>
                                    <input class="form-control" type="text" name="company_web" value="{{ $vendors->company_web ?? old('company_web') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Telephone *</label>
                                    <input class="form-control" type="text" name="office_telephone" required value="{{ $vendors->office_telephone ?? old('office_telephone') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Telephone 2</label>
                                    <input class="form-control" type="text" name="telephone_2" value="{{ $vendors->telephone_2 ?? old('telephone_2') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Telephone 3</label>
                                    <input class="form-control" type="text" name="telephone_3" value="{{ $vendors->telephone_3 ?? old('telephone_3') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Fax *</label>
                                    <input class="form-control" type="text" name="office_fax" required value="{{ $vendors->office_fax ?? old('office_fax') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Fax 2</label>
                                    <input class="form-control" type="text" name="fax_2" value="{{ $vendors->fax_2 ?? old('fax_2') }}"> 
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <label class="text-muted">Tax Numbers *</label>
                                    <input class="form-control" type="text" name="tax_numbers" required value="{{ $vendors->tax_numbers ?? old('tax_numbers') }}"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="show_modal btn btn-success" data-id="{{ $vendors->id }}" data-toggle="modal" data-target="#modal_add_bank">
                                Add Bank Details
                            </button>
                            <br/><br/>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Bank Countries
                                        </th>
                                        <th>
                                            Bank Keys
                                        </th>
                                        <th>
                                            Bank Account No
                                        </th>
                                        <th>
                                            Bank Account Holder Name
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendors->vendor_bank as $i => $value)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="vendor_bank_id[]" value="{{ $value->id }}">
                                            <select class="form-control" name="bank_country_key[]" required>
                                                <option value="" selected="" disabled="">Select Bank Country</option>
                                                @foreach($vendor_bank_country as $row)
                                                <option value="{{ $row->code }}" {{ $value->bank_country_key==$row->code?'selected=""':'' }}>{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="bank_keys[]" required>
                                                <option value="" selected="" disabled="">Select Bank</option>
                                                @foreach($vendor_bank_keys as $row)
                                                <option value="{{ $row->id }}" {{ $value->bank_keys==str_replace(' ', '',  $row->key)?'selected=""':'' }}>{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="bank_account_no[]" value="{{ $value->account_no }}" required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="bank_account_holder_name[]" value="{{ $value->account_holder_name }}" required>
                                        </td>
                                        <td>
                                            <button type="button" class="show_modal btn btn-sm btn-danger" data-bank_id="{{ $value->id }}" data-toggle="modal" data-target="#modal_delete_bank">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label style="font-weight: bold;">Terms of payment</label>
                                    <select class="form-control" name="terms_of_payment_id" required="">
                                        <option value="" selected="" disabled="">Select Term Of Payment</option>
                                        @foreach($terms_of_payment as $row)
                                        <option value="{{ $row->id }}" {{ $vendors->payment_terms==$row->code?'selected=""':'' }}>{{ $row->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-weight: bold;">{{ trans('cruds.vendors.fields.status') }}</label>
                                <div class="">
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" id="inline-radio-active" type="radio" value="1"
                                            name="status" {{ $vendors->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inline-radio-active">Approve</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" id="inline-radio-non-active" type="radio" value="2"
                                            name="status" {{ $vendors->status == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inline-radio-non-active">Reject</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> {{ trans('global.save') }}</button>
                        <a href="{{ route('admin.vendors.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_bank" tabindex="-1" role="dialog" aria-labelledby="modalAddBankDetails" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddBankDetails">Bank Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.vendors.add-bank') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="vendor_id" id="vendor_id" value="">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <select class="form-control" name="bank_country_id" required>
                                <option value="" selected="" disabled="">Select Bank Country</option>
                                @foreach($vendor_bank_country as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <select class="form-control" name="bank_keys_id" required>
                                <option value="" selected="" disabled="">Select Bank</option>
                                @foreach($vendor_bank_keys as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="bank_account_no" required placeholder="Bank Account No">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="bank_account_holder_name" required placeholder="Bank Account Holder Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_delete_bank" tabindex="-1" role="dialog" aria-labelledby="modalDeleteBankDetails" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteBankDetails">Are you sure delete this?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.vendors.delete-bank') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="vendor_bank_id" id="vendor_bank_id" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    let acc = document.getElementsByClassName("accordion")
    let i

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active")
            let panel = this.nextElementSibling
            if (panel.style.display === "block") {
              panel.style.display = "none"
            } else
              panel.style.display = "block"
        })
    }
    $('.show_modal').on('click', function (e) {
        e.preventDefault()

        const id = $(this).data('id')
        $('#vendor_id').val(id)

        const bank_id = $(this).data('bank_id')
        $('#vendor_bank_id').val(bank_id)
    })
</script>
@endsection