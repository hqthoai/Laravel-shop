@extends('main')

@section('content')
    @include('product.list')
    {!! $products->links() !!}
@endsection
