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

        @if ($order->status == 3 && $order->type == 1)
            
       
        
        <button type="button" class="btn btn-outline-dark  btn-sm pl-1"  data-bs-toggle="modal" data-bs-target="#exampleModal{{ $order->id }}" data-bs-whatever="@mdo">
          <i class='bx bxs-cog'></i>
          @lang('Make as drop-off')
        </button>

        <div class="modal fade" id="exampleModal{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                  <i class='bx bxs-cog'></i>
                  @lang('Make as drop-off')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('orders.drop.add',$order->id) }}" >
                  @csrf
                  <div class="row">
                    <div class="col-4">
                      <h4> @lang('Customer Adresse') </h4>

                      <div class="mb-2">

                        <div class="card-body">

                          <div class="">
                            <label class="form-label" for="basic-default-name"> @lang('Company Name') </label>
                            <input value="{{ $order->customer->company_name }}" disabled class="form-control" type="text" >
                          </div>

                          <div>
                            <label class="form-label" for="basic-default-name"> @lang('Name') </label>
                            <input value="{{ $order->customer->name }}" disabled  class="form-control" type="text" >  
                          </div>

                          <div>
                            <label class="form-label" for="basic-default-name"> @lang('Address') </label>
                            <input value="{{ $order->customer->address }}" disabled  class="form-control" type="text" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Postal Code') </label>
                            <input value="{{ $order->customer->postal_code }}" disabled  class="form-control" type="number" min="1" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Phone') </label>
                            <input value="{{ $order->customer->phone }}" disabled  class="form-control" type="number" min="1" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Telephone') </label>
                            <input value="{{ $order->customer->telephone }}" disabled  class="form-control" type="number" min="1" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Part Of Buliding') </label>
                            <input value="{{ $order->customer->part_of_building }}" disabled  class="form-control" type="text">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-4">
                      <h4> @lang('Leist Adresse') </h4>

                      <div class="mb-2">

                        <div class="card-body">

                          <div class="">
                            <label class="form-label" for="basic-default-name"> @lang('Company Name') </label>
                            <input value="{{ old('company_name') }}" class="form-control" placeholder="@lang('Company Name')" name="company_name" type="text" >
                          </div>

                          <div>
                            <label class="form-label" for="basic-default-name"> @lang('Name') </label>
                            <input placeholder="@lang('Name')" name="name"  value="{{ old('name') }}" class="form-control" type="text" >  
                          </div>

                          <div>
                            <label class="form-label" for="basic-default-name"> @lang('Address') </label>
                            <input placeholder="@lang('Address')" name="address"  value="{{ old('address') }}" class="form-control" type="text" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Postal Code') </label>
                            <input placeholder="@lang('Postal Code')" name="postal_code"  value="{{ old('postal_code') }}" class="form-control" type="number" min="1" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Phone') </label>
                            <input placeholder="@lang('Phone')" name="phone"  value="{{ old('phone') }}" class="form-control" type="number" min="1" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Telephone') </label>
                            <input placeholder="@lang('Telephone')" name="telephone"  value="{{ old('telephone') }}" class="form-control" type="number" min="1" >
                          </div>

                          <div >
                            <label class="form-label" for="basic-default-name"> @lang('Part Of Buliding') </label>
                            <input placeholder="@lang('Part Of Buliding')" name="part_of_building"  value="{{ old('part_of_building') }}" class="form-control" type="text">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="mb-2">

                        <div class="card-body">
                          <div class="row mb-3">
                            <h2 style="font-size: 1.2rem; margin-bottom: 10px">
                              @lang("With New Route") ?
                            </h2>
                            <div class="col-sm-10">
                              <span style="font-size: 1rem; margin-bottom: 10px">
                                <input name="with_route"  value="1" type="radio" required>
                                @lang('Yes')
                              </span>
                              <br>
                              <span style="font-size: 1rem;">
                                <input name="with_route"  value="0" type="radio" required>
                                 @lang('No')
                              </span>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label class=" col-form-label" for="basic-default-name">@lang("Visit Date")</label>
                            <div class="col-sm-10">
                              {!! Form::text('visit_date', null, [
                                'id'=>'visit_date','required',
                                'class' => 'form-control customDate',
                                'min' => $order->visit_time->format('Y-m-d'),
                                'placeholder'=> trans("Visit date")
                                ]) !!}
                            </div>
                          </div>
                    
                          <div class="row mb-3">
                            <label class=" col-form-label" for="basic-default-name">@lang("Visit Time")</label>
                            <div class="col-sm-10">
                              {!! Form::text('visit_time', null, ['readonly'=>true,'id'=>'visit_time','required','class' => 'form-control','placeholder'=> trans("Visit time")]) !!}
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label class=" col-form-label"> @lang('Guarantee') </label>
                            <div class="col-sm-10">
                              <select name="guarantee_id" class="form-control" required>

                                <option value="">
                                  @lang('Select..')
                                </option>

                                @foreach ($guarantees as $item)
                                <option value=" {{ $item->id }}">
                                  {{ $item->name }}
                                </option>
                                @endforeach

                              </select>
                            </div>
                          </div>

                          <div class="row justify-content-end">
                            <div class="col-sm-10">
                              <button class="btn btn-outline-primary m-2" type="submit">
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

        @endif
        @push('datetimejs')
              <script>
                $('#visit_date').change(function () {
                  var selected_date = $("#visit_date").val()
                  var url = "/api/orders/available/time/?selected_date=" + selected_date;
                  $('#visit_time').datetimepicker('destroy');
                  $.get(url, function (data, status) {

                    var timepicker = true;

                    if (data.data.length == 0) {
                      timepicker = false;
                    }

                    $('#visit_time').val('');

                    $('#visit_time').datetimepicker({
                      datepicker: false,
                      format: 'H:i',
                      allowTimes: data.data,
                      timepicker: timepicker,
                    });

                  });

                });
              </script>
        @endpush
        
       
        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                  <i class='bx bxs-cog'></i>
                  @lang('Add new price')
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
                              <input value="{{ old('quantity') }}"  class="form-control" placeholder="@lang('Quantity')" name="quantity" type="number" min="1" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company"> @lang('Price') </label>
                            <div class="col-sm-10">
                              <input value="{{ old('price') }}" class="form-control" placeholder="@lang('Price')" name="price" type="number" min="1" required>
                            </div>
                          </div>


                          <div class="row justify-content-end">
                            <div class="col-sm-10">
                              <button class="btn btn-outline-primary m-2">
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

        
        @if ( $order->road)              
        <a class="btn btn-outline-dark  btn-sm pl-1" target="_blank" href="{{ route('orders.print.pdf', $order->id) }}">
          <i class='bx bx-printer' style="font-size: 1.2rem"></i>
          @lang('Print Pdf')
        </a>

        {{-- <a class="btn btn-outline-dark  btn-sm pl-1" href="{{ route('orders.send.invoice',$order->id) }}">
          <i class='bx bx-mail-send' style="font-size: 1.2rem"></i>
          @lang('Send Invoice')
        </a> --}}

        @endif

      @if ($order->payment_way == 3 && $order->is_paid == false)

        <button class="btn btn-outline-dark  btn-sm pl-1" data-bs-toggle="modal" data-bs-target="#payModal" data-bs-whatever="@mdo">
          <i class='bx bx-credit-card-alt' style="font-size: 1.2rem"></i>
          @lang('Change payment status')
        </button>
        
      @endif

        <div class="modal fade" id="payModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                  <i class='bx bxs-cog'></i>
                  @lang('Change status payment')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('orders.add-payment',$order->id) }}" >
                  @csrf
                  <div class="row">
                    <div class="col-xxl">
                      <div class="mb-2">

                        <div class="card-body">

                          <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name"> @lang('Due amount') </label>
                            <div class="col-sm-10">
                              <input value="{{ $order->total - $order->paid_amount }}" readonly class="form-control" placeholder="@lang('Due amount')" name="amount" type="number" min="1" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang('Payment way')</label>
                            <div class="col-sm-10">
                              <select name="payment_way" class="form-control">
                                <option value=""> @lang('Select') </option>

                                @foreach (paymentMethods() as $key => $item)
                                    <option value="{{ $key }}"> {{ $item }} </option>
                                @endforeach

                              </select>
                            </div>
                          </div>

                          <div class="row justify-content-end">
                            <div class="col-sm-10">
                              <button class="btn btn-outline-primary m-2">
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

      </div>
    </div>
  </div>
