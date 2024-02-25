@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> {{ $title }}  /</span> @lang('List')
</h4>

<a class="btn btn-outline-primary m-2" href="{{ route('drivers.create') }}">
  <i class='bx bx-plus' style="font-size: 1.5rem"></i>
  @lang("Add New Technician") 
</a>

<a class="btn btn-outline-primary m-2" href="{{ $users->isNotEmpty() ? route('drivers.map-location') : '#' }}" >
  <i class='bx bx-map' style="font-size: 1.5rem"></i>
  @lang("Show all technicians in map") 
</a>

<!-- Hoverable Table rows -->
<div class="card">
  <h5 class="card-header"> {{ $title }} </h5>

  <form action="{{ route('drivers.index') }}" method="GET">
    <div class="row ps-4">

      <div class="col-4">
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
          {{-- <th> @lang("Image") </th> --}}
          <th> @lang("Name") </th>
          <th> @lang("Phone") </th>
          <th> @lang("Orders Count") </th>
          <th> @lang("Actions") </th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($users as $item)
        <tr>
          <td> {{ $loop->index + 1 }}  </td>
          {{-- <td>
            <div class="avatar">
              <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/1.png" alt="Avatar">
            </div>
          </td> --}}
          <td>
            @if ($item->trashed())
              <i class='bx bx-block' style="font-size: 1.2rem; color:red"></i>
            @else
              <i class='bx bx-check-circle' style="font-size: 1.2rem; color:#0d6efd"></i>
            @endif
            {{ $item->name }} 
          </td>
          <td> {{ $item->phone }}  </td>
          <td> {{ $item->orders_count }} </td>


          <td>
            {{-- <a class="btn btn-outline-primary btn-sm pl-1"
              href="{{ route('drivers.show',$item->id) }}">
              <i class='bx bx-show' style="font-size: 1.2rem"></i>
              @lang('Show')
            </a> --}}

            <a class="btn btn-outline-primary btn-sm pl-1"
              href="{{ route('drivers.edit',$item->id) }}">
              <i class='bx bx-edit' style="font-size: 1.2rem"></i>
              @lang('Edit')
            </a>

            @if ($item->trashed())
            <a class="btn btn-show btn-sm pl-1" href="{{ route('drivers.active',$item->id) }}">
              <i class='bx bx-check-circle' style="font-size: 1.2rem"></i>
              @lang('Enable')
            </a>
            @else

            <button  class="btn btn-outline-danger btn-sm pl-1" onclick="deleteForm('deleteForm{{ $item->id }}')">
              <i class="bx bx-trash me-1"></i>
              @lang('Disable')
              <form id="deleteForm{{ $item->id }}" action="{{ route('drivers.destroy',$item->id) }}" method="POST">
                @method("DELETE")
                @csrf
            </form>
          </button>

          @endif


          </td>
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
    {{ $users ->links() }}
  </div>
</div>
<!--/ Hoverable Table rows -->

@endsection
