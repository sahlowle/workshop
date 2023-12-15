@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Orders") /</span> {{ $title }}
</h4>

<!-- Hoverable Table rows -->
<div class="card">
  <h5 class="card-header">
    <i class="bx bxs-calendar-check"></i>
    {{ $title }}
  </h5>


  <div class="table-responsive text-nowrap p-4">
    <table class="table table-hover datatable">
      <thead>
        <tr>
          <th>#</th>
          <th> @lang("Refrence No") </th>
          <th> @lang("Customer") </th>
          <th> @lang("Status") </th>
          <th> @lang("Due Amount") </th>
          <th> @lang("Date") </th>
          <th> @lang("Actions") </th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($data as $item)
        <tr>
          <td> {{ $loop->index + 1 }}  </td>
          <td> {{ $item->reference_no }}  </td>
          <td> {{ $item->customer->name }}  </td>
          <td> 
            <i class='bx bxs-circle {{ $item->status_color }}'></i>
            {{ $item->status_name }}
          </td>
          <td> {{ $item->total - $item->paid_amount }}  </td>
          <td>
            {{ $item->created_at->diffForHumans() }}
            |
            {{ $item->created_at->format('Y-M-d') }}
        </td>
          <td>
            <a class="btn btn-show btn-sm pl-1" href="{{ route('orders.show',$item->id) }}">
              <i class='bx bx-show' style="font-size: 1.2rem"></i>
              @lang('Show')
            </a>

          </td>
        </tr>
        @empty
        <tr class="no-data">
          <td colspan="7"> <h2> @lang("Data not found") </h2> </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="m-3">
    {{ $data->links() }}
  </div>
</div>
<!--/ Hoverable Table rows -->

@endsection
