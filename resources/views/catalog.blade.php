<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mufti Gallery — Browse Our Collection</title>
    <meta name="description" content="Browse the curated collection of antiques, paintings, and handcrafts at Mufti Gallery.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        /* ── Action cart button ── */
        .action-cart {
            background: var(--crimson); border: none; color: #faf5ec; cursor: pointer;
        }
        .action-cart:hover { background: var(--crimson-hover); }
        .action-login {
            background: transparent; border: 1px solid var(--gold);
            color: var(--gold); text-decoration: none;
        }
        .action-login:hover { background: var(--gold-pale); }
        .action-unavailable {
            background: transparent; border: 1px solid var(--border-vintage);
            color: #bbb; cursor: not-allowed; opacity: 0.5;
        }
        /* ── Featured card add-to-cart ── */
        .featured-card-action { margin-top: 1rem; }
        .btn-add-cart {
            display: inline-flex; align-items: center; gap: 0.45rem;
            font-family: 'Cormorant Garamond', serif; font-size: 0.9rem;
            font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
            padding: 0.55rem 1.35rem; border-radius: var(--radius);
            background: var(--crimson); border: 1px solid var(--crimson);
            color: #faf5ec; cursor: pointer; transition: all 0.22s ease;
        }
        .btn-add-cart:hover { background: var(--crimson-hover); border-color: var(--crimson-hover); transform: translateY(-1px); }
        .btn-login-to-buy {
            display: inline-flex; align-items: center; gap: 0.45rem;
            font-family: 'Cormorant Garamond', serif; font-size: 0.9rem;
            font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase;
            padding: 0.55rem 1.35rem; border-radius: var(--radius);
            background: transparent; border: 1px solid var(--gold);
            color: var(--gold); text-decoration: none; transition: all 0.22s ease;
        }
        .btn-login-to-buy:hover { background: var(--gold-pale); }
        /* ── Flash error ── */
        .flash-error {
            display: flex; align-items: center; gap: 0.85rem;
            background: var(--crimson-soft); border: 1px solid #d4a0a0;
            border-left: 4px solid var(--crimson); color: var(--crimson);
            padding: 0.9rem 1.35rem; border-radius: var(--radius); margin-bottom: 2rem;
            font-size: 1rem; font-weight: 500;
        }
    </style>
</head>
<body>
@include('partials.customer-nav')

