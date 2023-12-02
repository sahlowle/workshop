@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Orders") /</span> {{ $title }}
</h4>

<!-- Hoverable Table rows -->
<div class="row">
  <div class="col-10">
    <div class="card-body">
        <x-alert/>
        {!! Form::model($order, ['route' => ['orders.update', $order->id], 'method' => 'patch']) !!}
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
            allowTimes: data.data,
            timepicker: timepicker,
          });

        });
      }
    
    $('#visit_date').change(function(){
      var selected_date = $("#visit_date").val()
      getTime(selected_date);
    });

    var customer_id = "{{ $order->customer_id }}";
    $("#customer_id").val(customer_id);

    var visit_time = "{{ $order->order_visit_time }}";
    var visit_date = "{{ $order->visit_date }}" ;

    getTime(visit_date);

    setTimeout(() => {
      $("#visit_time").val(visit_time);
    }, 2000);

    </script>
@endpush
