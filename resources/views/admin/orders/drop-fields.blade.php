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

        <div class="mb-3">
          <h2 style="font-size: 1.2rem; margin-bottom: 10px">
            @lang("With New Route") ?
          </h2>
          <div class="col-sm-10">
            <span style="font-size: 1rem; margin-bottom: 10px">
              {!! Form::radio('with_route',1) !!}
            @lang('Yes')
            </span>
            <br>
            <span style="font-size: 1rem;">
              {!! Form::radio('with_route',0) !!}
            @lang('No')
            </span>
          </div>
        </div>

      </div>

      <div class="col-6">
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-name">@lang("Visit Date")</label>
          <div class="col-sm-10">
            {!! Form::date('visit_date', null, ['id'=>'visit_date','required','class' => 'form-control','placeholder'=> trans("Visit date")]) !!}
          </div>
        </div>
  
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-name">@lang("Visit Time")</label>
          <div class="col-sm-10">
            {!! Form::text('visit_time', null, ['readonly'=>true,'id'=>'visit_time','required','class' => 'form-control','placeholder'=> trans("Visit time")]) !!}
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

@push('datetimejs')
    <script>
    
    $('#visit_date').change(function(){
      var selected_date = $("#visit_date").val()
      var url = "/api/orders/available/time/?selected_date="+selected_date;
      $('#visit_time').datetimepicker('destroy');
      $.get(url, function(data, status){

        var timepicker = true;

        if (data.data.length == 0) {
          timepicker = false;
        }

        $('#visit_time').val('');

        $('#visit_time').datetimepicker({
          datepicker:false,
          format:'H:i',
          allowTimes:data.data,
          timepicker:timepicker,
        });

      });

    });

    </script>
@endpush