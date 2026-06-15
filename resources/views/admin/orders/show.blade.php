<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }} — Mufti Gallery Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        /* Status */
        .status-pill {
            display: inline-block; padding: 0.3rem 1rem; border-radius: 999px;
            font-size: 0.8rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
        }
        .status-pending       { background: #fef9ec; border: 1px solid #e0c96a; color: #8a6d15; }
        .status-info_requested{ background: #fff4ec; border: 1px solid #e09a40; color: #8a4010; }
        .status-confirmed     { background: #edfaf0; border: 1px solid #6dc98a; color: #1a6630; }
        .status-cancelled     { background: var(--crimson-soft); border: 1px solid #d4a0a0; color: var(--crimson); }
        /* Detail panels */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        .detail-panel {
            background: var(--parchment); border: 1px solid var(--border-vintage);
            border-radius: var(--radius-lg); padding: 1.35rem 1.5rem;
        }
        .detail-panel h3 {
            font-family: 'Cormorant Garamond', serif; font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.18em; text-transform: uppercase; color: var(--sepia-light);
            margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;
        }
        .detail-panel h3 i { color: var(--crimson); font-size: 0.82rem; }
        .detail-row { display: flex; gap: 0.5rem; margin-bottom: 0.5rem; font-size: 0.95rem; }
        .detail-label { color: var(--sepia-light); min-width: 5rem; flex-shrink: 0; }
        .detail-value { color: var(--sepia-text); font-weight: 500; }
        /* Items table */
        .items-panel {
            background: var(--parchment); border: 1px solid var(--border-vintage);
            border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 2rem;
        }
        .items-panel-header {
            padding: 0.9rem 1.5rem; background: var(--aged-paper);
            border-bottom: 1px solid var(--border-vintage);
            font-family: 'Cormorant Garamond', serif; font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.18em; text-transform: uppercase; color: var(--sepia-light);
            display: flex; align-items: center; gap: 0.5rem;
        }
        .items-panel-header i { color: var(--crimson); }
        /* Action buttons */
        .action-panel {
            background: var(--parchment); border: 1px solid var(--border-vintage);
            border-radius: var(--radius-lg); padding: 1.35rem 1.5rem; margin-bottom: 2rem;
        }
        .action-panel h3 {
            font-family: 'Cormorant Garamond', serif; font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.18em; text-transform: uppercase; color: var(--sepia-light);
            margin-bottom: 1.1rem; display: flex; align-items: center; gap: 0.5rem;
        }
        .action-panel h3 i { color: var(--crimson); font-size: 0.82rem; }
        .action-row { display: flex; flex-wrap: wrap; align-items: flex-start; gap: 1rem; }
        .notes-field {
            font-family: 'Cormorant Garamond', serif; font-size: 0.98rem;
            padding: 0.6rem 0.9rem; border: 1px solid var(--border-vintage);
            background: var(--parchment); color: var(--sepia-text);
            border-radius: var(--radius); width: 100%; max-width: 30rem; resize: vertical; min-height: 3.5rem;
            transition: border-color 0.2s;
        }
        .notes-field:focus { outline: none; border-color: var(--border-ornate); box-shadow: 0 0 0 2px rgba(196,169,106,0.18); }
        .notes-label { font-size: 0.82rem; font-weight: 600; letter-spacing: 0.04em; color: var(--sepia-light); text-transform: uppercase; margin-bottom: 0.35rem; display: block; }
        .btn-action {
            display: inline-flex; align-items: center; gap: 0.45rem;
            font-family: 'Cormorant Garamond', serif; font-size: 0.88rem;
            font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
            padding: 0.6rem 1.35rem; border-radius: var(--radius); cursor: pointer;
            transition: all 0.22s ease;
        }
        .btn-request { background: #c97a20; border: 1px solid #c97a20; color: #fff; }
        .btn-request:hover { background: #a86118; }
        .btn-confirm { background: #2d7a3e; border: 1px solid #2d7a3e; color: #fff; }
        .btn-confirm:hover { background: #236130; }
        .btn-cancel  { background: transparent; border: 1px solid #d4a0a0; color: var(--crimson); }
        .btn-cancel:hover { background: var(--crimson-soft); }
        /* Order total row */
        .order-total-row {
            display: flex; justify-content: flex-end; padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-vintage); gap: 1rem; align-items: center;
        }
        .total-label { font-family: 'IM Fell English', serif; font-style: italic; color: var(--sepia-light); }
        .total-value { font-family: 'Playfair Display', serif; font-size: 1.35rem; font-weight: 700; color: var(--sepia-text); }
        .flash-error {
            display: flex; align-items: center; gap: 0.85rem;
            background: var(--crimson-soft); border: 1px solid #d4a0a0;
            border-left: 4px solid var(--crimson); color: var(--crimson);
            padding: 0.9rem 1.35rem; border-radius: var(--radius); margin-bottom: 2rem;
        }
        .no-info-note { font-style: italic; color: var(--sepia-light); font-size: 0.9rem; }
        @media (max-width: 700px) { .detail-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
@include('partials.admin-nav')
<div class="page-wrapper" style="padding-top:2rem;">

    <div class="page-titlebar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <a href="{{ route('admin.orders.index') }}" class="btn-back"><span class="arrow">←</span> All Orders</a>
            <div style="width:1px;height:24px;background:var(--border-vintage);flex-shrink:0;"></div>
            <h1>Order <em>#{{ $order->id }}</em></h1>
        </div>
        <span class="status-pill status-{{ $order->status }}">
            {{ ucwords(str_replace('_', ' ', $order->status)) }}
        </span>
    </div>

    @if(session('success'))
        <div class="flash-success">
            <i class="fa-solid fa-circle-check icon"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ── Info Panels ── --}}
    <div class="detail-grid">
        {{-- Customer Info --}}
        <div class="detail-panel">
            <h3><i class="fa-solid fa-user"></i> Customer</h3>
            <div class="detail-row">
                <span class="detail-label">Name</span>
                <span class="detail-value">{{ $order->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $order->user->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Placed</span>
                <span class="detail-value">{{ $order->created_at->format('M d, Y — H:i') }}</span>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="detail-panel">
            <h3><i class="fa-solid fa-address-card"></i> Contact &amp; Delivery</h3>
            @if($order->customer_name)
                <div class="detail-row">
                    <span class="detail-label">Contact</span>
                    <span class="detail-value">{{ $order->customer_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone</span>
                    <span class="detail-value">{{ $order->customer_phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address</span>
                    <span class="detail-value">{{ $order->customer_address }}</span>
                </div>
            @else
                <p class="no-info-note">Customer has not yet provided contact information.</p>
            @endif
        </div>
    </div>

    {{-- ── Order Items ── --}}
    <div class="items-panel">
        <div class="items-panel-header">
            <i class="fa-solid fa-list-ul"></i> Order Items
        </div>
        <table class="inventory-table">
            <thead>
                <tr>
                    <th class="th-photo">Photo</th>
                    <th class="th-name">Piece</th>
                    <th class="th-category">Category</th>
                    <th class="th-price">Unit Price</th>
                    <th class="th-num" style="text-align:center;">Qty</th>
                    <th class="th-price">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    @php
                        $catIcon = $item->product ? match($item->product->category) {
                            'painting'       => 'fa-palette',
                            'antique_piece'  => 'fa-gem',
                            'vase'           => 'fa-wine-glass',
                            'handcraft'      => 'fa-scissors',
                            'old_electronic' => 'fa-tv',
                            default          => 'fa-crown',
                        } : 'fa-crown';
                    @endphp
                    <tr class="inventory-row">
                        <td class="td-photo">
                            @if($item->product?->primaryImage())
                                <img src="{{ route('products.image', $item->product) }}"
                                     alt="{{ $item->product->name }}" class="table-thumb">
                            @else
                                <span class="table-thumb-empty"><i class="fa-solid {{ $catIcon }}"></i></span>
                            @endif
                        </td>
                        <td class="td-name">
                            <strong class="piece-name">{{ $item->product->name ?? '(deleted product)' }}</strong>
                        </td>
                        <td class="td-category">
                            @if($item->product)
                                <span class="category-pill category-{{ $item->product->category }}">{{ str_replace('_', ' ', $item->product->category) }}</span>
                            @endif
                        </td>
                        <td class="td-price">
                            <span class="price-tag"><span class="currency">$</span>{{ number_format($item->price, 2) }}</span>
                        </td>
                        <td class="td-num" style="text-align:center;">{{ $item->quantity }}</td>
                        <td class="td-price">
                            <span class="price-tag"><span class="currency">$</span>{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="order-total-row">
            <span class="total-label">Order Total:</span>
            <span class="total-value">
                <span style="font-size:0.9rem;font-weight:400;">$</span>{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}
            </span>
        </div>
    </div>

    {{-- ── Admin Actions ── --}}
    @if(! in_array($order->status, ['confirmed', 'cancelled']))
        <div class="action-panel">
            <h3><i class="fa-solid fa-sliders"></i> Manage Order</h3>
            <div class="action-row">

                {{-- Request Info --}}
                <form action="{{ route('admin.orders.requestInfo', $order) }}" method="POST" style="display:flex;flex-direction:column;gap:0.5rem;">
                    @csrf @method('PATCH')
                    <label class="notes-label" for="admin-notes">Message to customer (optional)</label>
                    <textarea id="admin-notes" name="admin_notes" class="notes-field"
                              placeholder="e.g. Please provide your delivery address to complete this order.">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                    <button type="submit" class="btn-action btn-request">
                        <i class="fa-solid fa-comment-dots"></i> Ask for Customer Info
                    </button>
                </form>

                <div style="display:flex;flex-direction:column;gap:0.75rem;align-self:flex-end;">
                    {{-- Confirm --}}
                    @if($order->customer_name)
                        <form action="{{ route('admin.orders.confirm', $order) }}" method="POST"
                              onsubmit="return confirm('Confirm order #{{ $order->id }}?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-action btn-confirm">
                                <i class="fa-solid fa-circle-check"></i> Confirm Order
                            </button>
                        </form>
                    @endif

                    {{-- Cancel --}}
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST"
                          onsubmit="return confirm('Cancel order #{{ $order->id }}? This cannot be undone.');">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-action btn-cancel">
                            <i class="fa-solid fa-circle-xmark"></i> Cancel Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="ornament-divider" style="margin-top:3rem;"><span>✦</span></div>
    <p style="text-align:center;font-family:'IM Fell English',serif;font-style:italic;color:var(--sepia-light);font-size:0.88rem;letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>
</div>
</body>
</html>
