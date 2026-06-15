<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart — Mufti Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        .qty-form { display: flex; align-items: center; gap: 0.4rem; }
        .qty-input {
            width: 3.2rem; text-align: center; padding: 0.3rem 0.4rem;
            font-family: 'Cormorant Garamond', serif; font-size: 0.95rem;
            border: 1px solid var(--border-vintage); background: var(--parchment);
            color: var(--sepia-text); border-radius: var(--radius);
        }
        .btn-qty {
            font-family: inherit; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.05em;
            padding: 0.3rem 0.75rem; border-radius: var(--radius); cursor: pointer;
            border: 1px solid var(--border-vintage); background: transparent;
            color: var(--sepia-light); transition: all 0.2s;
        }
        .btn-qty:hover { background: var(--aged-paper); color: var(--sepia-text); }
        .action-remove {
            background: transparent; border: 1px solid #d4a0a0; color: var(--crimson); cursor: pointer;
        }
        .action-remove:hover { background: var(--crimson-soft); }
        .cart-summary {
            display: flex; justify-content: flex-end; align-items: center;
            gap: 1.5rem; padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border-ornate); margin-top: 0;
        }
        .cart-total-label {
            font-family: 'IM Fell English', serif; font-style: italic;
            font-size: 1.05rem; color: var(--sepia-light);
        }
        .cart-total-value {
            font-family: 'Playfair Display', serif; font-size: 1.5rem;
            font-weight: 700; color: var(--sepia-text);
        }
        .cart-total-value .currency { font-size: 1rem; font-weight: 400; }
        .btn-order {
            display: inline-flex; align-items: center; gap: 0.5rem;
            font-family: 'Cormorant Garamond', serif; font-size: 1rem;
            font-weight: 700; letter-spacing: 0.09em; text-transform: uppercase;
            padding: 0.7rem 2rem; border-radius: var(--radius); cursor: pointer;
            background: var(--crimson); border: 1px solid var(--crimson);
            color: #faf5ec; transition: all 0.25s ease;
        }
        .btn-order:hover { background: var(--crimson-hover); transform: translateY(-1px); }
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
            <a href="{{ route('catalog') }}" class="btn-back"><span class="arrow">←</span> Continue Shopping</a>
            <div style="width:1px;height:24px;background:var(--border-vintage);flex-shrink:0;"></div>
            <h1><em>My</em> Cart</h1>
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

    @if($cartItems->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <h3>Your Cart is Empty</h3>
            <p>Browse our collection and add pieces you love.</p>
            <a href="{{ route('catalog') }}" class="btn btn-primary">
                <i class="fa-solid fa-arrow-left"></i> Browse Collection
            </a>
        </div>
    @else
        <div class="inventory-table-wrap">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th class="th-photo">Photo</th>
                        <th class="th-name">Piece</th>
                        <th class="th-category">Category</th>
                        <th class="th-price">Unit Price</th>
                        <th style="min-width:11rem;">Quantity</th>
                        <th class="th-price">Subtotal</th>
                        <th class="th-actions"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        @php
                            $catIcon = match($item->product->category) {
                                'painting'       => 'fa-palette',
                                'antique_piece'  => 'fa-gem',
                                'vase'           => 'fa-wine-glass',
                                'handcraft'      => 'fa-scissors',
                                'old_electronic' => 'fa-tv',
                                default          => 'fa-crown',
                            };
                        @endphp
                        <tr class="inventory-row">
                            <td class="td-photo">
                                @if($item->product->primaryImage())
                                    <img src="{{ route('products.image', $item->product) }}"
                                         alt="{{ $item->product->name }}" class="table-thumb">
                                @else
                                    <span class="table-thumb-empty"><i class="fa-solid {{ $catIcon }}"></i></span>
                                @endif
                            </td>
                            <td class="td-name">
                                <strong class="piece-name">{{ $item->product->name }}</strong>
                            </td>
                            <td class="td-category">
                                <span class="category-pill category-{{ $item->product->category }}">{{ str_replace('_', ' ', $item->product->category) }}</span>
                            </td>
                            <td class="td-price">
                                <span class="price-tag"><span class="currency">$</span>{{ number_format($item->product->price, 2) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('cart.update', $item->product) }}" method="POST" class="qty-form">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="qty-input">
                                    <button type="submit" class="btn-qty">Update</button>
                                </form>
                            </td>
                            <td class="td-price">
                                <span class="price-tag"><span class="currency">$</span>{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </td>
                            <td class="td-actions">
                                <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-remove" title="Remove">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <span class="cart-total-label">Order Total:</span>
            <span class="cart-total-value"><span class="currency">$</span>{{ number_format($total, 2) }}</span>
        </div>

        <div style="display:flex;justify-content:flex-end;padding:1rem 1.5rem 2rem;">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn-order">
                    <i class="fa-solid fa-paper-plane"></i> Place Order
                </button>
            </form>
        </div>
    @endif

    <div class="ornament-divider" style="margin-top:3rem;"><span>✦</span></div>
    <p style="text-align:center;font-family:'IM Fell English',serif;font-style:italic;color:var(--sepia-light);font-size:0.88rem;letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>
</div>
</body>
</html>
