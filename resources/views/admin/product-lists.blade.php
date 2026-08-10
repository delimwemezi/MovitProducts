@extends('layouts.app')

@section('title', 'Product request lists')

@section('content')
<div class="admin-lists-page">
    <div class="page-header">
        <div>
            <p class="eyebrow">Admin</p>
            <h1>Product request lists</h1>
        </div>
        <a href="/admin/dashboard" class="primary-btn">Back to dashboard</a>
    </div>

    <div class="business-panel">
        <h2>Business contact</h2>
        <div class="business-grid">
            <div><strong>Email:</strong> {{ $business->email }}</div>
            <div><strong>Location:</strong> {{ $business->location }}</div>
            <div><strong>Phone:</strong> {{ $business->phone }}</div>
        </div>

        <form method="POST" action="{{ url('/admin/business-profile') }}" class="business-form">
            @csrf
            <div class="field-grid">
                <div class="field-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $business->email) }}" required>
                </div>
                <div class="field-group">
                    <label for="location">Location</label>
                    <input id="location" type="text" name="location" value="{{ old('location', $business->location) }}" required>
                </div>
                <div class="field-group full-width">
                    <label for="phone">Phone number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $business->phone) }}" required>
                </div>
            </div>
            <button type="submit" class="primary-btn">Save business details</button>
        </form>
    </div>

    <div class="stats-grid">
        <div class="stat-card"><span>Total received</span><strong>{{ $requestLists->count() }}</strong></div>
        <div class="stat-card"><span>Reviewed</span><strong>{{ $requestLists->where('status', 'reviewed')->count() }}</strong></div>
        <div class="stat-card"><span>Replied</span><strong>{{ $requestLists->whereNotNull('admin_reply')->count() }}</strong></div>
    </div>

    @forelse($requestLists as $list)
        <div class="list-card">
            <div class="list-top">
                <div>
                    <h2>{{ $list->customer_name }}</h2>
                    <p>{{ $list->location }} • {{ $list->phone }}</p>
                </div>
                <span class="status status-{{ $list->status }}">{{ ucfirst($list->status) }}</span>
            </div>

            <div class="items-table">
                <div class="table-head">
                    <span>Product</span>
                    <span>Cartons</span>
                    <span>Pieces</span>
                    <span>Amount</span>
                </div>
                @foreach($list->items as $item)
                    <div class="table-row">
                        <span>{{ $item->product_name }}</span>
                        <span>{{ $item->cartons }}</span>
                        <span>{{ $item->pieces }}</span>
                        <span>TSh {{ number_format($item->total_price, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="list-meta">
                <span><strong>Total:</strong> TSh {{ number_format($list->total_amount, 2) }}</span>
                <span><strong>Submitted:</strong> {{ $list->created_at->format('d M Y H:i') }}</span>
            </div>

            @if($list->notes)
                <div class="note-box">
                    <strong>Customer note:</strong>
                    <p>{{ $list->notes }}</p>
                </div>
            @endif

            @if(!$list->admin_reply)
                <form method="POST" action="{{ url('/admin/product-lists/' . $list->id . '/reply') }}" class="reply-form">
                    @csrf
                    <textarea name="admin_reply" rows="3" placeholder="Write your reply to the customer..." required></textarea>
                    <div class="form-actions">
                        <button type="submit" class="primary-btn small">Send reply</button>
                    </div>
                </form>
            @else
                <div class="reply-box">
                    <strong>Reply:</strong>
                    <p>{{ $list->admin_reply }}</p>
                </div>
            @endif

            @if($list->status !== 'reviewed')
                <form method="POST" action="{{ url('/admin/product-lists/' . $list->id . '/review') }}" class="review-form">
                    @csrf
                    <button type="submit" class="secondary-btn">Mark as reviewed</button>
                </form>
            @endif
        </div>
    @empty
        <div class="empty-state">No product lists received yet.</div>
    @endforelse
</div>

@push('styles')
<style>
    .admin-lists-page { max-width: 1200px; margin: 40px auto; padding: 0 20px 60px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .eyebrow { text-transform: uppercase; letter-spacing: 0.12em; font-size: 12px; color: #7c3aed; font-weight: 700; }
    h1 { margin: 6px 0 0; }
    .primary-btn, .secondary-btn { display: inline-block; padding: 12px 18px; border-radius: 12px; border: none; text-decoration: none; font-weight: 700; cursor: pointer; }
    .primary-btn { background: linear-gradient(135deg, #7c3aed, #ec4899); color: white; }
    .secondary-btn { background: #e5e7eb; color: #111827; }
    .business-panel, .list-card, .empty-state, .stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 18px; box-shadow: 0 10px 25px rgba(15,23,42,0.05); }
    .business-panel { padding: 20px; margin-bottom: 20px; }
    .business-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
    .business-form { margin-top: 18px; }
    .field-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .field-group { display: flex; flex-direction: column; gap: 6px; }
    .full-width { grid-column: 1 / -1; }
    .field-group input { width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 10px 12px; }
    .stats-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; margin-bottom: 28px; }
    .stat-card { padding: 18px; display: flex; flex-direction: column; gap: 8px; }
    .stat-card span { color: #6b7280; }
    .stat-card strong { font-size: 2rem; }
    .list-card { padding: 22px; margin-bottom: 20px; }
    .list-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
    .list-top h2 { margin: 0; }
    .list-top p { margin: 6px 0 0; color: #6b7280; }
    .status { padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; text-transform: capitalize; }
    .status-pending { background: #fff7ed; color: #9a5b00; }
    .status-reviewed { background: #eff6ff; color: #1d4ed8; }
    .status-approved { background: #ecfdf5; color: #047857; }
    .status-rejected { background: #fef2f2; color: #b91c1c; }
    .items-table { display: grid; gap: 10px; }
    .table-head, .table-row { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 12px; padding: 10px; }
    .table-head { font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb; }
    .table-row { border-bottom: 1px solid #f3f4f6; color: #4b5563; }
    .list-meta { display: flex; justify-content: space-between; margin-top: 18px; gap: 12px; color: #111827; }
    .note-box, .reply-box { margin-top: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; }
    .reply-form { margin-top: 16px; }
    .reply-form textarea { width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 12px; }
    .form-actions { margin-top: 12px; }
    .empty-state { padding: 26px; text-align: center; }
    @media (max-width: 768px) { .business-grid, .stats-grid, .list-top, .list-meta { display: grid; } .table-head { display: none; } .table-row { grid-template-columns: 1fr; } }
</style>
@endpush
@endsection
