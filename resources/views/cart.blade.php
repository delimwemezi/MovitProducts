<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .cart-container {
        width: 80%;
        margin: auto;
        margin-top: 30px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .cart-item {
        background: #fff;
        padding: 15px 20px;
        margin-bottom: 15px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: 0.3s;
    }

    .cart-item:hover {
        transform: translateY(-3px);
    }

    .item-info h2 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .item-info p {
        margin: 5px 0;
        color: #666;
    }

    .total-box {
        background: #fff;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        text-align: right;
        font-size: 20px;
        font-weight: bold;
        margin-top: 20px;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 20px;
        padding: 12px;
        background: #4a90e2;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s;
    }

    .checkout-btn:hover {
        background: #2f6fc0;
    }
</style>

<div class="cart-container">

    <h1>🛒 Your Cart</h1>

    @php $total = 0 @endphp

    @foreach(session('cart') as $id => $item)

        <div class="cart-item">
            <div class="item-info">
                <h2>{{ $item['name'] }}</h2>
                <p>Price: {{ $item['price'] }}</p>
                <p>Quantity: {{ $item['quantity'] }}</p>
            </div>

            <div>
                <strong>
                    Tsh {{ $item['price'] * $item['quantity'] }}
                </strong>
            </div>
        </div>

        @php $total += $item['price'] * $item['quantity'] @endphp

    @endforeach

    <div class="total-box">
        Total: Tsh {{ $total }}
    </div>

    <a href="/checkout" class="checkout-btn">
        Proceed to Checkout →
    </a>
@include('partials.alerts')
</div>