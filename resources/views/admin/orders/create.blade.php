@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Orders") /</span> {{ $title }}
</h4>

<!-- Hoverable Table rows -->
<div class="row">
  <div class="col-12">
    <div class="card-body">
        <x-alert/>
      {!! Form::open(['route' => 'orders.store']) !!}
      <div class="row">
        @include('admin.orders.fields')
      </div>
      {!! Form::close() !!}
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!--/ Hoverable Table rows -->

@endsection

@push('datetimejs')
    <script>

function getTime(selected_date) {
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
      hours12:false,
      allowTimes: data.data,
      timepicker: timepicker,
    });

  });
}
    
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
    
    
    @if (count($errors) > 0)
  
  var visit_date =  "{{ old('visit_date') }}";

  if (visit_date) {
    getTime(visit_date);
  }

  var visit_time =  "{{ old('visit_time') }}";
  if(visit_time)
  $('#visit_time').val(visit_time);

  @endif

    </script>
@endpush
