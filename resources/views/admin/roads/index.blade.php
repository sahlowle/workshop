@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Routes") /</span> @lang('List')
</h4>

<a class="btn btn-outline-primary m-2" href="{{ route('roads.create') }}">
  <i class='bx bx-plus' style="font-size: 1.5rem"></i>
  @lang("Add New Route") 
</a>

<!-- Hoverable Table rows -->
<div class="card">
  <h5 class="card-header"> 
    <i class='bx bx-map-alt' ></i>
    {{ $title }}
  </h5>

  <form method="GET" autocomplete="off">
    <div class="row p-4">

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
              @foreach (roadStatuses() as $key => $item)
              <option value="{{ $key }}" @selected($key == request()->status ) > {{ $item }} </option>
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
          <th> @lang("Technician") </th>
          <th> @lang("Status") </th>
          <th> @lang("Actions") </th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($data as $item)
        <tr>
          <td> {{ $loop->index + 1 }}  </td>
          <td>
            <a  class="link-primary" href="{{ route('roads.show',$item->id) }}">
              {{ $item->reference_no }}
            </a>
          </td>
          <td>
            {{ $item->driver ? $item->driver->name: trans('No Technician') }}
            <br>
            {{ $item->driver ? $item->driver->phone: '' }}
          </td>
          <td> {{ $item->status_name }}  </td>
          <td>
            <a class="btn btn-show btn-sm  pl-1" href="{{ route('roads.show',$item->id) }}">
              <i class='bx bx-show' style="font-size: 1.2rem"></i>
              @lang('Show')
            </a>

            @if ($item->status != 3)
            <a class="btn btn-outline-primary btn-sm pl-1" href="{{ route('roads.edit',$item->id) }}">
              <i class='bx bx-edit' style="font-size: 1.2rem"></i>
              @lang('Edit')
            </a>
            @endif

            <button  class="btn btn-outline-danger btn-sm pl-1" onclick="deleteForm('deleteForm{{ $item->id }}')">
              <i class="bx bx-trash me-1"></i>
              @lang('Delete')
              <form id="deleteForm{{ $item->id }}" action="{{ route('roads.destroy',$item->id) }}" method="POST">
                @method("DELETE")
                @csrf
            </form>
          </button>

           
          </td>
          {{-- <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('roads.edit',$item->id) }}">
                    <i class="bx bx-edit-alt me-1"></i>
                    @lang('Edit')
                </a>
                
                <button  class="dropdown-item" onclick="deleteForm('deleteForm{{ $item->id }}')">
                  <i class="bx bx-trash me-1"></i>
                  @lang('Delete')
                  <form id="deleteForm{{ $item->id }}" action="{{ route('roads.destroy',$item->id) }}" method="POST">
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
          <td colspan="5"> <h2> @lang("Data not found") </h2> </td>
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
