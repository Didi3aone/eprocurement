@extends('layouts.app')
@section('content')
<section id="wrapper">
    <div class="login-register" style="background-color: green; padding: 3% 0">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" method="post" action="{{ route('vendor.register') }}">
                    @csrf
                    @method('POST')
                    <center><img src="{{ asset('images/ene-group.jpg') }}" width="200"></center>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control" name="specialize" required="" placeholder="Specialization of Business">
                                        <option value="INDIRECT">Indirect</option>
                                        <option value="RAW">Raw Material</option>
                                        <option value="PACKAGING">Packaging Material</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="name" required="" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="email" name="email" required="" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="password" name="password" required="" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="password" name="password_confirmation" required="" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="company_name" required="" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="address" required="" placeholder="Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="city" required="" placeholder="City">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="country" required="" placeholder="Country">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control" name="pkp" required="" placeholder="PKP">
                                        <option value="PKP">PKP</option>
                                        <option value="NON">Non PKP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="state" required="" placeholder="State / Province">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="zip_code" required="" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="code_area" required="" placeholder="Code Area">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="office_phone" required="" placeholder="Office Phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="office_fax" required="" placeholder="Office Fax">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="phone" required="" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-success p-t-0 p-l-10">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Sign Up</button>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>Already have an account? <a href="{{ route('vendor.login') }}" class="text-info m-l-5"><b>Sign In</b></a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
