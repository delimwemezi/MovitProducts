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
       {{-- ✅ NEW: Use image_url accessor that handles both MySQL and Cloudinary --}}
       <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
      </div>
      <div class="card-body">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->description }}</p>
            <p class="price"><span>Carton:</span> TSh {{ number_format($product->carton_price) }}</p>
            <p class="price"><span>Piece:</span> TSh {{ number_format($product->piece_price) }}</p>
            <a href="{{ route('product-lists.create') }}" class="wishlist-mini-btn">Create product list</a>
    </div>
     
            <!-- BUTTON 
            <a href="/add-to-cart/{{ $product->id }}" class="btn">
                Add to Cart
            </a>
            -->

        </div>
        @endforeach
    </div>

    <div class="wishlist-banner">
        <h2>Need a custom list?</h2>
        <a href="{{ route('product-lists.create') }}" class="cta-button">Request products</a>
    </div>

</div>

.wishlist-mini-btn, .cta-button {
    display: inline-block;
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    color: #fff;
    text-decoration: none;
    font-weight: 700;
}
.wishlist-banner {
    margin: 24px 0 50px;
    text-align: center;
    background: linear-gradient(135deg, #f5f3ff, #fdf2f8);
    border: 1px solid #e9d5ff;
    border-radius: 18px;
    padding: 28px;
}

@include('partials.alerts')
@endsection
