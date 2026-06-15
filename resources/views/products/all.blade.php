<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Collection — Mufti Gallery</title>
    <meta name="description" content="Browse the complete inventory of antiques, paintings, and handcrafts at Mufti Gallery.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
</head>
<body>
@include('partials.admin-nav')
<div class="page-wrapper" style="padding-top:2rem;">

    {{-- ══ Page Title Bar ══ --}}
    <div class="page-titlebar">
        <div style="display:flex; align-items:center; gap:1rem;">
            <a href="{{ route('products.index') }}" class="btn-back" id="btn-back-all">
                <span class="arrow">←</span> Dashboard
            </a>
            <div style="width:1px;height:24px;background:var(--border-vintage);flex-shrink:0;"></div>
            <h1><em>Full</em> Collection</h1>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary" id="btn-add-product">
            <i class="fa-solid fa-plus"></i> Add New Piece
        </a>
    </div>

    {{-- ══ Flash Message ══ --}}
    @if(session('success'))
        <div class="flash-success">
            <i class="fa-solid fa-circle-check icon"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ══ Inventory Count ══ --}}
    <div class="inventory-count">
        <span class="count-number">{{ $products->count() }}</span>
        <span class="count-label">
            {{ $products->count() === 1 ? 'piece' : 'pieces' }}
            {{ $category ? 'in ' . str_replace('_', ' ', $category) : 'in collection' }}
        </span>
    </div>

    {{-- ══ Category Filter ══ --}}
    @php
        $categories = [
            'painting'       => ['label' => 'Painting',        'icon' => 'fa-palette'],
            'antique_piece'  => ['label' => 'Antique Piece',   'icon' => 'fa-gem'],
            'vase'           => ['label' => 'Vase',            'icon' => 'fa-wine-glass'],
            'handcraft'      => ['label' => 'Handcraft',       'icon' => 'fa-scissors'],
            'old_electronic' => ['label' => 'Old Electronic',  'icon' => 'fa-tv'],
        ];
    @endphp
    <div class="filter-bar">
        <a href="{{ route('products.all') }}"
           class="filter-pill {{ !$category ? 'filter-pill--active' : '' }}">
            <i class="fa-solid fa-layer-group"></i>
            All
            <span class="filter-count">{{ array_sum($categoryCounts->toArray()) }}</span>
        </a>
        @foreach($categories as $value => $meta)
            <a href="{{ route('products.all', ['category' => $value]) }}"
               class="filter-pill filter-pill--{{ $value }} {{ $category === $value ? 'filter-pill--active' : '' }}">
                <i class="fa-solid {{ $meta['icon'] }}"></i>
                {{ $meta['label'] }}
                @if($categoryCounts->get($value, 0) > 0)
                    <span class="filter-count">{{ $categoryCounts->get($value, 0) }}</span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- ══ Full Products Table ══ --}}
    @if($products->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-solid fa-scroll"></i>
            </div>
            <h3>No Pieces in the Collection</h3>
            <p>Begin curating your gallery by adding the first antique piece.</p>
            <a href="{{ route('products.create') }}" class="btn btn-primary" id="btn-empty-add">
                <i class="fa-solid fa-plus"></i> Add First Piece
            </a>
        </div>
    @else
        <div class="inventory-table-wrap" id="products-grid">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th class="th-num">#</th>
                        <th class="th-photo">Photo</th>
                        <th class="th-name">Piece Name</th>
                        <th class="th-category">Category</th>
                        <th class="th-price">Price</th>
                        <th class="th-status">Status</th>
                        <th class="th-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                        @php
                            $catIcon = match($product->category) {
                                'painting'       => 'fa-solid fa-palette',
                                'antique_piece'  => 'fa-solid fa-gem',
                                'vase'           => 'fa-solid fa-wine-glass',
                                'handcraft'      => 'fa-solid fa-scissors',
                                'old_electronic' => 'fa-solid fa-tv',
                                default          => 'fa-solid fa-crown',
                            };
                        @endphp
                        <tr class="inventory-row" id="product-row-{{ $product->id }}">
                            <td class="td-num">{{ $index + 1 }}</td>
                            <td class="td-photo">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ route('products.image', $product) }}"
                                         alt="{{ $product->name }}"
                                         class="table-thumb"
                                         onclick="openLightbox(this.src, '{{ addslashes($product->name) }}')"
                                         title="Click to view">
                                @else
                                    <span class="table-thumb-empty"><i class="{{ $catIcon }}"></i></span>
                                @endif
                            </td>
                            <td class="td-name">
                                <div class="piece-name-group">
                                    <div>
                                        <strong class="piece-name">{{ $product->name }}</strong>
                                        @if($product->description)
                                            <p class="piece-desc">{{ Str::limit($product->description, 60) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="td-category">
                                <span class="category-pill category-{{ $product->category }}">{{ str_replace('_', ' ', $product->category) }}</span>
                            </td>
                            <td class="td-price">
                                <span class="price-tag"><span class="currency">$</span>{{ number_format($product->price, 2) }}</span>
                            </td>
                            <td class="td-status">
                                @if($product->is_available)
                                    <span class="badge badge-available"><i class="fa-solid fa-circle" style="font-size:0.4rem;vertical-align:middle;margin-right:0.3rem;"></i>In Stock</span>
                                @else
                                    <span class="badge badge-unavailable"><i class="fa-regular fa-circle" style="font-size:0.4rem;vertical-align:middle;margin-right:0.3rem;"></i>Unavailable</span>
                                @endif
                            </td>
                            <td class="td-actions">
                                <div class="row-actions">
                                    <a href="{{ route('products.gallery', $product) }}"
                                       class="action-btn action-gallery"
                                       title="View Gallery">
                                        <i class="fa-regular fa-images"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="action-btn action-edit"
                                       id="btn-edit-{{ $product->id }}"
                                       title="Edit">
                                        <i class="fa-solid fa-pen-nib"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}"
                                          method="POST"
                                          id="delete-form-{{ $product->id }}"
                                          onsubmit="return confirm('Remove «{{ $product->name }}» from the collection?');"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="action-btn action-delete"
                                                id="btn-delete-{{ $product->id }}"
                                                title="Remove">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- ══ Footer ══ --}}
    <div class="ornament-divider" style="margin-top: 3rem;"><span>✦</span></div>
    <p style="text-align:center; font-family:'IM Fell English',serif; font-style:italic; color:var(--sepia-light); font-size:0.88rem; letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>

</div>

{{-- Lightbox --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fa-solid fa-xmark"></i></button>
    <img src="" alt="" class="lightbox-img" id="lightbox-img" onclick="event.stopPropagation()">
    <p class="lightbox-caption" id="lightbox-caption"></p>
</div>
<script>
function openLightbox(src, caption) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').textContent = caption || '';
    document.getElementById('lightbox').classList.add('lightbox--open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('lightbox--open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
</body>
</html>
