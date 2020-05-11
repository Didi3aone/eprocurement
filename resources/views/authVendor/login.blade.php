@extends('layouts.app')
@section('content')
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ asset('images/background/login-register.jpg') }};">        
        <div class="login-box card">
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form class="form-horizontal form-material" method="POST" id="loginform" action="{{ route('vendor.login') }}">
                    @csrf
                    {{-- <h3 class="box-title m-b-20"> --}}
                        <center><img src="{{ asset('images/ene-group.jpg') }}" width="200"></center>
                    {{-- </h3> --}}
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', null) }}" name="email" type="email" required="" placeholder="Email"> 
                        </div>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" required="" placeholder="Password"> 
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div> 
                        </div>
                    </div> --}}
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Don't have an account? <a href="{{ route('vendor.register') }}" class="text-info m-l-5"><b>Sign Up</b></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@parent
<script>
    $("#danger-alert").fadeTo(2000, 500).slideUp(500, function() {
        $("#danger-alert").slideUp(500);
    });
</script>    
@endsection