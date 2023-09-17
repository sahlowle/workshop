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
  <h5 class="card-header"> @lang('Users') </h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th> @lang("Name") </th>
          <th> @lang("Phone") </th>
          <th> @lang("National Id") </th>
          <th> @lang("Email") </th>
          <th> @lang("Actions") </th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($users as $item)
        <tr>
          <td> {{ $loop->index + 1 }}  </td>
          <td> {{ $item->name }}  </td>
          <td> {{ $item->phone }}  </td>
          <td> {{ $item->national_id }}  </td>
          <td> {{ $item->email }}  </td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('customers.edit',$item->id) }}">
                    <i class="bx bx-edit-alt me-1"></i>
                    @lang('Edit')
                </a>
                
                <button  class="dropdown-item" onclick="deleteForm('deleteForm{{ $item->id }}')">
                    <i class="bx bx-trash me-1"></i>
                    @lang('Delete')
                    <form id="deleteForm{{ $item->id }}" action="{{ route('customers.destroy',$item->id) }}" method="POST">
                      @method("DELETE")
                      @csrf
                  </form>
                </button>
              </div>
            </div>
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
