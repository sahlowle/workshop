@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Admins") /</span> {{ $title }}
</h4>

<!-- Hoverable Table rows -->
<div class="row">
  <div class="col-10">
    <div class="card-body">
        <x-alert/>
      {!! Form::open(['route' => 'users.store']) !!}
      <div class="row">
        @include('admin.users.fields')
      </div>
      {!! Form::close() !!}
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!--/ Hoverable Table rows -->

@endsection
