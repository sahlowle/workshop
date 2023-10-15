@extends('layouts/contentNavbarLayout')

@section('title', $title)

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light"> {{ $title }}  /</span> @lang('List')
</h4>

<a class="btn btn-outline-primary m-2" href="{{ route('users.create') }}">
  <i class='bx bx-plus' style="font-size: 1.5rem"></i>
  @lang("Add New") 
</a>

<!-- Hoverable Table rows -->
<div class="card">
  <h5 class="card-header mb-0">
    <i class='bx bxs-user'></i>
    {{ $title }} 
  </h5>
  <div class="table-responsive text-nowrap p-4">
    <table class="table table-hover datatable">
      <thead>
        <tr>
          <th>#</th>
          <th> @lang("Name") </th>
          <th> @lang("Email") </th>
          <th> @lang("Actions") </th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($users as $item)
        <tr>
          <td> {{ $loop->index + 1 }}  </td>
          <td> {{ $item->name }}  </td>
          <td> {{ $item->email }}  </td>
          <td>
            <a class="btn btn-outline-success btn-sm pl-1"
              href="{{ route('users.edit',$item->id) }}">
              <i class='bx bx-edit' style="font-size: 1.2rem"></i>
              @lang('Edit')
            </a>

            <button class="btn btn-outline-danger btn-sm pl-1" onclick="deleteForm('deleteForm{{ $item->id }}')">
              <i class="bx bx-trash me-1"></i>
              @lang('Delete')
                <form id="deleteForm{{ $item->id }}"
                  action="{{ route('users.destroy',$item->id) }}" method="POST">
                  @method("DELETE")
                  @csrf
                </form>
            </button>


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
