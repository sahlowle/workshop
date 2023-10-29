@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Routes") /</span> {{ $title }}
</h4>

<!-- Hoverable Table rows -->
<div class="row">
  <div class="col-11">
    <div class="card-body">
      <x-alert />
      {!! Form::model($road, ['route' => ['roads.update', $road->id], 'method' => 'patch']) !!}
      <div class="row">
        @include('admin.roads.fields')

        {{-- Orders Sections --}}
        <div class="card">
          <h5 class="card-header"> @lang('Select Orders') </h5>
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th> @lang("Refrence No") </th>
                  <th> @lang("Customer") </th>
                  <th> @lang("Status") </th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($orders as $item)
                  <tr>
                    <td>
                      <input @checked($myOrders->contains($item->id)) class="form-check-input" type="checkbox" name="orders[]" value="{{ $item->id }}">
                    </td>
                    <td>
                      {{ $item->reference_no }}</td>
                    <td> {{ $item->customer->name }} </td>
                    <td> {{ $item->status }} </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        {{-- End of orders sections --}}
      </div>

      {!! Form::close() !!}
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!--/ Hoverable Table rows -->

@endsection
