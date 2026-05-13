<div class="navbar">

    <div class="logo-container">
        <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="logo">
    </div>
    
    <div class="nav">
        <a href="/">Home</a>
        <a href="/products">Products</a>
  <!---
        <a href="/cart">
            🛒 Cart
            @php
                $cartCount = session('cart') ? count(session('cart')) : 0;
            @endphp

            @if($cartCount > 0)
                <span class="badge">{{ $cartCount }}</span>
            @endif
        </a>
-->

    </div>
</div>
@include('partials.alerts')