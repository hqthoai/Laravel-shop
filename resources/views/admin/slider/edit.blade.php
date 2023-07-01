@extends('admin.main')

@section('content')

<form action="" method="POST">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Slider Title:</label>
                    <input type="text" class="form-control" name="name" value="{{ $slider->name }}" placeholder="Enter Name ...">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="url">Link</label>
                    <input type="text" class="form-control" name="url" value="{{  $slider->url }}">
                </div>
            </div>
        </div>


        <div class="form-group">
            <label>Picture:</label>
            <input type="file" class="form-control" id="upload">
            <div id="image-show">
                <a href="{{ $slider->thumb }}">
                    <img src="{{ $slider->thumb }}" width="100px">
                </a>
            </div>
            <input type="hidden" name="thumb" id="thumb" value="{{$slider->thumb}}" >
        </div>

        <div class="form-group">
            <label>Sorting:</label>
            <input type="number" class="form-control" name="sort_by" value="{{ $slider->sort_by }}">
        </div>


        <div class="form-group">
            <label>Active:</label>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" value="1" id="active" name="active"
              {{ $slider->active===1?'checked==""':''}}>
              <label for="active" class="custom-control-label">Yes</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" value="0" id="not-active" name="active"
              {{ $slider->active===0?'checked==""':''}}>
              <label for="not-active" class="custom-control-label">No</label>
            </div>
          </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
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
