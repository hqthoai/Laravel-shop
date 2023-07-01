@extends('admin.main')

@section('content')
<div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0"">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Date Ordered</th>
              <th></th>
            </tr>
          </thead>
          @foreach($customers as $customer)
          <tbody>

                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->created_at }}</td>
                <td>
                    <a href="/admin/customers/view/{{ $customer->id }}" class ="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
          </tbody>
          @endforeach
        </table>

        {!! $customers->links() !!}
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->
  </div>

@endsection
