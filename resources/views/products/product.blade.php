@extends('layouts.app')

@section('content')
@php
    $productsForList = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'carton_price' => (float) $product->carton_price,
            'piece_price' => (float) $product->piece_price,
        ];
    })->values()->all();
@endphp
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
    if (trigger) {
        trigger.addEventListener('click', () => trigger.classList.toggle('open'));
        document.addEventListener('click', e => {
            if (!trigger.contains(e.target)) trigger.classList.remove('open');
        });
    }
</script>

    <!-- PRODUCTS -->
    <div class="products">
        @foreach($products as $product)
        <div class="card">
            <div class="card-img">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
            <div class="card-body">
                <h3>{{ $product->name }}</h3>
                <p>{{ $product->description }}</p>
                <p class="price"><span>Carton:</span> TSh {{ number_format($product->carton_price) }}</p>
                <p class="price"><span>Piece:</span> TSh {{ number_format($product->piece_price) }}</p>
                <button type="button" class="add-to-list-btn" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">Add to the list</button>
            </div>
        </div>
        @endforeach
    </div>

    <form action="{{ route('product-lists.store') }}" method="POST" class="product-list-confirmation" id="productListForm">
        @csrf
        <div class="list-summary-card" id="listSummaryCard">
            <div class="summary-header">
                <div>
                    <p class="eyebrow">Your selection</p>
                    <h3>Shopping list preview</h3>
                </div>
                <span class="selection-count" id="selectionCount">0 items</span>
            </div>

            <div id="selectedProductsContainer" class="selected-products-container">
                <p class="empty-list">No products added yet.</p>
            </div>

            <div class="customer-details">
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
                <div class="field-group full-width">
                    <label for="notes">Message</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Optional message...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="summary-total">
                <span>Total estimated amount</span>
                <strong id="estimatedTotal">TSh 0</strong>
            </div>

            <button type="submit" class="confirm-list-btn">Confirm and send list</button>
        </div>
    </form>
</div>

