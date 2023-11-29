



<div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"> {{ $title }} </h5>
      </div>
      <div class="card-body">
    
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">@lang("Name")</label>
            <div class="col-sm-10">
                {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("Name")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">@lang("Company name")</label>
            <div class="col-sm-10">
                {!! Form::text('company_name', null,  ['class' => 'form-control','placeholder'=>  trans("Company name")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("Email")</label>
            <div class="col-sm-10">
                {!! Form::text('email', null,  ['class' => 'form-control','placeholder'=>  trans("Email")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("Phone")</label>
            <div class="col-sm-10">
                {!! Form::tel('phone', null,  ['required','class' => 'form-control number','placeholder'=>  trans("phone must be 12 number")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("Address")</label>
            <div class="col-sm-10">
                {!! Form::text('address', null,  ['readonly','class' => 'form-control','id'=>'address','placeholder'=>  trans("Select Address from map")]) !!}
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("City")</label>
            <div class="col-sm-10">
                {!! Form::text('city', null,  ['id'=>'city','class' => 'form-control','placeholder'=>  trans("City")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("Postal Code")</label>
            <div class="col-sm-10">
                {!! Form::text('postal_code', null,  ['id'=>'postal_code','class' => 'form-control','placeholder'=>  trans("Postal Code")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">@lang("Part of building")</label>
            <div class="col-sm-10">
                {!! Form::text('part_of_building', null,  ['class' => 'form-control','placeholder'=>  trans("Part of building")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("Zone Area")</label>
            <div class="col-sm-10">
                {!! Form::text('zone_area', null,  ['id'=>'zone_area','class' => 'form-control','placeholder'=>  trans("Zone Area")]) !!}
            </div>
          </div>

          
            <div class="mb-3">
              <hr>
              
              @php
              $lat = 52.520008;
              $lng = 13.404954;
              
              if (isset($user)) {
                    $lat = $user->lat;
                    $lng = $user->lng;
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

