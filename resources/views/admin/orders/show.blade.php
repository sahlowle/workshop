@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Orders") /</span> {{ $title }}
</h4>

<div class="row">

    
    <div class="col-lg-8">
        <div class="card border--dark">
            <h5 class="card-header bg--dark">
                @lang('Order Information')
            </h5>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Refrence No")
                        <span class="fw-bold"> {{ $order->reference_no }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Status")
                        <span >
                            <i class='bx bxs-circle {{ $order->status_color }}'></i>
                            {{ $order->status_name }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Maintenance Device")   <span> {{ $order->maintenance_device }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Brand")   <span>{{ $order->brand }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Additional Info")        <span>{{ $order->additional_info }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Address")    <span>{{ $order->address }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Block No")       <span>{{ $order->block_no }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Floor Number")      <span>{{ $order->floor_number }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Floor Number")      <span>{{ $order->floor_number }} </span>
                    </li>

                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Apartment Number")   <span>{{ $order->apartment_number }} </span>
                    </li> --}}

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Amount")   <span>{{ $order->amount }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Paid")
                        <span> 
                            @if ($order->is_paid)
                            <i class='text-success bx bx-check-circle' style="font-size: 2rem"></i>
                            @lang('Paid')
                            @else
                            <i class='text-danger bx bx-x-circle' style="font-size: 2rem"></i>
                            @lang('Un Paid')
                            @endif </span>
                    </li>

                    @if ($order->is_paid)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Payment Method")   <span>{{ $order->payment_method }} </span>
                    </li>
                    @endif

                    @if ($order->is_paid && $order->payment_way == 1)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Payment File")   
                        <span>
                            <div>
                                <a class="btn btn-primary" href="{{ $order->payment_file }}" download>
                                    <i class='bx bx-download' ></i>
                                    @lang('Download File')
                                 </a>
                            </div>
                        </span>
                    </li>
                    @endif

                    @if ($order->is_paid && $order->payment_way == 2)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Payment ID")   
                        <span>
                            {{ $order->payment_id }}
                        </span>
                    </li>
                    @endif

                    
                    
                    

                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
    
            
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h6 class="card-title m-0"> @lang('Description'): </h6>
                </div>
                <br>
              {{ $order->description }}

              <hr>
              <br>
                <div class="d-flex justify-content-between">
                    <h6 class="card-title m-0"> @lang('Technician Report'): </h6>
                </div>
                <hr>
                <br>
              {{ $order->report }}

                <div class="d-flex justify-content-between">
                    <h6 class="card-title m-0"> @lang('Current Technician Location'): </h6>
                </div>
                <hr>
                <br>
                <a target="_blank" href="https://maps.google.com/?q={{ $order->road->driver->lat }},{{ $order->road->driver->lng }}" class="btn btn-sm btn-primary" >
                  <i class='bx bxs-map'></i>
                  @lang('Show Technician Location')
                </a> 
            </div>
      
          </div>

        <div class="card mb-4">
          <div class="card-header">
            <h6 class="card-title m-0">@lang("Customer details"): </h6>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-start align-items-center mb-4">
              <div class="avatar me-2">
                <i class="bx bx-user"></i>
              </div>
              <div class="d-flex flex-column">
                <a href="#" class="text-body text-nowrap">
                  <h6 class="mb-0">{{ $order->customer->name }}</h6>
                </a>
                <small class="text-muted"> @lang("Phone"): {{ $order->customer->phone }}</small>
            </div>
            </div>
            <div class="d-flex justify-content-between">
              <h6> <i class='bx bx-info-circle'></i> @lang("Contact info"): </h6>
            </div>
            <br>
            <p class=" mb-1"> <i class='bx bx-envelope'></i>: {{ $order->customer->email }} </p>
            <p class=" mb-0"> <i class='bx bxs-phone'></i>: {{ $order->customer->phone }}</p>
            <p class=" mb-0"> <i class='bx bxs-phone'></i>: {{ $order->order_phone_number }}</p>
          </div>
        </div>
    
        <div class="card mb-4">
    
          <div class="card-header d-flex justify-content-between">
            <h6 class="card-title m-0"> @lang('Address'): </h6>
          </div>
          <div class="card-body">
            {{ $order->address }}

            <br>
            <hr>
            <br>

            <a target="_blank" href="https://maps.google.com/?q={{ $order->lat }},{{ $order->lng }}" class="btn btn-primary" >
                <i class='bx bxs-map'></i>
                @lang('Show In Map')
            </a>
          </div>
    
        </div>
       
    </div>

    <div class="col-lg-8">
        <br>
        <div class="card">
            <h5 class="card-header">
                <i class='bx bx-file' ></i>
              @lang('Files')
            </h5>
            <div class="table-responsive text-nowrap p-4">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th> @lang("File Name") </th>
                    <th> @lang("Download File") </th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  @foreach ($order->files as $item)
                  <tr>
                    <td> {{ $loop->index + 1 }}  </td>
                    <td> {{ $item->file_name }}  </td>
                    <td> 
                        <a class="btn btn-primary" href="{{ $item->full_path }}" download>
                            <i class='bx bx-download' ></i>
                            @lang('Download File')
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
