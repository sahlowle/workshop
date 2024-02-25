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
                  <th> @lang("Maintenance Device") </th>
                  <th> @lang("Customer") </th>
                  <th> @lang("Technician") </th>
                  <th> @lang("Visit Time") </th>
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
                      <a href="{{ route('orders.show',$item->id) }}" class="link-primary">
                        {{ $item->reference_no }}
                      </a>
                    </td>
  
                    <td> {{ $item->maintenance_device }}  </td>
                    <td>
                      <p> {{ $item->customer->name }} </p>
                      <p> {{ $item->customer->phone ? $item->customer->phone : $item->customer->order_phone_number }} </p>
                    </td>
  
                    <td>
                      @if ($item->driver)
                      <p> {{ $item->driver->name }} </p>
                      <p> {{ $item->driver->phone }} </p>
                      @else
                      N\A
                      @endif
                    </td>
  
                    <td> {{ $item->visit_time->format('d.m.Y H:i') }}  </td>
    
                    <td>
                        <i class='bx bxs-circle {{ $item->status_color }}'></i>
                        {{ $item->status_name }}
                    </td>
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
