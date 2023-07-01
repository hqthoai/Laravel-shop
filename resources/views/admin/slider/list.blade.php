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
      <div class="card-body table-responsive p-0" style="height: 300px;">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th width="100px">Link</th>
              <th>Picture</th>
              <th>Active</th>
              <th>Update</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          @foreach($sliders as $key=>$slider)
          <tbody>
            <tr>
                <td>{{ $slider->id }}</td>
                <td>{{ $slider->name }}</td>
                <td>{{ Str::limit($slider->url, 40) }}
                </td>
                <td>
                    <a href="{{ $slider->thumb }}">
                        <img src="{{ $slider->thumb }}" width="100px">
                    </a>
                </td>
                <td>{!!  \App\Helpers\Helper::active($slider->active) !!}</td>
                <td>{{ $slider->updated_at }}</td>
                <td>
                    <a href="/admin/sliders/edit/{{ $slider->id }}" class ="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-danger btn-sm"
                    onclick="removeRow({{ $slider->id }},'/admin/sliders/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
          </tbody>
          @endforeach
        </table>

        {!! $sliders->links() !!}
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->
  </div>

@endsection
