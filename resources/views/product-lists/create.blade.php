@extends('layouts.app')

@section('title', 'Create Product List')

@section('content')
@php
    $productsForJs = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'carton_price' => (float) $product->carton_price,
            'piece_price' => (float) $product->piece_price,
        ];
    })->values()->all();
@endphp
<div class="wishlist-page">
    <div class="wishlist-header">
        <p class="eyebrow">Customer request</p>
        <h1>Create your list</h1>
        <p>Tell us the products you want and the quantity. We will review and contact you.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('product-lists.store') }}" method="POST" class="wishlist-form">
        @csrf

        <div class="customer-card">
            <div class="field-grid">
                <div class="field-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="field-group">
                    <label for="phone">Phone number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
                </div>
                <div class="field-group full-width">
                    <label for="location">Location</label>
                    <input id="location" type="text" name="location" value="{{ old('location') }}" required>
                </div>
            </div>
        </div>

        <div class="wishlist-product-list" id="wishlistItems">
            @foreach($products as $product)
                <div class="wishlist-row" data-product-id="{{ $product->id }}">
                    <div class="product-meta">
                        <h3>{{ $product->name }}</h3>
                        <p>Carton: TSh {{ number_format($product->carton_price) }}  |  Piece: TSh {{ number_format($product->piece_price) }}</p>
                    </div>
                    <div class="qty-boxes">
                        <label>
                            <span>Cartons</span>
                            <input type="number" min="0" name="items[{{ $product->id }}][product_id]" value="{{ $product->id }}" hidden>
                            <input type="number" min="0" name="items[{{ $product->id }}][cartons]" value="0">
                        </label>
                        <label>
                            <span>Pieces</span>
                            <input type="number" min="0" name="items[{{ $product->id }}][pieces]" value="0">
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="notes-box">
            <label for="notes">Message to the business</label>
            <textarea id="notes" name="notes" rows="4" placeholder="Optional message...">{{ old('notes') }}</textarea>
        </div>

        <div class="summary-card">
            <div class="summary-row">
                <span>Product count</span>
                <strong id="productCount">0</strong>
            </div>
            <div class="summary-row">
                <span>Selected cartons</span>
                <strong id="cartonCount">0</strong>
            </div>
            <div class="summary-row total">
                <span>Total amount</span>
                <strong id="totalAmount">TSh 0</strong>
            </div>
        </div>

        <button type="submit" class="primary-btn">Confirm and send list</button>
    </form>
</div>

@push('styles')
<style>
    .wishlist-page {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px 60px;
    }
    .wishlist-header {
        text-align: center;
        margin-bottom: 28px;
    }
    .eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 12px;
        color: #7c3aed;
        font-weight: 700;
    }
    .wishlist-header h1 {
        font-size: 2.5rem;
        margin: 8px 0;
        color: #1f2937;
    }
    .wishlist-form {
        display: grid;
        gap: 22px;
    }
    .customer-card, .notes-box, .summary-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
        padding: 22px;
    }
    .field-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }
    .field-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .field-group.full-width {
        grid-column: 1 / -1;
    }
    label {
        font-weight: 600;
        color: #374151;
    }
    input, textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 1rem;
        background: #fff;
    }
    .wishlist-product-list {
        display: grid;
        gap: 14px;
    }
    .wishlist-row {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .product-meta h3 {
        margin: 0 0 6px;
        color: #111827;
    }
    .product-meta p {
        margin: 0;
        color: #6b7280;
    }
    .qty-boxes {
        display: flex;
        gap: 18px;
        align-items: end;
    }
    .qty-boxes label {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 110px;
    }
    .summary-card {
        display: grid;
        gap: 12px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }
    .summary-row.total {
        font-size: 1.2rem;
        color: #111827;
        border-bottom: none;
    }
    .primary-btn {
        border: none;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        color: white;
        padding: 16px 22px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .primary-btn:hover {
        transform: translateY(-1px);
    }
    @media (max-width: 768px) {
        .field-grid, .wishlist-row, .qty-boxes {
            grid-template-columns: 1fr;
            display: grid;
        }
        .wishlist-row {
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const productRows = document.querySelectorAll('.wishlist-row');
    const productCountEl = document.getElementById('productCount');
    const cartonCountEl = document.getElementById('cartonCount');
    const totalAmountEl = document.getElementById('totalAmount');

    const products = @json($productsForJs);

    function updateSummary() {
        let count = 0;
        let cartons = 0;
        let total = 0;

        productRows.forEach((row) => {
            const productId = Number(row.dataset.productId);
            const product = products.find(item => item.id === productId);
            const cartonQty = Number(row.querySelector("[name$='[cartons]']")?.value || 0);
            const pieceQty = Number(row.querySelector("[name$='[pieces]']")?.value || 0);

            if (cartonQty > 0 || pieceQty > 0) {
                count += 1;
                cartons += cartonQty;
                total += (cartonQty * (product?.carton_price || 0)) + (pieceQty * (product?.piece_price || 0));
            }
        });

        productCountEl.textContent = count;
        cartonCountEl.textContent = cartons;
        totalAmountEl.textContent = 'TSh ' + total.toLocaleString();
    }

    productRows.forEach((row) => {
        row.querySelectorAll('input[type="number"]').forEach((input) => {
            input.addEventListener('input', updateSummary);
        });
    });
</script>
@endpush
@endsection
