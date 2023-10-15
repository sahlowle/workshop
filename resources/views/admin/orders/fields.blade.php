<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0">{{ $title }} </h5>
  </div>

  <div class="row card-body">

    <div class="col-6">

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Address")</label>
        <div class="col-sm-10">
          {!! Form::text('address', null, ['required','class' => 'form-control','placeholder'=> trans("Address")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-company">@lang("Customer")</label>
        <div class="col-sm-10">
          {!! Form::select('customer_id',$customers, null, ['required','class' => 'select2 form-control']) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-company">@lang("Status")</label>
        <div class="col-sm-10">
          {!! Form::select('status',orderStatus(), null, ['required','class' => 'select2 form-control']) !!}
        </div>
      </div>

     

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Block No")</label>
        <div class="col-sm-10">
          {!! Form::text('block_no', null, ['class' => 'form-control','placeholder'=> trans("Block No")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Phone")</label>
        <div class="col-sm-10">
          {!! Form::text('order_phone_number', null, ['class' => 'form-control','placeholder'=> trans("Phone")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Floor Number")</label>
        <div class="col-sm-10">
          {!! Form::text('floor_number', null, ['class' => 'form-control','placeholder'=> trans("Floor Number")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Apartment Number")</label>
        <div class="col-sm-10">
          {!! Form::text('apartment_number', null, ['class' => 'form-control','placeholder'=> trans("Apartment Number")]) !!}
        </div>
      </div>

    </div>
    
    <div class="col-6">

      {{-- <div class="mb-3">
        <label class=" col-form-label" for="basic-default-company">@lang("Route")</label>
        <div class="col-sm-10">
          {!! Form::select('road_id',$roads, null, ['required','class' => 'select2 form-control']) !!}
        </div>
      </div> --}}

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Description")</label>
        <div class="col-sm-10">
          {!! Form::textarea('description', null, ['required','rows'=>8,'class' => 'form-control','placeholder'=> trans("Description")]) !!}
        </div>
      </div>

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
        <label class=" col-form-label" for="basic-default-name">@lang("Additional Info")</label>
        <div class="col-sm-10">
          {!! Form::text('additional_info', null, ['class' => 'form-control','placeholder'=> trans("Additional Info")]) !!}
        </div>
      </div>

      <div class="mb-3">
        <label class=" col-form-label" for="basic-default-name">@lang("Amount")</label>
        <div class="col-sm-10">
          {!! Form::number('amount', null, ['class' => 'form-control','placeholder'=> trans("Amount")]) !!}
        </div>
      </div>
      
      
    </div>
    

    <div class="col-12">
      <div class="mb-3">
        <hr>
        
        @php
        $lat = 23.8859;
        $lng = 45.0792;
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
