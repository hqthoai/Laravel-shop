@extends('main')

@section('content')
<div class="bg0 p-b-20">
    <div class="container">
    @include('product.list')
    {!! $products->links() !!}
    </div>
</div>
@endsection
