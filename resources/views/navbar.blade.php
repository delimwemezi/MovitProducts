<div class="navbar">

    <div class="logo-container">
        <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="logo">
    </div>
    
    <div class="nav">
        <a href="/">Home</a>
        <a href="/products">Products</a>
        <a href="{{ route('product-lists.create') }}">Product List</a>
        @auth
            <a href="{{ route('product-lists.history') }}">My Lists</a>
            <form method="POST" action="{{ route('customer.logout') }}" style="display:inline; margin:0;">
                @csrf
                <button type="submit" class="nav-logout-btn">Logout</button>
            </form>
        @else
            <a href="{{ route('customer.login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</div>
@include('partials.alerts')