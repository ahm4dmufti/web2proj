<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mufti Gallery — Products Inventory</title>
    <meta name="description" content="Browse and manage the curated collection of antiques, paintings, and handcrafts at Mufti Gallery.">
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
        <h1><em>Products</em> Inventory</h1>
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

    @if($totalCount === 0)
        {{-- ══ Empty State ══ --}}
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

        {{-- ══ Featured — Top 3 Most Expensive ══ --}}
        @if($featured->isNotEmpty())
            <section class="featured-section">
                <div class="section-label">
                    <i class="fa-solid fa-crown"></i>
                    <span>Most Valuable Pieces</span>
                </div>
                <div class="featured-grid">
                    @foreach($featured as $rank => $piece)
                        @php
                            $catIcon = match($piece->category) {
                                'painting'       => 'fa-solid fa-palette',
                                'antique_piece'  => 'fa-solid fa-gem',
                                'vase'           => 'fa-solid fa-wine-glass',
                                'handcraft'      => 'fa-solid fa-scissors',
                                'old_electronic' => 'fa-solid fa-tv',
                                default          => 'fa-solid fa-crown',
                            };
                            $rankLabel = ['1st', '2nd', '3rd'][$rank] ?? '';
                        @endphp
                        <div class="featured-card" id="featured-{{ $piece->id }}">
                            <div class="featured-rank">{{ $rankLabel }}</div>
                            @if($piece->images->isNotEmpty())
                                <div class="featured-img-wrap">
                                    <img src="{{ route('products.image', $piece) }}"
                                         alt="{{ $piece->name }}"
                                         class="featured-img"
                                         onclick="openLightbox(this.src, '{{ addslashes($piece->name) }}')"
                                         title="Click to view">
                                </div>
                            @else
                                <div class="featured-icon">
                                    <i class="{{ $catIcon }}"></i>
                                </div>
                            @endif
                            <div class="featured-category">{{ str_replace('_', ' ', $piece->category) }}</div>
                            <h3 class="featured-name">{{ $piece->name }}</h3>
                            @if($piece->description)
                                <p class="featured-desc">{{ Str::limit($piece->description, 80) }}</p>
                            @endif
                            <div class="featured-price">
                                <span class="currency">$</span>{{ number_format($piece->price, 2) }}
                            </div>
                            @if($piece->is_available)
                                <span class="badge badge-available"><i class="fa-solid fa-circle" style="font-size:0.35rem;vertical-align:middle;margin-right:0.25rem;"></i>In Stock</span>
                            @else
                                <span class="badge badge-unavailable"><i class="fa-regular fa-circle" style="font-size:0.35rem;vertical-align:middle;margin-right:0.25rem;"></i>Unavailable</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ══ Recent Additions — 5 Items ══ --}}
        <section class="recent-section">
            <div class="section-label">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Recent Additions</span>
            </div>

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

            {{-- See More Button --}}
            @if($totalCount > 5)
                <div class="see-more-wrap">
                    <a href="{{ route('products.all') }}" class="btn btn-see-more" id="btn-see-more">
                        <span>View Full Collection</span>
                        <span class="see-more-count">{{ $totalCount }} pieces</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </section>

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
