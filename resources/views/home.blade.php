

@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <!-- HERO / BANNER -->
    <section class="hero">
        <div class="hero-content">
            <h1>Movit Beauty Store</h1>
            <p>Your one-stop shop for skincare, hair products & beauty essentials</p>
            <a href="/products" class="btn-small">Shop Now</a>
        </div>
    </section>

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

    <!-- FEATURED / DEALS -->
    <section class="featured">
        <h1>Current Deals</h1>
        <div class="deal-grid">
            <div class="deal-card">
                <h3>50% OFF</h3>
                <p>Baby Gel</p>
                <a href="/products" class="btn-small">Shop</a>
            </div>
            <div class="deal-card">
                <h3>Buy 1 Get 1</h3>
                <p>Hair Dye</p>
                <a href="/products" class="btn-small">Shop</a>
            </div>
            <div class="deal-card">
                <h3>Hot Sale</h3>
                <p>Hair Gel</p>
                <a href="/products" class="btn-small">Shop</a>
            </div>
        </div>
    </section>

    <!-- PROMO BANNER -->
    <section class="promo">
        <div class="promo-content">
            <h2>Glow Naturally with Movit</h2>
            <p>Discover products that care for your skin</p>
            <a href="/products" class="btn-small">Explore Now</a>
        </div>
    </section>

    <section class="wishlist-cta">
        <div class="wishlist-inner">
            <div>
                <p class="eyebrow">Need a custom shopping list?</p>
                <h2>Create your product request list.</h2>
                <p>Select products, add quantities, and send your list to the business in one click.</p>
            </div>
            <a href="{{ route('product-lists.create') }}" class="cta-button">Create product list</a>
        </div>
    </section>

<script>
    const trigger = document.getElementById('categoryTrigger');
    trigger.addEventListener('click', () => trigger.classList.toggle('open'));
    document.addEventListener('click', e => {
        if (!trigger.contains(e.target)) trigger.classList.remove('open');
    });
</script>
<style>
    .wishlist-cta {
        max-width: 1100px;
        margin: 30px auto 50px;
        padding: 0 20px;
    }
    .wishlist-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        background: linear-gradient(135deg, #f5f3ff, #fdf2f8);
        border: 1px solid #e9d5ff;
        border-radius: 22px;
        padding: 28px 30px;
    }
    .eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 12px;
        color: #7c3aed;
        font-weight: 700;
    }
    .wishlist-inner h2 { margin: 8px 0; color: #111827; }
    .cta-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        color: #fff;
        padding: 14px 22px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
    }
    @media (max-width: 760px) { .wishlist-inner { display: grid; } }
</style>
@include('partials.alerts')
@endsection
