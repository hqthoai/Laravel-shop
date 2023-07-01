@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection


@section('content')

      <form action="" method="POST">
        <div class="card-body">
          <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name ...">
          </div>

          <div class="form-group">
            <label>Choose Base Category:</label>
            <select class="form-control"  name="parent_id">
                <option value="0">
                    Choose Category
                </option>
                @foreach ($menus as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Description:</label>
            <textarea class="form-control" name="description"></textarea>
          </div>

          <div class="form-group">
            <label>Detailed Description:</label>
            <textarea class="form-control" name="content"></textarea>
          </div>

          <div class="form-group">
            <label>Active:</label>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" value="1" id="active" name="active" checked="">
              <label for="active" class="custom-control-label">Yes</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" value="0" id="not-active" name="active">
              <label for="not-active" class="custom-control-label">No</label>
            </div>
          </div>


        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
        @csrf
      </form>

@endsection

@section ('footer')
<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace( 'content' );
</script>
@endsection
