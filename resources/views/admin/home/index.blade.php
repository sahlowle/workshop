@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')

<div class="row">
  <div class="col-sm-6 col-lg-6 mb-4">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary"> @lang('Hello')  {{ auth()->user()->name }} ! 🎉</h5>
            <p class="mb-4">
              {{ greeting() }}
            </p>

          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6 col-lg-4 mb-4">
    <div class="card card-border-shadow-primary h-100 bg-primary text-white">
      <div class="card-body">
        <a href="{{ route('roads.index') }}">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class=" me-2">
            <span class="avatar-initial rounded "><i class="fs-2 bx bx-map-alt"></i></span>
          </div>
          <h4 class="ms-1 mb-0 text-white"> {{ $routes_count }} </h4>
        </div>
        </a>
        <p class="mb-1"> @lang('Routes') </p>
        <p class="mb-0">
          {{-- <span class="fw-medium me-1">+18.2%</span> --}}
          <small class="text-muted text-white"> @lang('All Routes') </small>
        </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-4 mb-4">
    <div class="card card-border-shadow-primary h-100 bg-primary text-white">
      <div class="card-body">
        <a href="{{ route('orders.index') }}">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class=" me-2">
            <span class="avatar-initial rounded "><i class="fs-2 bx bxs-calendar-check"></i></span>
          </div>
          <h4 class="ms-1 mb-0 text-white"> {{ $orders_count }} </h4>
        </div>
        </a>
        <p class="mb-1"> @lang('Orders') </p>
        <p class="mb-0">
          {{-- <span class="fw-medium me-1">+18.2%</span> --}}
          <small class="text-muted"> @lang('All Orders') </small>
        </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-4 mb-4">
    <div class="card card-border-shadow-primary h-100 bg-primary text-white">
      <div class="card-body">
        <a href="{{ route('orders.unpaid') }}">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class=" me-2">
            <span class="avatar-initial rounded ">
              <i class='fs-2 bx bxs-bell-ring'></i>
            </span>
          </div>
          <h4 class="ms-1 mb-0 text-white"> {{ $unpaid_orders }} </h4>
        </div>
        </a>
        <p class="mb-1"> @lang('Payment alert (orders)') </p>
        <p class="mb-0">
          {{-- <span class="fw-medium me-1">+18.2%</span> --}}
          <small class="text-muted"> @lang("It's time for some customers to pay up") </small>
        </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-6 mb-4">
    <div class="card card-border-shadow-warning h-100 bg-primary text-white">
      <div class="card-body">
        <a href="{{ route('customers.index') }}">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="me-2">
            <span class="avatar-initial rounded "><i class='fs-2 bx bx-user-check'></i></span>
          </div>
          <h4 class="ms-1 mb-0 text-white"> {{ $customers_count }} </h4>
        </div>
        </a>
        <p class="mb-1"> @lang('Customers') </p>
        <p class="mb-0">
          {{-- <span class="fw-medium me-1">-8.7%</span> --}}
          <small class="text-muted"> @lang('All Customers') </small>
        </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-6 mb-4">
    <div class="card card-border-shadow-danger h-100 bg-primary text-white">
      <div class="card-body">
        <a href="{{ route('drivers.index') }}">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="me-2">
              <span class="avatar-initial rounded"><i class='fs-2 bx bx-wrench'></i></span>
            </div>
            <h4 class="ms-1 mb-0 bg-primary text-white">{{ $drivers_count }}</h4>
          </div>
        </a>
        <p class="mb-1"> @lang('Technician') </p>
        <p class="mb-0">
          {{-- <span class="fw-medium me-1">+4.3%</span> --}}
          <small class="text-muted"> @lang('All Technician') </small>
        </p>
      </div>
    </div>
  </div>
  
</div>


@endsection
