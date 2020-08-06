@extends('layouts.admin')
@section('content')
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
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.code') }}
                            </th>
                            <td style="font-weight: bold;">
                                {{ $vendors->code }}
                            </td>
                        </tr>
                        <!-- <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.name') }}
                            </th>
                            <td>
                                {{ $vendors->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.email') }}
                            </th>
                            <td>
                                {{ $vendors->email }}
                            </td>
                        </tr> -->
                    </tbody>
                </table>
                <form class="form-material m-t-40" method="POST" action="{{ route("admin.vendors.update", [$vendors->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="name" required="" placeholder="Name" value="{{ $vendors->name ?? old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control" name="vendor_title_id" required>
                                        <option value="" selected="" disabled="">Select Title</option>
                                        @foreach($vendor_title as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control" name="vendor_bp_group_id" required>
                                        <option value="" selected="" disabled="">Select BP Group</option>
                                        @foreach($vendor_bp_group as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control" name="specialize" required>
                                        <option value="" selected="" disabled="">Specialization of Business</option>
                                        <option value="INDIRECT">Indirect</option>
                                        <option value="RAW">Raw Material</option>
                                        <option value="PACKAGING">Packaging Material</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="company_name" required value="{{ $vendors->company_name ?? old('company_name') }}" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street" required value="{{ $vendors->street ?? old('street') }}" placeholder="Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_2" value="{{ $vendors->street_2 ?? old('street_2') }}" placeholder="Address 2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_3" value="{{ $vendors->street_3 ?? old('street_3') }}" placeholder="Address 3">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_4" value="{{ $vendors->street_4 ?? old('street_4') }}" placeholder="Address 4">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_5" value="{{ $vendors->street_5 ?? old('street_5') }}" placeholder="Address 5">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="postal_code" required value="{{ $vendors->postal_code ?? old('postal_code') }}" placeholder="Postal Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="city" required value="{{ $vendors->city ?? old('city') }}" placeholder="City">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control" name="country" required="">
                                        <option value="" selected="" disabled="">Select Country</option>
                                        @foreach($vendor_country as $row)
                                        <option value="{{ $row->code }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="company_web" value="{{ $vendors->company_web ?? old('company_web') }}" placeholder="Company Web">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="office_telephone" required value="{{ $vendors->office_telephone ?? old('office_telephone') }}" placeholder="Telephone">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="telephone_2" value="{{ $vendors->telephone_2 ?? old('telephone_2') }}" placeholder="Telephone 2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="telephone_3" value="{{ $vendors->telephone_3 ?? old('telephone_3') }}" placeholder="Telephone 3">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="office_fax" required value="{{ $vendors->office_fax ?? old('office_fax') }}" placeholder="Fax">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="fax_2" value="{{ $vendors->fax_2 ?? old('fax_2') }}" placeholder="Fax 2">
                                </div>
                            </div>
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
                                    <input class="form-control" type="text" name="bank_account_no" required value="{{ $vendors->bank_account_no ?? old('bank_account_no') }}" placeholder="Bank Account No">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="bank_account_holder_name" required value="{{ $vendors->bank_account_holder_name ?? old('bank_account_holder_name') }}" placeholder="Bank Account Holder Name">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="tax_numbers" required value="{{ $vendors->tax_numbers ?? old('tax_numbers') }}" placeholder="Tax Numbers">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="email" name="email" required value="{{ $vendors->email ?? old('email') }}" placeholder="Email">
                                </div>
                            </div>
                             <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="email" name="email_2" value="{{ $vendors->email_2 ?? old('email_2') }}" placeholder="Email 2">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="password" name="password" id="password" required="" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="password" name="c_password" id="c_password" required="" placeholder="Confirm Password">
                                    <span id="c_password_error" class="btn btn-sm btn-danger" style="display: none;">Password must be same</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label style="font-weight: bold;">Terms of payment</label>
                                    <select class="form-control" name="terms_of_payment_id" required="">
                                        <option value="" selected="" disabled="">Select Term Of Payment</option>
                                        @foreach($terms_of_payment as $row)
                                        <option value="{{ $row->id }}" {{ $vendors->payment_terms==$row->code?'selected=""':'' }} >{{ $row->description }}</option>
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
@endsection