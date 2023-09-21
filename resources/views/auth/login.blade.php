@extends('admin.layouts.blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="">
  <div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
        <div class="w-100 d-flex justify-content-center">
          <img src="{{ loginBackground() }}" class="img-fluid" alt="Login image" width="700"
            data-app-dark-img="illustrations/boy-with-rocket-dark.png"
            data-app-light-img="illustrations/boy-with-rocket-light.png">
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Login -->
      <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <!-- Logo -->
          <div class="app-brand mb-5">
            <a href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo-1"
              class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo.png') }}" style="max-height: 55px">
              </span>
              {{-- <span class="app-brand-text demo text-body fw-bold">Sneat</span> --}}
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Welcome to {{ config('variables.templateName') }}! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 fv-plugins-icon-container">
              <label for="email" class="form-label"> @lang('Email') </label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle fv-plugins-icon-container">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">@lang('Password')</label>
                <a href="{{ route('password.request') }}">
                  <small> @lang('Forgot Password?') </small>
                </a>
              </div>
              <div class="input-group input-group-merge has-validation">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="current-password">

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  @lang('Remember Me')
                </label>
              </div>
            </div>
            <button class="btn btn-primary d-grid w-100">
              @lang('Sign in')
            </button>
            <input type="hidden">
          </form>



          <div class="divider my-4">
            <div class="divider-text">or</div>
          </div>


        </div>
      </div>
      <!-- /Login -->
    </div>
  </div>
</div>
</div>
@endsection
