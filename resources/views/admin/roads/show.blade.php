@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Routes") /</span> {{ $title }}
</h4>

<div class="row">

    
    <div class="col-lg-11">
        <div class="card border--dark">
            <h5 class="card-header bg--dark">
                @lang('Route Information')
            </h5>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Refrence No")
                        <span class="fw-bold"> {{ $road->reference_no }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Status")
                        <span >
                            <i class='bx bxs-circle {{ $road->status_color }}'></i>
                            {{ $road->status_name }}
                        </span>
                    </li>

                    @if ($road->driver)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      @lang("Technician")
                      <span>
                        
                      | {{ $road->driver->name }}
                      |
                      {{ $road->driver->phone }}
                      |
                      @if ($road->driver && $road->driver->lat && $road->driver->lng)
                        <a target="_blank" href="https://maps.google.com/?q={{ $road->driver->lat }},{{ $road->driver->lng }}" class="btn btn-sm btn-primary" >
                          <i class='bx bxs-map'></i>
                          @lang('Show Technician Location')
                        </a> 
                        @else
                        <span>
                          @lang('Location not set')
                        </span>
                        @endif
                      </span>
                  </li>
                  @else
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang("Technician")
                    <span>
                      @lang("No Technician")
                    </span>
                  </li>
                  @endif

                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-11">
        <br>
        <div class="card">
            <h5 class="card-header">
                <i class='bx bxs-calendar-check' ></i>
              @lang('Orders')
            </h5>
            <div class="table-responsive text-nowrap p-4">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th> @lang("Maintenance Device") </th>
                        <th> @lang("Customer") </th>
                        <th> @lang("Technician") </th>
                        <th> @lang("Visit Time") </th>
                        <th> @lang("Refrence No") </th>
                        <th> @lang("Status") </th>
                        <th> @lang("Actions") </th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($road->orders as $item)
                      <tr>
                        <td> {{ $loop->index + 1 }}  </td>
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
                          <a href="{{ route('orders.show',$item->id) }}" class="link-primary">
                            {{ $item->reference_no }}
                          </a>
                        </td>
                        <td>
                            <i class='bx bxs-circle {{ $item->status_color }}'></i>
                            {{ $item->status_name }}
                        </td>
                        <td>
                          <a class="btn btn-show btn-sm pl-1" href="{{ route('orders.show',$item->id) }}">
                            <i class='bx bx-show' style="font-size: 1.2rem"></i>
                            @lang('Show')
                          </a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>


    

    
</div>



@endsection