</div>

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">
        <i class='bx bxs-info-circle'></i>
        @lang('Order Info') 
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false" tabindex="-1">
        <i class='bx bxs-box'></i>
        @if ($order->type == 3)
           @lang('Drop-off Info') 
        @else
          @lang('Pickup Info')
        @endif
         
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false" tabindex="-1">
        <i class='bx bxs-credit-card-alt'></i>
        @lang('Payment Info') 
      </button>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
      <div class="row">
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
                          <span > {{ $order->guarantee? $order->guarantee->name : "N\A" }} </span>
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
                          @lang("Additional Info")
                          <span>{{ $order->additional_info ? $order->additional_info : "N\A" }} </span>
                      </li>
  
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Address")    <span>{{ $order->address }}</span>
                      </li>
  
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Floor Number")
                          <span>{{ $order->floor_number ? $order->floor_number : "N\A"}} </span>
                      </li>
  
                      {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Apartment Number")   <span>{{ $order->apartment_number }} </span>
                      </li> --}}
  
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang("Max Maintenance Price")
                        <span>
                           {{ $order->max_maintenance_price ? number_format($order->max_maintenance_price,0)  : "N\A" }} €
                          </span>
                      </li>
  
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Vat")   <span>{{ $order->vat ? number_format($order->vat,2) : 0}} € </span>
                      </li>
  
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Subtotal")   <span>{{ $order->subtotal ? number_format($order->subtotal,2) :0 }} € </span>
                      </li>
  
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Total")   <span>{{ $order->total ? number_format($order->total,2) : 0 }} € </span>
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
                              @endif
                          </span>
                      </li>
  
                      @if ($order->is_paid)
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Payment Method")
                          <span>{{ $order->payment_method }} </span>
                      </li>
                      @endif
  
                      @if ($order->is_paid && $order->payment_way == 1 && ! is_null($order->payment_file) ) 
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
                              {{ $order->payment_id ? $order->payment_id : "N\A"}}
                          </span>
                      </li>
                      @endif
  
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                          @lang("Paid amount")   
                          <span>
                              {{ $order->paid_amount? number_format($order->paid_amount,2) : 0 }} €
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
                  @else
                  <span>
                    @lang('Location not set')
                  </span>
                  @endif
                  
              </div>
        
            </div>
  
          <div class="card mb-4">
            <div class="card-header">
              <h4 class="card-title m-0 h4">
                <i class='bx bx-info-circle'></i>
                @lang("Customer details"):
              </h4>
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
              
              @if ($order->customer->email)
              <p class=" mb-1"> <i class='bx bx-envelope'></i>: {{ $order->customer->email }} </p>
              @endif
              @if ($order->order_phone_number)
              <p class=" mb-0"> <b> @lang('Order phone') </b> : {{ $order->order_phone_number }}</p>
              @endif

              @if ($order->customer->telephone)
              <p class=" mb-0"> <b> @lang('Telephone') </b> : {{ $order->customer->telephone }}</p>
              @endif

              <p class=" mb-0"> <b> @lang('Postal Code') </b> : {{ $order->postal_code ? $order->postal_code : "N\A"}} </p>
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
  
              <a target="_blank" href="https://maps.google.com/?q={{ urlencode($order->address) }}" class="btn btn-primary" >
                  <i class='bx bxs-map'></i>
                  @lang('Show In Map')
              </a>
            </div>
      
          </div>
         
      </div>
      </div>
    </div>

    <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
      <div class="row">

        @php
          if ($order->type==3) {
             $mainOrder = $order;
             $order = \App\Models\Order::where('reference_no',$order->pickup_order_ref)->first();
          }
        @endphp

    @if (isset($mainOrder) && ! is_null($mainOrder->pickupAddress))
      {{-- list info section --}}
       <div class="col-lg-12">
         <br>
         <div class="card">
           <h5 class="card-header">
             <i class='bx bx-file'></i>
             @lang('Leist. Adresse')
           </h5>
           <div class="table-responsive text-nowrap p-4">
             <table class="table table-hover">
               <thead>
                 <tr>
                   <th> @lang("Name") </th>
                   <th> @lang("Company name") </th>
                   <th> @lang("Address") </th>
                   <th> @lang("Postal Code") </th>
                   <th> @lang("Phone") </th>
                   <th> @lang("Telephone") </th>
                   <th> @lang("Part of building") </th>
                 </tr>
               </thead>
               <tbody class="table-border-bottom-0">

                 @if($mainOrder->pickupAddress)
                   <tr>
                     <td>
                       {{ $mainOrder->pickupAddress->name ? $mainOrder->pickupAddress->name : "N\A" }}
                     </td>
                     <td>
                       {{ $mainOrder->pickupAddress->company_name ? $mainOrder->pickupAddress->company_name : "N\A" }}
                     </td>
                     <td>
                       {{ $mainOrder->pickupAddress->address ? $mainOrder->pickupAddress->address : "N\A" }}
                     </td>
                     <td>
                       {{ $mainOrder->pickupAddress->postal_code ? $mainOrder->pickupAddress->postal_code : "N\A" }}
                     </td>
                     <td>
                       {{ $mainOrder->pickupAddress->phone ? $mainOrder->pickupAddress->phone : "N\A" }}
                     </td>
                     <td>
                       {{ $mainOrder->pickupAddress->telephone ? $mainOrder->pickupAddress->telephone : "N\A" }}
                     </td>
                     <td>
                       {{ $mainOrder->pickupAddress->part_of_building ? $mainOrder->pickupAddress->part_of_building : "N\A" }}
                     </td>
                     <td>
                   </tr>
                 @else
                   <tr class="no-data">
                     <td colspan="7">
                       <h2> @lang("Data not found") </h2>
                     </td>
                   </tr>
                 @endif
               </tbody>
             </table>
           </div>
         </div>
       </div>

    @endif

        {{-- list info section --}}
        <div class="col-lg-6">
          <br>
          <div class="card">
            <h5 class="card-header">
              <i class='bx bx-file'></i>
              @lang('Items')
              
                @if($order->status == 3)
                  <button type="button" style="float: right" class="btn btn-outline-dark  btn-sm pl-1"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                    <i class='bx bxs-cog'></i>
                    @lang('Add new price')
                  </button>
                @endif

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
                        @if (isset($mainOrder) && $mainOrder->type == 3 && $mainOrder->status ==4)

                        @elseif(isset($order) && $order->status ==4)
                        @else
                          <button class="btn btn-outline-danger btn-sm pl-1"
                            onclick="deleteForm('deleteForm{{ $item->id }}')">
                            <i class="bx bx-trash me-1"></i>
                            @lang('Delete')
                              <form id="deleteForm{{ $item->id }}"
                                action="{{ route('orders.delete-item',$item->id) }}"
                                method="POST">
                                @method("DELETE")
                                @csrf
                              </form>
                          </button>
                        @endif
                        
                        
                      </td>
                    </tr>
                  @empty
                    <tr class="no-data">
                      <td colspan="4">
                        <h2> @lang("Data not found") </h2>
                      </td>
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
              <i class='bx bx-file'></i>
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
                  @forelse($order->files as $item)
                    <tr>
                      <td> {{ $loop->index + 1 }} </td>
                      <td> {{ \Illuminate\Support\Str::limit($item->file_name,15,'...')  }} </td>
                      <td>
                        <a class="btn btn-primary" href="{{ $item->full_path }}" download>
                          <i class='bx bx-download'></i>
                          @lang('Download File')
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr class="no-data">
                      <td colspan="4">
                        <h2> @lang("Data not found") </h2>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- Devices section --}}
        <div class="col-lg-6">
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
                    <th> @lang("Name") </th>
                    <th> @lang('Selected') </th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0 ">

                  @forelse($devices as $item)
                    <tr>
                      <td> {{ $item->name }} </td>
                      <td>
                        @if($order->devices->contains('id',$item->id))
                          <i class="text-success bx bx-check-circle" style="font-size: 2rem"></i>
                        @else
                          <i class="text-danger bx bx-x-circle" style="font-size: 2rem"></i>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr class="no-data">
                      <td colspan="4">
                        <h2> @lang("Data not found") </h2>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- Questions section --}}
        <div class="col-lg-6">
          <br>
          <div class="card">
            <h5 class="card-header">
              <i class='bx bx-file'></i>
              @lang('Notes')
            </h5>
            <div class="table-responsive text-nowrap p-4">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th> @lang("Name") </th>
                    <th> @lang('Selected') </th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0 ">

                  @forelse($questions as $item)
                    <tr>
                      <td> {{ $item->name }} </td>
                      <td>
                        @if($order->questions->contains('id',$item->id))
                          <i class="text-success bx bx-check-circle" style="font-size: 2rem"></i>
                        @else
                          <i class="text-danger bx bx-x-circle" style="font-size: 2rem"></i>
                        @endif

                      </td>
                    </tr>
                  @empty
                    <tr class="no-data">
                      <td colspan="4">
                        <h2> @lang("Data not found") </h2>
                      </td>
                    </tr>
                  @endforelse

                  <tr>
                    <td> @lang("Is amount received") </td>
                    <td>
                      @if($order->is_amount_received)
                        <i class='text-success bx bx-check-circle' style="font-size: 2rem"></i>
                      @else
                        <i class='text-danger bx bx-x-circle' style="font-size: 2rem"></i>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td> @lang("Is customer confirm") </td>
                    <td>
                      @if($order->is_customer_confirm)
                        <i class='text-success bx bx-check-circle' style="font-size: 2rem"></i>
                      @else
                        <i class='text-danger bx bx-x-circle' style="font-size: 2rem"></i>
                      @endif
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
      <div class="row">
        {{-- Payments section --}}
        <div class="col-lg-12">
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
                    <th> @lang("Paid Amount") </th>
                    <th> @lang("Payment method") </th>
                    <th> @lang("Payment Id") </th> 
                    <th> @lang("Payment Date") </th> 
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0 ">
                   @isset($mainOrder)
                       @foreach ($mainOrder->payments as $item)
                       <tr>
                        <td> {{ number_format($item->paid_amount,2) }} € </td>
                        <td> {{ $item->payment_method }} </td>
                        <td> {{ $item->payment_id ? $item->payment_id : "N\A"}} </td>
                        <td> {{ $item->created_at->format('d.m.Y H:i')}} </td>
                      </tr>
                       @endforeach
                   @endisset

                   @isset($order)
                       @foreach ($order->payments as $item)
                       <tr>
                        <td> {{ number_format($item->paid_amount,2) }} € </td>
                        <td> {{ $item->payment_method }} </td>
                        <td> {{ $item->payment_id ? $item->payment_id : "N\A"}} </td>
                        <td> {{ $item->created_at->format('d.m.Y H:i')}} </td>
                      </tr>
                       @endforeach
                   @endisset

                   @if(isset($mainOrder))
                      @if ($order->payments->isEmpty() && $mainOrder->payments->isEmpty())
                         <tr class="no-data">
                           <td colspan="4">
                             <h2> @lang("Data not found") </h2>
                           </td>
                         </tr>
                      @endif
                   @else
                      @if ($order->payments->isEmpty())
                      <tr class="no-data">
                        <td colspan="4">
                          <h2> @lang("Data not found") </h2>
                        </td>
                      </tr>
                   @endif
                  @endif

                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="row">
  






    
    



    

    
</div>



@endsection
