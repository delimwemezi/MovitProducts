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
    </div>

        </div>
        @endforeach
    </div>

    <div class="wishlist-banner" id="wishlistBanner">
        <div class="wishlist-banner-copy">
            <p class="eyebrow">Need a custom list?</p>
            <h2>Create your shopping list in one place.</h2>
            <p>Select products, add quantities, and send your request whenever you are ready.</p>
        </div>
        <div class="wishlist-banner-actions">
            <a href="{{ route('product-lists.create') }}" class="cta-button">Create list</a>
            <button type="button" class="dismiss-button" data-dismiss-banner>Cancel</button>
        </div>
    </div>

</div>

<style>
    .wishlist-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin: 24px 0 50px;
        background: linear-gradient(135deg, #f5f3ff, #fdf2f8);
        border: 1px solid #e9d5ff;
        border-radius: 18px;
        padding: 24px 28px;
    }
    .wishlist-banner-copy {
        flex: 1;
    }
    .eyebrow {
        margin: 0 0 8px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 12px;
        color: #7c3aed;
        font-weight: 700;
    }
    .wishlist-banner-copy h2 {
        margin: 0 0 6px;
        color: #111827;
    }
    .wishlist-banner-copy p {
        margin: 0;
        color: #4b5563;
    }
    .wishlist-banner-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }
    .cta-button, .dismiss-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        padding: 11px 18px;
        font-weight: 700;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
    }
    .cta-button {
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        color: #fff;
        text-decoration: none;
    }
    .dismiss-button {
        background: #fff;
        color: #374151;
        border: 1px solid #d1d5db;
    }
    @media (max-width: 760px) {
        .wishlist-banner {
            flex-direction: column;
            align-items: flex-start;
        }
        .wishlist-banner-actions {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const banner = document.getElementById('wishlistBanner');
        const dismissButton = document.querySelector('[data-dismiss-banner]');

        if (banner && dismissButton) {
            dismissButton.addEventListener('click', function () {
                banner.style.display = 'none';
            });
        }
    });
</script>

@include('partials.alerts')
@endsection
