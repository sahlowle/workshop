@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> @lang("Customers") /</span> @lang('List')
</h4>

<a class="btn btn-outline-primary m-2" href="{{ route('customers.create') }}">
  <i class='bx bx-plus' style="font-size: 1.5rem"></i>
  @lang("Add New") 
</a>

<!-- Hoverable Table rows -->
<div class="card">
  <h5 class="card-header">
    <i class="bx bx-happy"></i>
    @lang('Customers')
  </h5>

  <form action="{{ route('customers.index') }}" method="GET">
    <div class="row p-4">

      <div class="col-5">
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
          <th> @lang("Name") </th>
          <th> @lang("Phone") </th>
          <th> @lang("Zone Area") </th>
          <th> @lang("Email") </th>
          <th> @lang("Status") </th>
          <th> @lang("Actions") </th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($users as $item)
        <tr>
          <td> {{ $loop->index + 1 }}  </td>
          <td> {{ $item->name }}  </td>
          <td> {{ $item->phone }}  </td>
          <td> {{ $item->zone_area }}  </td>
          <td> {{ $item->email }}  </td>
          <td>
            @if ($item->trashed())
            <i class="bx bxs-circle text-danger" style="font-size: 2.5rem"></i>
            @else
            <i class="bx bxs-check-circle text-success" style="font-size: 2.5rem"></i>
            
            @endif
          </td>
         
          
          <td>
            {{-- <a class="btn btn-outline-primary btn-sm pl-1" href="{{ route('customers.show',$item->id) }}">
              <i class='bx bx-show' style="font-size: 1.2rem"></i>
              @lang('Show')
            </a> --}}

            <a class="btn btn-outline-primary btn-sm pl-1" href="{{ route('customers.edit',$item->id) }}">
              <i class='bx bx-edit' style="font-size: 1.2rem"></i>
              @lang('Edit')
            </a>

            

            @if ($item->trashed())
            <a class="btn btn-show btn-sm pl-1" href="{{ route('customers.active',$item->id) }}">
              <i class='bx bx-check-circle' style="font-size: 1.2rem"></i>
              @lang('Enable')
            </a>
            @else

            <button  class="btn btn-outline-danger btn-sm pl-1" onclick="deleteForm('deleteForm{{ $item->id }}')">
              <i class="bx bx-trash me-1"></i>
              @lang('Disable')
              <form id="deleteForm{{ $item->id }}" action="{{ route('customers.destroy',$item->id) }}" method="POST">
                @method("DELETE")
                @csrf
            </form>
          </button>

          @endif

           
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="m-3">
    {{ $users ->links() }}
  </div>
</div>
<!--/ Hoverable Table rows -->

@endsection
