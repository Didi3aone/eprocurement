@extends('layouts.app')
@section('content')
<section id="wrapper">
    <div class="login-register" style="background-color: green; padding: 3% 0; position: relative !important">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="login-box card" style="width: 70% !important">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" method="post" action="{{ route('vendor.register') }}">
                    @csrf
                    @method('POST')
                    <center><img src="{{ asset('images/ene-group.jpg') }}" width="200"></center>
                    <div class="row">
                        <div class="col-lg-6">
                            {{-- <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="name" required="" placeholder="Name" value="{{ old('name') }}">
                                </div>
                            </div> --}}
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
                                    <input class="form-control" type="text" name="company_name" required="" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street" required placeholder="Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_2" placeholder="Address 2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_3" placeholder="Address 3">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_4" placeholder="Address 4">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="street_5" placeholder="Address 5">
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="different_city" required="" placeholder="Different City">
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="postal_code" required placeholder="Postal Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="city" required placeholder="City">
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
                                    <input class="form-control" type="text" name="company_web" placeholder="Company Web">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control" name="pkp" required="" placeholder="PKP">
                                        <option value="PKP">PKP</option>
                                        <option value="NON">Non PKP</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="office_telephone" required placeholder="Telephone">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="telephone_2" placeholder="Telephone 2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="telephone_3" placeholder="Telephone 3">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="office_fax" required="" placeholder="Fax">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="fax_2" placeholder="Fax 2">
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
                                    <input class="form-control" type="text" name="bank_account_no" required placeholder="Bank Account No">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="bank_account_holder_name" required placeholder="Bank Account Holder Name">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="tax_numbers" required="" placeholder="Tax Numbers">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="email" name="email" required="" placeholder="Email">
                                </div>
                            </div>
                             <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="email" name="email_2" placeholder="Email 2">
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
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox checkbox-success p-t-0 p-l-10">
                                        <input id="checkbox-signup" name="agreement" type="checkbox">
                                        <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12">
                                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" id="btn-submit" type="submit">Sign Up</button>
                                </div>
                            </div>
                            <div class="form-group m-b-0">
                                <div class="col-sm-12 text-center">
                                    <p>Already have an account? <a href="{{ route('vendor.login') }}" class="text-info m-l-5"><b>Sign In</b></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
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
