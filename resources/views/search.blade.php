@foreach ($products as $product)
    <div class="media">
        <img class="mr-3" src="{{ $product->thumb }}" alt="{{ $product->name }}" width="50">
        <div class="media-body">
            <a href="/product/{{ $product->id }}-{{ \Str::slug($product->name,'-') }} .html"><h5 class="mt-0">{{ $product->name }}</h5> </a>
            <p>{{ \Str::words(strip_tags($product->description),6) }}</p>
        </div>
    </div>
@endforeach

