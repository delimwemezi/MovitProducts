@extends('layouts.app')

@section('title', 'My product lists')

@section('content')
<div class="history-page">
    <div class="header-row">
        <div>
            <p class="eyebrow">My account</p>
            <h1>My product lists</h1>
        </div>
        <a href="{{ route('product-lists.create') }}" class="primary-btn">Create new list</a>
    </div>

    @if($lists->isEmpty())
        <div class="empty-state">
            <h2>No product lists yet</h2>
            <p>Create your first request list and the business will review it.</p>
        </div>
    @else
        @foreach($lists as $list)
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

                <div class="list-footer">
                    <div>
                        <strong>Total:</strong> TSh {{ number_format($list->total_amount, 2) }}
                    </div>
                    <div>
                        <strong>Submitted:</strong> {{ $list->created_at->format('d M Y') }}
                    </div>
                </div>

                @if($list->admin_reply)
                    <div class="admin-reply">
                        <h3>Admin reply</h3>
                        <p>{{ $list->admin_reply }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>

@push('styles')
<style>
    .history-page { max-width: 1100px; margin: 40px auto; padding: 0 20px 60px; }
    .header-row { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 24px; }
    .eyebrow { text-transform: uppercase; letter-spacing: 0.12em; font-size: 12px; color: #7c3aed; font-weight: 700; }
    h1 { margin: 6px 0 0; color: #111827; }
    .primary-btn { display: inline-block; padding: 12px 18px; border-radius: 12px; background: linear-gradient(135deg, #7c3aed, #ec4899); color: #fff; font-weight: 700; text-decoration: none; }
    .empty-state, .list-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 18px; box-shadow: 0 10px 25px rgba(15,23,42,0.05); }
    .empty-state { padding: 30px; text-align: center; }
    .list-card { padding: 22px; margin-bottom: 20px; }
    .list-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .list-top h2 { margin: 0; }
    .list-top p { margin: 6px 0 0; color: #6b7280; }
    .status { padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; text-transform: capitalize; }
    .status-pending { background: #fff7ed; color: #9a5b00; }
    .status-reviewed { background: #eff6ff; color: #1d4ed8; }
    .status-approved { background: #ecfdf5; color: #047857; }
    .status-rejected { background: #fef2f2; color: #b91c1c; }
    .items-table { display: grid; gap: 10px; }
    .table-head, .table-row { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 14px; padding: 12px 10px; }
    .table-head { font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb; }
    .table-row { border-bottom: 1px solid #f3f4f6; color: #4b5563; }
    .list-footer { display: flex; justify-content: space-between; gap: 20px; margin-top: 18px; color: #111827; }
    .admin-reply { margin-top: 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; }
    .admin-reply h3 { margin-top: 0; }
    @media (max-width: 768px) { .header-row, .list-top, .list-footer { display: grid; } .table-head { display: none; } .table-row { grid-template-columns: 1fr; } }
</style>
@endpush
@endsection
