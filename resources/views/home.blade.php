

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

<script>
    const trigger = document.getElementById('categoryTrigger');
    trigger.addEventListener('click', () => trigger.classList.toggle('open'));
    document.addEventListener('click', e => {
        if (!trigger.contains(e.target)) trigger.classList.remove('open');
    });
</script>
@include('partials.alerts')
@endsection