<style>
    .add-to-list-btn {
        display: inline-block;
        width: 100%;
        margin-top: 14px;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px 14px;
        font-weight: 700;
        cursor: pointer;
    }
    .product-list-confirmation {
        margin: 28px 0 50px;
    }
    .list-summary-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
        padding: 22px;
    }
    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }
    .selection-count {
        background: #f3e8ff;
        color: #6d28d9;
        border-radius: 999px;
        padding: 8px 12px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .selected-products-container {
        display: grid;
        gap: 12px;
        margin-bottom: 20px;
    }
    .empty-list {
        margin: 0;
        color: #6b7280;
        padding: 12px 0;
    }
    .selected-product-item {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr auto;
        gap: 12px;
        align-items: end;
        padding: 12px 14px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }
    .selected-product-item h4 {
        margin: 0 0 6px;
        color: #111827;
        font-size: 0.98rem;
    }
    .selected-product-item small {
        color: #6b7280;
    }
    .qty-field label {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-weight: 600;
        color: #374151;
        font-size: 0.8rem;
    }
    .qty-field input {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 9px 10px;
    }
    .remove-product-btn {
        background: transparent;
        border: 1px solid #fecaca;
        color: #b91c1c;
        border-radius: 8px;
        padding: 10px 12px;
        cursor: pointer;
        font-weight: 700;
    }
    .customer-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-top: 12px;
    }
    .field-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .field-group.full-width {
        grid-column: 1 / -1;
    }
    .field-group label {
        font-weight: 600;
        color: #374151;
    }
    .field-group input,
    .field-group textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 1rem;
        background: #fff;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 18px;
        margin-top: 18px;
        border-top: 1px solid #e5e7eb;
        color: #374151;
        font-size: 1.05rem;
    }
    .confirm-list-btn {
        width: 100%;
        margin-top: 22px;
        border: none;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        color: white;
        padding: 16px 22px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
    }
    @media (max-width: 760px) {
        .customer-details,
        .selected-product-item {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    const productsForList = @json($productsForList);
    const selectedProducts = new Map();
    const selectedContainer = document.getElementById('selectedProductsContainer');
    const selectionCountEl = document.getElementById('selectionCount');
    const estimatedTotalEl = document.getElementById('estimatedTotal');

    function updateSummary() {
        const items = Array.from(selectedProducts.values());
        selectionCountEl.textContent = items.length + ' item' + (items.length === 1 ? '' : 's');

        if (!items.length) {
            selectedContainer.innerHTML = '<p class="empty-list">No products added yet.</p>';
            estimatedTotalEl.textContent = 'TSh 0';
            return;
        }

        let total = 0;
        selectedContainer.innerHTML = '';

        items.forEach((item) => {
            const cartons = Number(item.cartons || 0);
            const pieces = Number(item.pieces || 0);
            const itemTotal = (cartons * (item.carton_price || 0)) + (pieces * (item.piece_price || 0));
            total += itemTotal;

            const row = document.createElement('div');
            row.className = 'selected-product-item';
            row.innerHTML = `
                <div>
                    <h4>${item.name}</h4>
                    <small>TSh ${Number(item.carton_price || 0).toLocaleString()} / carton</small>
                </div>
                <div class="qty-field">
                    <label>Cartons
                        <input type="number" min="0" value="${cartons}" data-role="cartons" data-product-id="${item.id}">
                    </label>
                </div>
                <div class="qty-field">
                    <label>Pieces
                        <input type="number" min="0" value="${pieces}" data-role="pieces" data-product-id="${item.id}">
                    </label>
                </div>
                <button type="button" class="remove-product-btn" data-remove-product-id="${item.id}">Remove</button>
            `;
            selectedContainer.appendChild(row);
        });

        estimatedTotalEl.textContent = 'TSh ' + total.toLocaleString();
    }

    function syncHiddenFields() {
        const form = document.getElementById('productListForm');
        const existing = form.querySelectorAll('[data-variant-input]');
        existing.forEach((field) => field.remove());

        Array.from(selectedProducts.values()).forEach((item) => {
            const cartons = Number(item.cartons || 0);
            const pieces = Number(item.pieces || 0);
            if (cartons <= 0 && pieces <= 0) return;

            const productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'items[' + item.id + '][product_id]';
            productIdInput.value = item.id;
            productIdInput.dataset.variantInput = 'true';
            form.appendChild(productIdInput);

            const cartonsInput = document.createElement('input');
            cartonsInput.type = 'hidden';
            cartonsInput.name = 'items[' + item.id + '][cartons]';
            cartonsInput.value = cartons;
            cartonsInput.dataset.variantInput = 'true';
            form.appendChild(cartonsInput);

            const piecesInput = document.createElement('input');
            piecesInput.type = 'hidden';
            piecesInput.name = 'items[' + item.id + '][pieces]';
            piecesInput.value = pieces;
            piecesInput.dataset.variantInput = 'true';
            form.appendChild(piecesInput);
        });
    }

    document.querySelectorAll('.add-to-list-btn').forEach((button) => {
        button.addEventListener('click', function () {
            const productId = Number(this.dataset.productId);
            const product = productsForList.find(item => item.id === productId);

            if (!product) return;

            if (!selectedProducts.has(productId)) {
                selectedProducts.set(productId, {
                    ...product,
                    cartons: 1,
                    pieces: 0,
                });
            }

            updateSummary();
            syncHiddenFields();
        });
    });

    document.addEventListener('input', function (event) {
        const target = event.target;
        if (!target.matches('[data-role="cartons"], [data-role="pieces"]')) return;

        const productId = Number(target.dataset.productId);
        const item = selectedProducts.get(productId);
        if (!item) return;

        item[target.dataset.role] = Number(target.value || 0);
        updateSummary();
        syncHiddenFields();
    });

    document.addEventListener('click', function (event) {
        const removeButton = event.target.closest('[data-remove-product-id]');
        if (!removeButton) return;

        const productId = Number(removeButton.dataset.removeProductId);
        selectedProducts.delete(productId);
        updateSummary();
        syncHiddenFields();
    });

    updateSummary();
    syncHiddenFields();
</script>

@include('partials.alerts')
@endsection
