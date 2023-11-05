<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">{{ $title }} </h5>
    </div>
  
    <div class="row card-body">
  
      <div class="col-6">
  
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-company">@lang("Order")</label>
          <div class="col-sm-10">
            {!! Form::select('reference_no',$orders, null, ['required','class' => 'select2 form-control']) !!}
          </div>
        </div>
        

      </div>
      <div class="col-6">
  
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-company">@lang("With New Route") ?</label>
          <div class="col-sm-10">
            @lang('Yes')
            {!! Form::radio('with_route',1, false) !!}
            @lang('No')
            {!! Form::radio('with_route',0, false) !!}
          </div>
        </div>

      </div>

      <div class="col-6">
  
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