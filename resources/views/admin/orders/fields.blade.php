<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0">{{ $title }} </h5>
  </div>

  <div class="row card-body">

    <div class="col-6">

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-company">@lang("Customer")</label>
        <div class="col-sm-10">
          {!! Form::select('customer_id',$customers, old('customer_id', null), ['id' => 'customer_id','required','class' => 'select2 form-control','onchange'=>'fillDetatils(event)']) !!}
          <span>
            <a href="{{ route('customers.create') }}" class="btn">
              <i class="bx bx-plus"></i>
              @lang('Add new')
            </a>
          </span>
        </div>
      </div>
      
      

      @if (isset($order) && $order->status == 4 && $order->type ==1)
      @php
           $first_visit = \App\Models\Order::where('pickup_order_ref',$order->reference_no)->first();
      @endphp

      @if ($first_visit && $first_visit->status == 4)

      @else
      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-company">@lang("Status")</label>
        <div class="col-sm-10">
          {!! Form::select('status',editOrderStatusForPickup(), null, ['required','class' => 'select2 form-control']) !!}
        </div>
      </div>

      @endif

      @endif

      @if (isset($order) && $order->type ==3)

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-company">@lang("Guarantee")</label>
        <div class="col-sm-10">
          {!! Form::select('guarantee_id',$guarantees, null, ['required','class' => 'select2 form-control']) !!}
        </div>
      </div>

      @endif

      

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Address")</label>
        <div class="col-sm-10">
          {!! Form::text('address', null, ['id'=>'address','readonly','required','onclick'=>'document.getElementById("googleMap").scrollIntoView({ behavior: "smooth" })','class' => 'form-control','placeholder'=> trans("Select address from map")]) !!}
        </div>
      </div>
      
      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("City")</label>
        <div class="col-sm-10">
          {!! Form::text('city', null, ['id'=>'city','required','class' => 'form-control','placeholder'=> trans("City")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Postal Code")</label>
        <div class="col-sm-10">
          {!! Form::number('postal_code', null, ['id'=>'postal_code','required','class' => 'form-control','placeholder'=> trans("Postal Code")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Zone Area")</label>
        <div class="col-sm-10">
          {!! Form::text('zone_area', null, ['id'=>'zone_area','class' => 'form-control','placeholder'=> trans("Zone Area")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Floor Number")</label>
        <div class="col-sm-10">
          {!! Form::text('floor_number', null, ['class' => 'form-control number','placeholder'=> trans("Floor Number")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Phone")</label>
        <div class="col-sm-10">
          {!! Form::tel('phone', null, ['id'=>'phone','readonly','class' => 'form-control','placeholder'=> trans("Phone")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Other Phone")</label>
        <div class="col-sm-10">
          {!! Form::tel('order_phone_number', null,  ['id'=>'order_phone_number','class' => 'form-control number','placeholder'=>  trans("phone must be 12 number")]) !!}
        </div>
      </div>

      


    </div>
    
    <div class="col-6">
      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Maintenance Device")</label>
        <div class="col-sm-10">
          {!! Form::text('maintenance_device', null, ['required','class' => 'form-control','placeholder'=> trans("Maintenance Device")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Brand")</label>
        <div class="col-sm-10">
          {!! Form::text('brand', null, ['required','class' => 'form-control','placeholder'=> trans("Brand")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Problem Summary")</label>
        <div class="col-sm-10">
          {!! Form::textarea('problem_summary', null, ['required','rows'=>8,'class' => 'form-control','placeholder'=> trans("Description")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Additional Info")</label>
        <div class="col-sm-10">
          {!! Form::text('additional_info', null, ['class' => 'form-control','placeholder'=> trans("Additional Info")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Visit Date")</label>
        <div class="col-sm-10">
          {!! Form::text('visit_date', null, ['id'=>'visit_date','required','class' => 'form-control customDate','placeholder'=> trans("Visit date")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Visit Time")</label>
        <div class="col-sm-10">
          {!! Form::text('visit_time', null, ['readonly'=>true,'id'=>'visit_time','required','class' => 'form-control','placeholder'=> trans("Visit time")]) !!}
        </div>
      </div>
      
    </div>
    

    <div class="col-12">
      <div class="mb-3">
        <hr>
        
        @php
        $lat = 52.520008;
        $lng = 13.404954;
        
        if (isset($order)) {
              $lat = $order->lat;
              $lng = $order->lng;
        }
        @endphp

        <x-map :lat="$lat" :lng="$lng" />

        <hr>
        <div class=" justify-content-end">
          <div class="col-sm-10">
            <button class="btn btn-outline-primary m-2">
              <i class='bx bx-save' style="font-size: 1.5rem"></i>
              @lang("Save")
            </button>
          </div>
        </div>
      </div>
    </div>




  </div>
</div>
@section('page-script')
<script>
  function fillDetatils(event) {
    var selectElement = event.target;
    var id = selectElement.value;
    var url = "/admin/customers/"+id;

    // alert(url);

    $.get(url, function(data, status){
    // alert("Data: " + data + "\nStatus: " + status);

    var phone = data.phone;
    var address = data.address;
    var lat = data.lat;
    var lng = data.lng;

    $('#phone').val(phone);
    // $('#order_phone_number').val(phone);
    $('#address').val(address);
    $('#city').val(data.city);
    $('#postal_code').val(data.postal_code);
    $('#zone_area').val(data.zone_area);
    $('#lat').val(lat);
    $('#lng').val(lng);
  });
  }

  function fillDetatilsByID(id) {
    var url = "/admin/customers/"+id;

    // alert(url);

    $.get(url, function(data, status){
    // alert("Data: " + data + "\nStatus: " + status);

    var phone = data.phone;
    var address = data.address;
    var lat = data.lat;
    var lng = data.lng;

    $('#phone').val(phone);
    // $('#order_phone_number').val(phone);
    $('#address').val(address);
    $('#city').val(data.city);
    $('#postal_code').val(data.postal_code);
    $('#zone_area').val(data.zone_area);
    $('#lat').val(lat);
    $('#lng').val(lng);
  });
  }

  var customer_id =  "{{ request()->customer_id }}";
  $('#customer_id').val(customer_id);

  if (customer_id) {
    fillDetatilsByID(customer_id);
  }

  @if (count($errors) > 0)

  if (customer_id) {
    fillDetatilsByID(customer_id);
  }

  
var customer_id =  "{{ old('customer_id') }}";
$('#customer_id').val(customer_id);

  @endif

</script>
@endsection
