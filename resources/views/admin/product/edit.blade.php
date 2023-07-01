@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection


@section('content')

      <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Product Name:</label>
                        <input type="text" class="form-control" name="name" value="{{ $product->name }}" placeholder="Enter Name ...">
                    </div>
                    <div class="form-group">
                        <label for="name">Price: </label>
                        <input type="number" class="form-control" name="price" value="{{ $product->price }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category:</label>
                        <select class="form-control"  name="category_id">
                            @foreach ($menus as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id === $category->id? 'selected':'' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Reduced Price: </label>
                        <input type="number" class="form-control" name="price_sale" value="{{ $product->price_sale }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea class="form-control" name="description">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Detailed Description:</label>
                <textarea class="form-control" name="content" >{{ $product->content }}</textarea>
            </div>

            <div class="form-group">
                <label>Picture:</label>
                <input type="file" class="form-control" id="upload">
                <div id="image-show">
                    <a href="{{ $product->thumb }}">
                        <img src="{{ $product->thumb }}" width="100px">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{ $product->thumb }}" >

            </div>

            <div class="form-group">
                <label>Active:</label>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" value="1" id="active"
                  name="active" {{ $product->active === 1? 'checked==""' :'' }}>
                  <label for="active" class="custom-control-label">Yes</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" value="0" id="not-active"
                  name="active" {{ $product->active === 0? 'checked==""' :'' }}>
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
