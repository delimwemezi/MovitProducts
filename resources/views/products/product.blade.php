@extends('layouts.app')

@section('content')
<div class="container">

    <!-- SEARCH -->
<form method="GET" action="/products" class="search-box">
    <i class="ti ti-search search-icon"></i>
    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
    <button type="submit" class="btn">Search</button>
</form>
     
       <!-- CATEGORIES -->
    <section class="categories">
        <h1>Categories</h1>
        <div class="category-grid">
            @foreach($categories as $category)
                <a href="/products?category={{ $category->id }}" class="category-card">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </section>

    <!-- PRODUCTS -->
    <div class="products">
        @foreach($products as $product)
    <div class="card">
      <div class="card-img">
        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
      </div>
      <div class="card-body">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->description }}</p>
            <p class="price"><span>Carton:</span> TSh {{ number_format($product->carton_price) }}</p>
            <p class="price"><span>Piece:</span> TSh {{ number_format($product->piece_price) }}</p>  
    </div>
     
            <!-- BUTTON 
            <a href="/add-to-cart/{{ $product->id }}" class="btn">
                Add to Cart
            </a>
            -->

        </div>
        @endforeach
    </div>

</div>

@include('partials.alerts')
@endsection
