<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders — Mufti Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        /* Status badges */
        .status-pill {
            display: inline-block; padding: 0.22rem 0.75rem; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
        }
        .status-pending       { background: #fef9ec; border: 1px solid #e0c96a; color: #8a6d15; }
        .status-info_requested{ background: #fff4ec; border: 1px solid #e09a40; color: #8a4010; }
        .status-confirmed     { background: #edfaf0; border: 1px solid #6dc98a; color: #1a6630; }
        .status-cancelled     { background: var(--crimson-soft); border: 1px solid #d4a0a0; color: var(--crimson); }
        /* Order cards */
        .order-card {
            background: var(--parchment); border: 1px solid var(--border-vintage);
            border-radius: var(--radius-lg); margin-bottom: 1.5rem;
            overflow: hidden; box-shadow: 0 2px 10px var(--shadow-warm);
        }
        .order-header {
            display: flex; align-items: center; flex-wrap: wrap; gap: 1rem;
            padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border-vintage);
            background: var(--aged-paper);
        }
        .order-num {
            font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700;
            color: var(--sepia-text);
        }
        .order-date { font-size: 0.88rem; color: var(--sepia-light); flex: 1; }
        .order-total {
            font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 700;
            color: var(--sepia-text);
        }
        .order-body { padding: 1.25rem 1.5rem; }
        .order-items-list { list-style: none; margin-bottom: 1rem; }
        .order-items-list li {
            display: flex; justify-content: space-between; align-items: center;
            padding: 0.4rem 0; border-bottom: 1px dashed var(--border-vintage);
            font-size: 0.95rem;
        }
        .order-items-list li:last-child { border-bottom: none; }
        .item-name { color: var(--sepia-text); font-weight: 500; }
        .item-qty  { color: var(--sepia-light); font-size: 0.88rem; }
        .item-price{ color: var(--sepia-mid); font-weight: 600; }
        /* Admin message box */
        .admin-message {
            background: #fff8ec; border: 1px solid var(--border-ornate);
            border-left: 4px solid var(--gold); padding: 0.85rem 1.1rem;
            border-radius: var(--radius); margin-bottom: 1.25rem;
            font-size: 0.95rem; color: var(--sepia-mid);
        }
        .admin-message strong { color: var(--sepia-text); }
        /* Info form */
        .info-request-box {
            background: #fff4ec; border: 1px solid #e09a40;
            border-left: 4px solid #c97a20; border-radius: var(--radius);
            padding: 1.25rem 1.5rem; margin-top: 0.5rem;
        }
        .info-request-box h4 {
            font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600;
            color: #8a4010; margin-bottom: 1rem;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.75rem; }
        .form-field { display: flex; flex-direction: column; gap: 0.3rem; }
        .form-field label { font-size: 0.82rem; font-weight: 600; letter-spacing: 0.04em; color: var(--sepia-light); text-transform: uppercase; }
        .form-field input, .form-field textarea {
            font-family: 'Cormorant Garamond', serif; font-size: 0.98rem;
            padding: 0.55rem 0.85rem; border: 1px solid var(--border-vintage);
            background: var(--parchment); color: var(--sepia-text);
            border-radius: var(--radius); transition: border-color 0.2s;
        }
        .form-field input:focus, .form-field textarea:focus {
            outline: none; border-color: var(--border-ornate);
            box-shadow: 0 0 0 2px rgba(196,169,106,0.18);
        }
        .form-field textarea { resize: vertical; min-height: 4rem; }
        .btn-submit-info {
            display: inline-flex; align-items: center; gap: 0.45rem;
            font-family: 'Cormorant Garamond', serif; font-size: 0.9rem;
            font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
            padding: 0.6rem 1.5rem; border-radius: var(--radius); cursor: pointer;
            background: #c97a20; border: 1px solid #c97a20; color: #fff;
            transition: background 0.2s;
        }
        .btn-submit-info:hover { background: #a86118; }
        /* Customer info summary */
        .info-summary {
            background: var(--gold-pale); border: 1px solid var(--gold-light);
            border-radius: var(--radius); padding: 0.85rem 1.1rem;
            font-size: 0.92rem; color: var(--sepia-mid);
        }
        .info-summary p { margin-bottom: 0.2rem; }
        .info-summary p:last-child { margin-bottom: 0; }
        .flash-error {
            display: flex; align-items: center; gap: 0.85rem;
            background: var(--crimson-soft); border: 1px solid #d4a0a0;
            border-left: 4px solid var(--crimson); color: var(--crimson);
            padding: 0.9rem 1.35rem; border-radius: var(--radius); margin-bottom: 2rem;
        }
    </style>
</head>
<body>
@include('partials.customer-nav')
<div class="page-wrapper" style="padding-top:2rem;">

    <div class="page-titlebar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <a href="{{ route('catalog') }}" class="btn-back"><span class="arrow">←</span> Back to Collection</a>
            <div style="width:1px;height:24px;background:var(--border-vintage);flex-shrink:0;"></div>
            <h1><em>My</em> Orders</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="flash-success">
            <i class="fa-solid fa-circle-check icon"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="flash-error">
            <i class="fa-solid fa-circle-xmark"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
            <h3>No Orders Yet</h3>
            <p>Browse our collection and place your first order.</p>
            <a href="{{ route('catalog') }}" class="btn btn-primary">
                <i class="fa-solid fa-arrow-left"></i> Browse Collection
            </a>
        </div>
    @else
        @foreach($orders as $order)
            @php
                $orderTotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
            @endphp
            <div class="order-card">
                <div class="order-header">
                    <span class="order-num">Order #{{ $order->id }}</span>
                    <span class="order-date">{{ $order->created_at->format('M d, Y — H:i') }}</span>
                    <span class="status-pill status-{{ $order->status }}">
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                    <span class="order-total"><span style="font-size:0.82rem;font-weight:400;">$</span>{{ number_format($orderTotal, 2) }}</span>
                </div>
                <div class="order-body">
                    <ul class="order-items-list">
                        @foreach($order->items as $item)
                            <li>
                                <span class="item-name">{{ $item->product->name ?? '(deleted product)' }}</span>
                                <span class="item-qty">× {{ $item->quantity }}</span>
                                <span class="item-price">${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    @if($order->admin_notes)
                        <div class="admin-message">
                            <strong><i class="fa-solid fa-message"></i> Message from Mufti Gallery:</strong><br>
                            {{ $order->admin_notes }}
                        </div>
                    @endif

                    @if($order->status === 'info_requested')
                        <div class="info-request-box">
                            <h4><i class="fa-solid fa-circle-exclamation"></i> Please provide your contact information to proceed</h4>
                            <form action="{{ route('orders.updateInfo', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-row">
                                    <div class="form-field">
                                        <label for="name-{{ $order->id }}">Full Name</label>
                                        <input id="name-{{ $order->id }}" type="text" name="customer_name"
                                               value="{{ old('customer_name', $order->customer_name) }}"
                                               placeholder="Your full name" required>
                                    </div>
                                    <div class="form-field">
                                        <label for="phone-{{ $order->id }}">Phone Number</label>
                                        <input id="phone-{{ $order->id }}" type="text" name="customer_phone"
                                               value="{{ old('customer_phone', $order->customer_phone) }}"
                                               placeholder="e.g. +1 555 000 1234" required>
                                    </div>
                                </div>
                                <div class="form-field" style="margin-bottom:0.75rem;">
                                    <label for="addr-{{ $order->id }}">Delivery Address</label>
                                    <textarea id="addr-{{ $order->id }}" name="customer_address"
                                              placeholder="Street, City, Country…" required>{{ old('customer_address', $order->customer_address) }}</textarea>
                                </div>
                                <button type="submit" class="btn-submit-info">
                                    <i class="fa-solid fa-paper-plane"></i> Submit My Information
                                </button>
                            </form>
                        </div>
                    @elseif($order->customer_name && ! in_array($order->status, ['cancelled']))
                        <div class="info-summary">
                            <p><strong>Contact:</strong> {{ $order->customer_name }} &mdash; {{ $order->customer_phone }}</p>
                            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    <div class="ornament-divider" style="margin-top:3rem;"><span>✦</span></div>
    <p style="text-align:center;font-family:'IM Fell English',serif;font-style:italic;color:var(--sepia-light);font-size:0.88rem;letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>
</div>
</body>
</html>
