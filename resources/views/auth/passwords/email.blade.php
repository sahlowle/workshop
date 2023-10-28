@extends('layouts/blankLayout' )

@section('layoutContent')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<style>
    h1, h2, h3, h4, h5, h6 {
    font-size: revert-layer !important;
    font-weight: 500;
}
</style>
@endsection

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4" style="max-width: 450px">
  
        <!-- Forgot Password -->
        <div class="card">
          <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" style="color: black;" role="alert">
                {{ session('status') }}
            </div>
        @endif
           <!-- Logo -->
           <div class="app-brand justify-content-center mb-5">
            <a href="#"
              class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo.png') }}" style="max-height: 55px">
              </span>
              {{-- <span class="app-brand-text demo text-body fw-bold">Sneat</span> --}}
            </a>
          </div>
          <!-- /Logo -->
            <h1 class="mb-2"> @lang('Forgot Password') ? 🔒</h1>
            <p class="mb-4">
                @lang("Enter your email and we'll send you new password to your email")
            </p>
            <form action="{{ route('password.email') }}" id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
                @csrf
              <div class="mb-3 fv-plugins-icon-container">
                <label for="email" class="form-label"> @lang('Email') </label>
                <input required type="email" class="form-control" id="email" name="email" placeholder="{{ trans('Enter your email') }}" @error('email') is-invalid @enderror>
                @error('email')
                <span style="color: red;"  role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
              <button class="btn btn-primary d-grid w-100"> @lang('Send Password Reset Link') </button>
            <input type="hidden"></form>
            <div class="text-center">
              <a href="{{ route('login') }}">
                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                @lang('Back to login')
              </a>
            </div>
          </div>
        </div>
        <!-- /Forgot Password -->
      </div>
    </div>
  </div>
@endsection

