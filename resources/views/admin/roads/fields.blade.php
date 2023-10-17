<div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"> @lang('Route Details') </h5>
      </div>
      <div class="card-body">

          <div class="row mb-3 mt-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">@lang("Technician")</label>
            <div class="col-sm-10">
                {!! Form::select('driver_id',$drivers, null, ['class' => 'select2 form-control']) !!}
          </div>

          <div class="row mt-4">
            <label class="col-sm-2 col-form-label" for="basic-default-name">@lang("Description")</label>
            <div class="col-sm-10">
                {!! Form::textarea('description', null,  ['required','rows'=>3,'class' => 'form-control','placeholder'=>  trans("Description")]) !!}
            </div>
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

