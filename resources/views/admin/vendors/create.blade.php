@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="{{ route("admin.vendors.store") }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row" style="padding: 0 15px;">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Vendor Name *</label>
                                    <input class="form-control" type="text" name="name" value="{{ old('name') }}" required=""> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Vendor Title *</label>
                                    <select class="form-control" name="vendor_title_id" required>
                                        <option value="" selected="" disabled="">Select Title</option>
                                        @foreach($vendor_title as $row)
                                        <option value="{{ $row->id }}" {{ old('vendor_title_id')==$row->id?'selected=""':'' }}>{{ $row->name }}</option>
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
                                        <option value="{{ $row->id }}" {{ old('vendor_bp_group_id')==$row->id?'selected=""':'' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Specialize *</label>
                                    <select class="form-control" name="specialize" required>
                                        <option value="" selected="" disabled="">Specialization of Business</option>
                                        <option value="INDIRECT" {{ old('specialize')=='INDIRECT'?'selected=""':'' }}>Indirect</option>
                                        <option value="RAW" {{ old('specialize')=='RAW'?'selected=""':'' }}>Raw Material</option>
                                        <option value="PACKAGING" {{ old('specialize')=='PACKAGING'?'selected=""':'' }}>Packaging Material</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Company Name *</label>
                                    <input class="form-control" type="text" name="company_name" required value="{{ old('company_name') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address *</label>
                                    <input class="form-control" type="text" name="street" required value="{{ old('street') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 2</label>
                                    <input class="form-control" type="text" name="street_2" value="{{ old('street_2') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 3</label>
                                    <input class="form-control" type="text" name="street_3" value="{{ old('street_3') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 4</label>
                                    <input class="form-control" type="text" name="street_4" value="{{ old('street_4') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Address 5</label>
                                    <input class="form-control" type="text" name="street_5" value="{{ old('street_5') }}"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Postal Code *</label>
                                    <input class="form-control" type="text" name="postal_code" required value="{{ old('postal_code') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">City *</label>
                                    <input class="form-control" type="text" name="city" required value="{{ old('city') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Country *</label>
                                    <select class="form-control" name="country" required="">
                                        <option value="" selected="" disabled="">Select Country</option>
                                        @foreach($vendor_country as $row)
                                        <option value="{{ $row->code }}" {{ old('country')==$row->code?'selected=""':'' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Company Web</label>
                                    <input class="form-control" type="text" name="company_web" value="{{ old('company_web') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Telephone *</label>
                                    <input class="form-control" type="text" name="office_telephone" required value="{{ old('office_telephone') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Telephone 2</label>
                                    <input class="form-control" type="text" name="telephone_2" value="{{ old('telephone_2') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Telephone 3</label>
                                    <input class="form-control" type="text" name="telephone_3" value="{{ old('telephone_3') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Fax *</label>
                                    <input class="form-control" type="text" name="office_fax" required value="{{ old('office_fax') }}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Fax 2</label>
                                    <input class="form-control" type="text" name="fax_2" value="{{ old('fax_2') }}"> 
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <label class="text-muted">Tax Numbers *</label>
                                    <input class="form-control" type="text" name="tax_numbers" required value="{{ old('tax_numbers') }}"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <table class="table table-striped">
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
                                    @for($i=0; $i < 10; $i++)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="vendor_email_id[]">
                                            <input class="form-control" style="width: 70%;" type="text" name="email[]" placeholder="Type email here" {{ $i==0 ? 'required=""':'' }}>
                                        </td>
                                        <td>
                                            <input class="form-check-input" style="left: 85%; opacity: 100%;" type="radio" value="1" name="is_default[]">
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Bank Countries *</label>
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
                                    <label class="text-muted">Bank Keys *</label>
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
                                    <label class="text-muted">Bank Account No *</label>
                                    <input class="form-control" type="text" name="bank_account_no" required>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <label class="text-muted">Bank Account Holder Name *</label>
                                    <input class="form-control" type="text" name="bank_account_holder_name" required>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <label class="text-muted">Password *</label>
                                    <input class="form-control" type="password" name="password" id="password" required="" placeholder="*****">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="text-muted">Confirm Password *</label>
                                    <input class="form-control" type="password" name="c_password" id="c_password" required="" placeholder="*****">
                                    <span id="c_password_error" class="btn btn-sm btn-danger" style="display: none;">Password must be same</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label style="font-weight: bold;">Terms of payment</label>
                                    <select class="form-control" name="terms_of_payment_id" required="">
                                        <option value="" selected="" disabled="">Select Term Of Payment</option>
                                        @foreach($terms_of_payment as $row)
                                        <option value="{{ $row->id }}" {{ old('payment_terms')==$row->code?'selected=""':'' }}>{{ $row->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-weight: bold;">{{ trans('cruds.vendors.fields.status') }}</label>
                                <div class="">
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" id="inline-radio-active" type="radio" value="1"
                                            name="status" {{ old('status') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inline-radio-active">Approve</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" id="inline-radio-non-active" type="radio" value="2"
                                            name="status" {{ old('status') == 2 ? 'checked' : '' }}>
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
@endsection
@section('scripts')
<script type="text/javascript">
    $(function () {
        $('#c_password').keyup(function(){
            let c_password = $(this).val()
            let password = $('#password').val()
            if (c_password == password) {
                $('#c_password_error').css('display', 'none')
                $('#btn-submit').attr('disabled', false)
            } else {
                $('#c_password_error').css('display', '')
                $('#btn-submit').attr('disabled', true)
            }
        })
    })
</script>
@endsection