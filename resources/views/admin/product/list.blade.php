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
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Price</th>
              <th>Reduced Price</th>
              <th>Active</th>
              <th>Update</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          @foreach($products as $key=>$product)
          <tbody>

                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->price_sale }}</td>
                <td>{!!  \App\Helpers\Helper::active($product->active) !!}</td>
                <td>{{ $product->updated_at }}</td>
                <td>
                    <a href="/admin/products/edit/{{ $product->id }}" class ="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-danger btn-sm"
                    onclick="removeRow({{ $product->id }},'/admin/products/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
          </tbody>
          @endforeach
        </table>

        {!! $products->links() !!}
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->
  </div>

@endsection
