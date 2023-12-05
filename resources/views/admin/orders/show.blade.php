@extends('layouts/contentNavbarLayout')

@section('title', $title)



@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Orders") /</span> {{ $title }}
</h4>

<div class="row">
  <x-alert/>
    <div class="col-lg-8">
        <div class="container p-2">
          <div class="">  

            <button type="button" class="btn btn-outline-dark  btn-sm pl-1"  data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
              <i class='bx bxs-cog'></i>
              @lang('Add new item')
            </button>


            <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                      <i class='bx bxs-cog'></i>
                      @lang('Add new item')
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{ route('orders.add-item',$order->id) }}" >
                      @csrf
                      <div class="row">
                        <div class="col-xxl">
                          <div class="mb-2">

                            <div class="card-body">

                              <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name"> @lang('Title') </label>
                                <div class="col-sm-10">
                                  <input value="{{ old('title') }}" class="form-control" placeholder="@lang('Title')" name="title" type="text" required>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">@lang('Quantity')</label>
                                <div class="col-sm-10">
                                  <input value="{{ old('quantity') }}"  class="form-control" placeholder="@lang('Quantity')" name="quantity" type="number" required>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">@lang('Price')</label>
                                <div class="col-sm-10">
                                  <input value="{{ old('price') }}" class="form-control" placeholder="12 Eur" name="price" type="number" required>
                                </div>
                              </div>


                              <div class="row justify-content-end">
                                <div class="col-sm-10">
                                  <button class="btn btn-outline-primary m-2"
                                    href="http://localhost:8000/admin/users/create">
                                    <i class="bx bx-save" style="font-size: 1.5rem"></i>
                                    Save
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>

            
            @if ( $order->driver)              
            <a class="btn btn-outline-dark  btn-sm pl-1" href="{{$order->pdf_link }}">
              <i class='bx bx-printer' style="font-size: 1.2rem"></i>
              @lang('Print Pdf')
            </a>

            <a class="btn btn-outline-dark  btn-sm pl-1" href="{{ route('orders.send.invoice',$order->id) }}">
              <i class='bx bx-mail-send' style="font-size: 1.2rem"></i>
              @lang('Send Invoice')
            </a>
            @endif

          </div>
        </div>
    </div>
   


    <div class="col-lg-8">
        <div class="card border--dark">
            <h5 class="card-header bg--dark">
                @lang('Order Information')
            </h5>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Reference No")
                        <span class="fw-bold"> {{ $order->reference_no }} </span>
                    </li>
                    @if ($order->type == 3)   
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Pickup Reference No")
                        <span class="fw-bold"> {{ $order->pickup_order_ref }} </span>
                    </li>
                    @endif

                    @if ($order->type == 3)   
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Guarantee")
                        <span class="fw-bold"> {{ $order->guarantee }} </span>
                    </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      @lang("Visit time")
                      <span>
                        {{ $order->visit_date }}
                        |
                        {{ $order->order_visit_time }} 
                      </span>
                  </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Status")
                        <span >
                            <i class='bx bxs-circle {{ $order->status_color }}'></i>
                            {{ $order->status_name }}
                            |
                            {{ $order->type_name }}
                        </span>
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

                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Apartment Number")   <span>{{ $order->apartment_number }} </span>
                    </li> --}}

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      @lang("Max Maintenance Price")   <span>{{ $order->max_maintenance_price }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Vat")   <span>{{ $order->vat }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Subtotal")   <span>{{ $order->subtotal }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Total")   <span>{{ $order->total }} </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Paid")
                        <span> 
                            @if ($order->is_paid)
                            <i class='text-success bx bx-check-circle' style="font-size: 2rem"></i>
                            @lang('Paid')
                            @elseif ($order->payment_way == 3)
                            <i class='text-primary bx bx-time' style="font-size: 2rem"></i>
                            @lang('Pay Later')
                            @else
                            <i class='text-danger bx bx-x-circle' style="font-size: 2rem"></i>
                            @lang('Un Paid')
                            @endif
                        </span>
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

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Paid amount")   
                        <span>
                            {{ $order->paid_amount }}
                        </span>
                    </li>


                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      @lang("Is amount received")
                      <span> 
                          @if ($order->is_amount_received)
                          <i class='text-success bx bx-check-circle' style="font-size: 2rem"></i>
                          @else
                          <i class='text-danger bx bx-x-circle' style="font-size: 2rem"></i>
                          @endif
                      </span>
                  </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      @lang("Is customer confirm")
                      <span> 
                          @if ($order->is_customer_confirm)
                          <i class='text-success bx bx-check-circle' style="font-size: 2rem"></i>
                          @else
                          <i class='text-danger bx bx-x-circle' style="font-size: 2rem"></i>
                          @endif
                      </span>
                  </li>

                    
                    
                    

                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
    
            
            <div class="card-body">
              <div class="p-2">
                <div class="d-flex justify-content-between">
                  <h6 class="font-weight-bold"> <b> @lang('Problem Summary'): </b> </h6>
                </div>
                <span>
                  @if($order->problem_summary )
                    {{ $order->problem_summary }}
                  @else
                    N\A
                  @endif
                </span>
              </div>
              <hr>

              <div class="p-2">
                <div class="d-flex justify-content-between">
                  <h6 class="font-weight-bold"> <b> @lang('Information'): </b> </h6>
                </div>
                <span>
                  @if($order->information )
                    {{ $order->information }}
                  @else
                    N\A
                  @endif
                </span>
              </div>
              <hr>
                <div class="p-2">
                  <div class="d-flex justify-content-between">
                    <h6 class="card-title m-0"> <b>  @lang('Technician Report'): </b> </h6>
                </div>

                <span>
                  @if ($order->report)
                  {{ $order->report }}   
                @else
                    N\A
                @endif
                </span>

                <hr>
                </div>
                <div class="d-flex justify-content-between">
                    <h6 class="card-title m-0"> <b> @lang('Current Technician Location'):  </b></h6>
                </div>
                <br>
                @if ($order?->road?->driver && $order->road->driver->lat && $order->road->driver->lng)

                @php
                    $driver_lat = $order->road->driver->lat;
                    $driver_lng = $order->road->driver->lng;
                @endphp
                
                <a target="_blank" href="https://maps.google.com/?q={{ $order->road->driver->lat }},{{ $order->road->driver->lng }}" class="btn btn-sm btn-primary" >
                  <i class='bx bxs-map'></i>
                  @lang('Show Technician Location')
                </a> 
                @endif
                
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
            <p class=" mb-0"> <b> @lang('Postal Code') </b> : {{ $order->postal_code }}</p>
            <p class=" mb-0"> <b> @lang('Zone Area') </b> : {{ $order->zone_area ? $order->zone_area : "N\A" }}</p>
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

    {{-- items section  --}}
    <div class="col-lg-7">
      <br>
      <div class="card">
        <h5 class="card-header">
          <i class='bx bx-file'></i>
          @lang('Items')
          <button type="button" style="float: right" class="btn btn-outline-dark  btn-sm pl-1"  data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
            <i class='bx bxs-cog'></i>
            @lang('Add new item')
          </button>
        </h5>
       
        <div class="table-responsive text-nowrap p-4">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th> @lang("Title") </th>
                <th> @lang("Quantity") </th>
                <th> @lang("Price") </th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0 ">

              @forelse($order->items as $item)
                <tr>
                  <td> {{ $loop->index + 1 }} </td>
                  <td> {{ $item->title }} </td>
                  <td> {{ $item->quantity }} </td>
                  <td> {{ $item->price }} </td>
                  <td>
                    <button class="btn btn-outline-danger btn-sm pl-1"
                      onclick="deleteForm('deleteForm{{ $item->id }}')">
                      <i class="bx bx-trash me-1"></i>
                      @lang('Delete')
                        <form id="deleteForm{{ $item->id }}"
                          action="{{ route('orders.delete-item',$item->id) }}" method="POST">
                          @method("DELETE")
                          @csrf
                        </form>
                    </button>
                  </td>
                </tr>
                @empty
                <tr class="no-data">
                  <td colspan="4"> <h2> @lang("Data not found") </h2> </td>
                </tr>
                @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Devices section  --}}
    <div class="col-lg-5">
      <br>
      <div class="card">
        <h5 class="card-header">
          <i class='bx bx-file'></i>
          @lang('Devices')
        </h5>
        <div class="table-responsive text-nowrap p-4">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th> @lang("Name") </th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0 ">

              @forelse($order->devices as $item)
                <tr>
                  <td> {{ $loop->index + 1 }} </td>
                  <td> {{ $item->name }} </td>
                    
                </tr>
                @empty
                <tr class="no-data">
                  <td colspan="4"> <h2> @lang("Data not found") </h2> </td>
                </tr>
                @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- files section --}}
    <div class="col-lg-6">
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
                  @forelse ($order->files as $item)
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
                  @empty
                  <tr class="no-data">
                    <td colspan="4"> <h2> @lang("Data not found") </h2> </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
        </div>
    </div>

    {{-- Payments section  --}}
    <div class="col-lg-6">
      <br>
      <div class="card">
        <h5 class="card-header">
          <i class='bx bx-file'></i>
          @lang('Payments')
        </h5>
        <div class="table-responsive text-nowrap p-4">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th> @lang("Paid Amount") </th>
                <th> @lang("Payment method") </th>
                <th> @lang("Payment Id") </th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0 ">

              @forelse($order->payments as $item)
                <tr>
                  <td> {{ $loop->index + 1 }} </td>
                  <td> {{ $item->paid_amount }} </td>
                  <td> {{ $item->payment_method }} </td>
                  <td> {{ $item->payment_id }} </td>
                </tr>
                @empty
                <tr class="no-data">
                  <td colspan="4"> <h2> @lang("Data not found") </h2> </td>
                </tr>
                @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    {{-- Payments section  --}}
    <div class="col-lg-6">
      <br>
      <div class="card">
        <h5 class="card-header">
          <i class='bx bx-file'></i>
          @lang('Questions')
        </h5>
        <div class="table-responsive text-nowrap p-4">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th> @lang("Name") </th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0 ">

              @forelse($order->questions as $item)
                <tr>
                  <td> {{ $loop->index + 1 }} </td>
                  <td> {{ $item->name }} </td>
                @empty
                <tr class="no-data">
                  <td colspan="4"> <h2> @lang("Data not found") </h2> </td>
                </tr>
                @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>


    

    
</div>



@endsection