{{-- ══ Hero / Landing ══ --}}
<div class="page-wrapper" style="padding-top:2rem;">
    <section class="hero-section reveal">
        <div class="hero-eyebrow"><i class="fa-solid fa-gem"></i> Est. since the heart of the old quarter</div>
        <h1 class="hero-title">Welcome to <em>Mufti Gallery</em></h1>
        <p class="hero-subtitle">
            A sanctuary for antiques, fine paintings, vases, and handcrafted treasures —
            each piece chosen with care, carrying its own story into your home.
        </p>
        <div class="hero-actions">
            <a href="#collection" class="btn-hero-primary">
                <i class="fa-solid fa-layer-group"></i> Explore the Collection
            </a>
            <a href="#about" class="btn-hero-secondary">
                <i class="fa-solid fa-feather"></i> Our Story
            </a>
        </div>
    </section>

    {{-- ══ About Us ══ --}}
    <section id="about" class="story-section reveal">
        <div class="story-grid">
            <div class="story-text">
                <div class="section-label">
                    <i class="fa-solid fa-feather"></i>
                    <span>About Us</span>
                </div>
                <h2>Caretakers of Forgotten Beauty</h2>
                <p>
                    Mufti Gallery began as a small family passion for rescuing beautiful,
                    overlooked objects — pieces that carried craftsmanship and character
                    but had been forgotten by time. What started as a personal collection
                    slowly grew into a curated gallery for fellow lovers of fine antiques,
                    paintings, vases, and handcrafted treasures.
                </p>
                <p>
                    Every item in our collection is hand-selected, inspected, and restored
                    where needed, so that what reaches you carries both its history and a
                    renewed sense of life. We believe a home is made richer by objects with
                    a story — and we're honored to help you find yours.
                </p>
            </div>
            <div class="story-stats">
                <div class="stat-card reveal reveal-delay-1">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Pieces Curated</span>
                </div>
                <div class="stat-card reveal reveal-delay-2">
                    <span class="stat-number">5</span>
                    <span class="stat-label">Categories</span>
                </div>
                <div class="stat-card reveal reveal-delay-1">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Hand-Picked</span>
                </div>
                <div class="stat-card reveal reveal-delay-2">
                    <span class="stat-number">1</span>
                    <span class="stat-label">Passion, Endless Stories</span>
                </div>
            </div>
        </div>
    </section>

    <div class="ornament-divider"><span>✦</span></div>

    {{-- ══ Our History ══ --}}
    <section class="history-section reveal">
        <div class="history-header">
            <div class="section-label center">
                <i class="fa-solid fa-scroll"></i>
                <span>Our History</span>
            </div>
            <h2>A Legacy Built Piece by Piece</h2>
            <p>From a single shelf of curiosities to a full gallery — here's how our story unfolded.</p>
        </div>
        <div class="timeline">
            <div class="timeline-item reveal">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <span class="timeline-year">The Beginning</span>
                    <h3>A Small Collection, A Big Passion</h3>
                    <p>
                        It started with a handful of antiques and paintings gathered from
                        estate sales and old family homes — kept not to sell, but simply
                        because they were too beautiful to let go.
                    </p>
                </div>
            </div>
            <div class="timeline-item reveal reveal-delay-1">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <span class="timeline-year">Opening Our Doors</span>
                    <h3>Mufti Gallery Welcomes Its First Visitors</h3>
                    <p>
                        As the collection grew, so did interest from friends and visitors.
                        What was once a private hobby became a gallery, open for others
                        to browse, admire, and bring a piece of history home.
                    </p>
                </div>
            </div>
            <div class="timeline-item reveal reveal-delay-2">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <span class="timeline-year">Growing the Collection</span>
                    <h3>Expanding Beyond Antiques</h3>
                    <p>
                        We broadened our reach to include vases, handcrafted goods, and
                        vintage electronics — always with the same standard of care and
                        curation that started it all.
                    </p>
                </div>
            </div>
            <div class="timeline-item reveal reveal-delay-3">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <span class="timeline-year">Today</span>
                    <h3>A Home for Every Treasure</h3>
                    <p>
                        Today, Mufti Gallery continues that same tradition online —
                        bringing our curated collection to a wider audience while
                        keeping every piece as personal as the day it was found.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="ornament-divider"><span>✦</span></div>

    {{-- ══ Page Title ══ --}}
    <div class="page-titlebar reveal" id="collection">
        <h1><em>Our</em> Collection</h1>
    </div>

    {{-- ══ Flash Messages ══ --}}
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

    @php $totalCount = array_sum($categoryCounts->toArray()); @endphp

    @if($totalCount === 0)
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-scroll"></i></div>
            <h3>No Pieces Available Yet</h3>
            <p>Check back soon as we add new pieces to our curated gallery.</p>
        </div>
    @else

        {{-- ══ Featured — Top 3 Most Expensive ══ --}}
        @if(! $category && $featured->isNotEmpty())
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
                        <div class="featured-card">
                            <div class="featured-rank">{{ $rankLabel }}</div>
                            @if($piece->images->isNotEmpty())
                                <div class="featured-img-wrap">
                                    <img src="{{ route('products.image', $piece) }}"
                                         alt="{{ $piece->name }}"
                                         class="featured-img"
                                         onclick="openLightbox(this.src, '{{ addslashes($piece->name) }}')"
                                         title="Click to enlarge">
                                </div>
                            @else
                                <div class="featured-icon"><i class="{{ $catIcon }}"></i></div>
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
                                <span class="badge badge-available">
                                    <i class="fa-solid fa-circle" style="font-size:0.35rem;vertical-align:middle;margin-right:0.25rem;"></i>In Stock
                                </span>
                            @else
                                <span class="badge badge-unavailable">
                                    <i class="fa-regular fa-circle" style="font-size:0.35rem;vertical-align:middle;margin-right:0.25rem;"></i>Unavailable
                                </span>
                            @endif
                            <div class="featured-card-action">
                                @auth
                                    @if(auth()->user()->isCustomer() && $piece->is_available)
                                        <form action="{{ route('cart.add', $piece) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-add-cart">
                                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if($piece->is_available)
                                        <a href="{{ route('login') }}" class="btn-login-to-buy">
                                            <i class="fa-solid fa-right-to-bracket"></i> Login to Purchase
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
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
                'painting'       => ['label' => 'Painting',       'icon' => 'fa-palette'],
                'antique_piece'  => ['label' => 'Antique Piece',  'icon' => 'fa-gem'],
                'vase'           => ['label' => 'Vase',           'icon' => 'fa-wine-glass'],
                'handcraft'      => ['label' => 'Handcraft',      'icon' => 'fa-scissors'],
                'old_electronic' => ['label' => 'Old Electronic', 'icon' => 'fa-tv'],
            ];
        @endphp
        <div class="filter-bar">
            <a href="{{ route('catalog') }}" class="filter-pill {{ ! $category ? 'filter-pill--active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> All
                <span class="filter-count">{{ $totalCount }}</span>
            </a>
            @foreach($categories as $value => $meta)
                <a href="{{ route('catalog', ['category' => $value]) }}"
                   class="filter-pill filter-pill--{{ $value }} {{ $category === $value ? 'filter-pill--active' : '' }}">
                    <i class="fa-solid {{ $meta['icon'] }}"></i>
                    {{ $meta['label'] }}
                    @if($categoryCounts->get($value, 0) > 0)
                        <span class="filter-count">{{ $categoryCounts->get($value, 0) }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- ══ Products Table ══ --}}
        @if($products->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-scroll"></i></div>
                <h3>No Pieces in This Category</h3>
                <p>Try browsing a different category.</p>
            </div>
        @else
            <div class="inventory-table-wrap">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th class="th-num">#</th>
                            <th class="th-photo">Photo</th>
                            <th class="th-name">Piece Name</th>
                            <th class="th-category">Category</th>
                            <th class="th-price">Price</th>
                            <th class="th-status">Status</th>
                            <th class="th-actions">Purchase</th>
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
                            <tr class="inventory-row">
                                <td class="td-num">{{ $index + 1 }}</td>
                                <td class="td-photo">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ route('products.image', $product) }}"
                                             alt="{{ $product->name }}"
                                             class="table-thumb"
                                             onclick="openLightbox(this.src, '{{ addslashes($product->name) }}')"
                                             title="Click to enlarge">
                                    @else
                                        <span class="table-thumb-empty"><i class="{{ $catIcon }}"></i></span>
                                    @endif
                                </td>
                                <td class="td-name">
                                    <div class="piece-name-group">
                                        <strong class="piece-name">{{ $product->name }}</strong>
                                        @if($product->description)
                                            <p class="piece-desc">{{ Str::limit($product->description, 60) }}</p>
                                        @endif
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
                                        @auth
                                            @if(auth()->user()->isCustomer())
                                                @if($product->is_available)
                                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="action-btn action-cart" title="Add to Cart">
                                                            <i class="fa-solid fa-cart-plus"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="action-btn action-unavailable" title="Unavailable">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </span>
                                                @endif
                                            @endif
                                        @else
                                            @if($product->is_available)
                                                <a href="{{ route('login') }}" class="action-btn action-login" title="Log in to purchase">
                                                    <i class="fa-solid fa-right-to-bracket"></i>
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

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

// Smooth scroll-reveal animations
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

document.querySelectorAll('.reveal, .timeline-item').forEach(el => revealObserver.observe(el));
</script>
</body>
</html>
