@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="theme-loader">
    <div class="loader-track">
        <div class="loader-bar"></div>
    </div>
</div>
<section class="login text-center bg-primary common-img-bg" style="position: relative; padding-bottom:150px;">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->
                <div class="login-card card-block auth-body mr-auto ml-auto">
                    <form class="md-float-material" method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center m-2">
                            <img src="{{ asset('uploads/' . config('business')->logo) }}" alt="logo.png" class="img-fluid" style="max-height:100px; max-width:200px;">
                            <h3 style="color: white;">{{ config('business.name', config('app.name')) }}</h3>
							<h4 style="color: white;">BIS</h4>
                            <h4 style="color: white;">{{ config('business.desc_name', config('app.desc_name')) }}</h4>
                        </div>
                        <div class="auth-box">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                <h3 class="text-center text-primary">{{ __('Sign In') }}</h3>
                                </div>
                            </div>
                            <hr/>
                            <div class="input-group">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="button-see-password"><i id="pass-eye-icon" class="fa fa-eye-slash"></i></div>
                                </div>
  
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row m-t-25 text-left">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="text-secondary" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                @if (Route::has('password.request'))
                                    <div class="col-md-12">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- Authentication card end -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>
<div class="text-center p-3 text-white" style="background-color: #4099ff; position: fixed; bottom:0; width:100%">
    © {{ date("Y") }} Copyright:
    <a class="text-reset fw-bold" href="#">GUPUSBEKANG-1 PUSBEKANGAD</a>
</div>
@endsection
@push('scripts')
@include('partials.functions')   
@endpush
