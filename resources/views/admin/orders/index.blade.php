@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Orders") /</span> @lang('List')
</h4>

<a class="btn btn-outline-primary m-2" href="{{ route('orders.create') }}">
  <i class='bx bx-plus' style="font-size: 1.5rem"></i>
  @lang("Add Pickup Order") 
</a>

{{-- <a class="btn btn-outline-primary m-2" href="{{ route('orders.drop.create') }}">
  <i class='bx bx-plus' style="font-size: 1.5rem"></i>
  @lang("Add Drop Off Order") 
</a> --}}

<!-- Hoverable Table rows -->
<div class="card">
  <h5 class="card-header">
    <i class="bx bxs-calendar-check"></i>
    {{ $title }}
  </h5>
  <form method="GET" autocomplete="off">
    <div class="row p-4">

      <div class="col-12 pb-4">
        <h4 class="fw-medium d-block"> @lang('Filter order by type') </h4>

        <div class="form-check form-check-inline mt-3">
          <input class="form-check-input" type="radio" name="type" id="inlineRadio4" value="" @checked(request()->isNotFilled('type')) >
          <label class="form-check-label px-2" for="inlineRadio4">
            @lang("All")
          </label>
        </div>

        <div class="form-check form-check-inline mt-3">
          <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="1" @checked(request()->type == 1) >
          <label class="form-check-label px-2" for="inlineRadio1">
            @lang("Pick up")
          </label>
        </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="2" @checked(request()->type == 2) >
          <label class="form-check-label px-2" for="inlineRadio2">
            @lang("On site")
          </label>
        </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="type" id="inlineRadio3" value="3" @checked(request()->type == 3) >
          <label class="form-check-label px-2" for="inlineRadio3">
            @lang("Drop off")
          </label>
        </div>

      </div>

      <div class="col-2">
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-name">@lang("From")</label>
          <div class="col-sm-10">
            <input class="form-control customDate" name="date_from" type="text" value="{{ request()->date_from }}">
          </div>
        </div>
      </div>
      <div class="col-2">
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-name">@lang("To")</label>
          <div class="col-sm-10">
            <input  class="form-control customDate" name="date_to" type="text" value="{{ request()->date_to }}">
          </div>
        </div>
      </div>

      <div class="col-3">
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-name">@lang("Status")</label>
          <div class="col-sm-10">
            <select name="status" class="form-control">
              @foreach (orderStatuses() as $key => $item)
              <option value="{{ $key }}" @selected($key == request()->input('status',-1) ) > {{ $item }} </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="col-3">
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-name">@lang("Search Input")</label>
          <div class="col-sm-10">
            <input class="form-control" name="search_text" type="text" placeholder="@lang('Search Input')" value="{{ request()->search_text }}">
          </div>
        </div>
      </div>

      <div class="col-2">
        <div class="mb-3">
          <label class=" col-form-label" for="basic-default-name"> - </label>
          <div class="col-sm-10">
            <button class="btn btn-primary">
              <i class="bx bx-search"></i>
              @lang('Search')
            </button>
          </div>
        </div>
        
        
      </div>

    </div>
  </form>

  <div class="table-responsive text-nowrap p-4">
    <table class="table table-hover datatable">
      <thead>
        <tr>
          <th>#</th>
          <th> @lang("Refrence No") </th>
          <th> @lang("Maintenance Device") </th>
          <th> @lang("Customer") </th>
          <th> @lang("Technician") </th>
          <th> @lang("Status") </th>
          {{-- <th> @lang("Amount") </th> --}}
          <th> @lang("Visit time") </th>
          <th> @lang("Actions") </th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($data as $item)
        <tr>
          <td> {{ $loop->index + 1 }}  </td>
          <td>
            <a  class="link-primary" href="{{ route('orders.show',$item->id) }}">
              {{ $item->reference_no }}
            </a>
          </td>
          <td> {{ $item->maintenance_device }}  </td>
          <td>
            <p> {{ $item->customer->name }} </p>
            <p> {{ $item->customer->phone ? $item->customer->phone : $item->customer->order_phone_number }} </p>
          </td>
          <td>
            @if ($item->driver)
            <p> {{ $item->driver->name }} </p>
            <p> {{ $item->driver->phone }} </p>
            @else
            N\A
            @endif
          </td>
          <td> 
            <i class='bx bxs-circle {{ $item->status_color }}'></i>
            {{ $item->status_name }}
            |
            {{ $item->type_name }}
          </td>
          {{-- <td> {{ number_format($item->amount, 2) }}  </td> --}}
          <td> {{ $item->visit_time->format('d.m.Y H:i') }}  </td>
          <td>

            <a class="btn btn-show btn-sm pl-1" href="{{ route('orders.show',$item->id) }}">
              <i class='bx bx-show' style="font-size: 1.2rem"></i>
              @lang('Show')
            </a>

            {{-- @if ($order->status != 4)
                
            @endif --}}

            <a class="btn btn-outline-primary btn-sm pl-1" href="{{ route('orders.edit',$item->id) }}">
              <i class='bx bx-edit' style="font-size: 1.2rem"></i>
              @lang('Edit')
            </a>
            @if ($item->status != 4)
            <button  class="btn btn-outline-danger btn-sm pl-1" onclick="deleteForm('deleteForm{{ $item->id }}')">
              <i class="bx bx-trash me-1"></i>
              @lang('Cancel')
              <form id="deleteForm{{ $item->id }}" action="{{ route('orders.destroy',$item->id) }}" method="POST">
                @method("DELETE")
                @csrf
              </form>
            </button>
            @endif

           
          </td>
          {{-- <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('orders.edit',$item->id) }}">
                    <i class="bx bx-edit-alt me-1"></i>
                    @lang('Edit')
                </a>
                
                <button  class="dropdown-item" onclick="deleteForm('deleteForm{{ $item->id }}')">
                  <i class="bx bx-trash me-1"></i>
                  @lang('Delete')
                  <form id="deleteForm{{ $item->id }}" action="{{ route('orders.destroy',$item->id) }}" method="POST">
                    @method("DELETE")
                    @csrf
                </form>
              </button>
              </div>
            </div>
          </td> --}}
        </tr>
        @empty
        <tr class="no-data">
          <td colspan="8"> <h2> @lang("Data not found") </h2> </td>
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
