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
