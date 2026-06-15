<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders — Mufti Gallery Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        .status-pill {
            display: inline-block; padding: 0.22rem 0.75rem; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
        }
        .status-pending       { background: #fef9ec; border: 1px solid #e0c96a; color: #8a6d15; }
        .status-info_requested{ background: #fff4ec; border: 1px solid #e09a40; color: #8a4010; }
        .status-confirmed     { background: #edfaf0; border: 1px solid #6dc98a; color: #1a6630; }
        .status-cancelled     { background: var(--crimson-soft); border: 1px solid #d4a0a0; color: var(--crimson); }
        .action-view {
            background: transparent; border: 1px solid var(--border-ornate);
            color: var(--gold); text-decoration: none;
        }
        .action-view:hover { background: var(--gold-pale); }
    </style>
</head>
<body>
@include('partials.admin-nav')
<div class="page-wrapper" style="padding-top:2rem;">

    <div class="page-titlebar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <a href="{{ route('products.index') }}" class="btn-back"><span class="arrow">←</span> Dashboard</a>
            <div style="width:1px;height:24px;background:var(--border-vintage);flex-shrink:0;"></div>
            <h1><em>Customer</em> Orders</h1>
        </div>
        <div class="inventory-count" style="margin:0;">
            <span class="count-number">{{ $orders->count() }}</span>
            <span class="count-label">{{ $orders->count() === 1 ? 'order' : 'orders' }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="flash-success">
            <i class="fa-solid fa-circle-check icon"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
            <h3>No Orders Yet</h3>
            <p>Customer orders will appear here once placed.</p>
        </div>
    @else
        <div class="inventory-table-wrap">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th class="th-num">#</th>
                        <th class="th-name">Customer</th>
                        <th class="th-category">Items</th>
                        <th class="th-price">Total</th>
                        <th class="th-status">Status</th>
                        <th class="th-category">Date</th>
                        <th class="th-actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $index => $order)
                        @php
                            $orderTotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                        @endphp
                        <tr class="inventory-row">
                            <td class="td-num">{{ $order->id }}</td>
                            <td class="td-name">
                                <strong class="piece-name">{{ $order->user->name }}</strong>
                                <p class="piece-desc" style="margin:0;">{{ $order->user->email }}</p>
                            </td>
                            <td class="td-category">
                                <span class="category-pill" style="background:var(--aged-paper);color:var(--sepia-mid);">
                                    {{ $order->items->count() }} {{ $order->items->count() === 1 ? 'item' : 'items' }}
                                </span>
                            </td>
                            <td class="td-price">
                                <span class="price-tag"><span class="currency">$</span>{{ number_format($orderTotal, 2) }}</span>
                            </td>
                            <td class="td-status">
                                <span class="status-pill status-{{ $order->status }}">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="td-category" style="font-size:0.88rem;color:var(--sepia-light);">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="td-actions">
                                <a href="{{ route('admin.orders.show', $order) }}" class="action-btn action-view" title="View Order">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="ornament-divider" style="margin-top:3rem;"><span>✦</span></div>
    <p style="text-align:center;font-family:'IM Fell English',serif;font-style:italic;color:var(--sepia-light);font-size:0.88rem;letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>
</div>
</body>
</html>
