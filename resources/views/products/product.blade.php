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
    <div class="category-trigger-wrapper" id="categoryTrigger">
        <h1>Categories</h1>
        <span class="dropdown-arrow">
            <i class="ti ti-chevron-down" aria-hidden="true"></i>
        </span>

        <div class="category-dropdown">
            <div class="category-grid">
                @foreach($categories as $category)
                    <a href="/products?category={{ $category->id }}" class="category-card">
                        <span class="category-label">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
    
    <script>
    const trigger = document.getElementById('categoryTrigger');
    trigger.addEventListener('click', () => trigger.classList.toggle('open'));
    document.addEventListener('click', e => {
        if (!trigger.contains(e.target)) trigger.classList.remove('open');
    });
</script>

    <!-- PRODUCTS -->
    <div class="products">
        @foreach($products as $product)
    <div class="card">
      <div class="card-img">
       {{-- ✅ Use Cloudinary image URL --}}
       <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 200px; object-fit: cover;">
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

