<div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">{{ $title }} </h5>
      </div>
      <div class="card-body">
    
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">@lang("Name")</label>
            <div class="col-sm-10">
                {!! Form::text('name', null,  ['required','class' => 'form-control','placeholder'=>  trans("Name")]) !!}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("Driver")</label>
            <div class="col-sm-10">
                {!! Form::select('driver_id',$drivers, null, ['required','class' => 'select2 form-control']) !!}
          </div>
          
          <div class="row justify-content-end">
            <div class="col-sm-10">
                <button class="btn btn-outline-primary m-2" >
                    <i class='bx bx-save' style="font-size: 1.5rem"></i>
                    @lang("Save") 
                  </button>
            </div>
          </div>
      </div>
    </div>
  </div>

