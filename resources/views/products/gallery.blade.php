<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — Gallery — Mufti Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .gallery-item {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--border-vintage);
            background: var(--aged-paper);
            aspect-ratio: 1;
            cursor: zoom-in;
            box-shadow: 0 2px 10px var(--shadow-warm);
            transition: transform 0.22s, box-shadow 0.22s;
        }
        .gallery-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 22px var(--shadow-deep);
        }
        .gallery-item img {
            width: 100%; height: 100%;
            object-fit: cover; display: block;
        }
        .gallery-item-num {
            position: absolute; bottom: 6px; left: 8px;
            background: rgba(28,20,16,0.55);
            color: #faf5ec;
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.72rem; letter-spacing: 0.08em;
            padding: 0.15rem 0.5rem;
            border-radius: 3px;
            pointer-events: none;
        }
        .gallery-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--sepia-light);
            font-family: 'Cormorant Garamond', serif;
        }
        .gallery-empty i { font-size: 3rem; display: block; margin-bottom: 1rem; opacity: 0.4; }
        .gallery-empty p { font-size: 1.1rem; }

        /* Lightbox */
        .lb-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(14, 10, 6, 0.92);
            z-index: 9000;
            align-items: center;
            justify-content: center;
        }
        .lb-overlay.open { display: flex; }
        .lb-inner {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        .lb-img {
            max-width: 90vw;
            max-height: 80vh;
            object-fit: contain;
            border-radius: var(--radius);
            box-shadow: 0 8px 40px rgba(0,0,0,0.5);
        }
        .lb-close {
            position: absolute; top: -2.5rem; right: 0;
            background: none; border: none;
            color: #faf5ec; font-size: 1.5rem;
            cursor: pointer; opacity: 0.8;
            transition: opacity 0.2s;
        }
        .lb-close:hover { opacity: 1; }
        .lb-caption {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            color: #c8baa6;
            font-size: 0.95rem;
            letter-spacing: 0.04em;
        }
        .lb-nav {
            position: absolute;
            top: 50%; transform: translateY(-50%);
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #faf5ec;
            width: 2.5rem; height: 2.5rem;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1rem;
            transition: background 0.2s;
        }
        .lb-nav:hover { background: rgba(255,255,255,0.2); }
        .lb-prev { left: -4rem; }
        .lb-next { right: -4rem; }

        .product-meta-bar {
            background: var(--parchment);
            border: 1px solid var(--border-vintage);
            border-radius: var(--radius-lg);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        .product-meta-left { display: flex; flex-direction: column; gap: 0.3rem; }
        .product-meta-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; font-weight: 600;
            color: var(--sepia-text);
        }
        .product-meta-name em { font-style: italic; color: var(--crimson); }
        .product-meta-sub {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.9rem;
            color: var(--sepia-light);
            display: flex; align-items: center; gap: 0.75rem;
        }
        .img-count-badge {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--sepia-light);
            background: var(--aged-paper);
            border: 1px solid var(--border-vintage);
            padding: 0.2rem 0.65rem;
            border-radius: 999px;
        }
    </style>
</head>
<body>
@auth
    @if(auth()->user()->isAdmin())
        @include('partials.admin-nav')
    @else
        @include('partials.customer-nav')
    @endif
@else
    @include('partials.customer-nav')
@endauth
<div class="page-wrapper" style="padding-top:2rem;">

    {{-- Page header --}}
    <div class="page-titlebar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('catalog') }}"
               class="btn-back"><span class="arrow">←</span> Back</a>
            <div style="width:1px;height:24px;background:var(--border-vintage);flex-shrink:0;"></div>
            <h1><em>Gallery</em></h1>
        </div>
        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen-nib"></i> Edit Piece
            </a>
        @endif
    </div>

    {{-- Product meta --}}
    <div class="product-meta-bar">
        <div class="product-meta-left">
            <div class="product-meta-name">{{ $product->name }}</div>
            <div class="product-meta-sub">
                <span class="category-pill category-{{ $product->category }}">{{ str_replace('_', ' ', $product->category) }}</span>
                <span style="font-weight:600;color:var(--gold);">${{ number_format($product->price, 2) }}</span>
                @if($product->is_available)
                    <span class="badge badge-available" style="font-size:0.75rem;"><i class="fa-solid fa-circle" style="font-size:0.35rem;vertical-align:middle;margin-right:0.2rem;"></i>In Stock</span>
                @else
                    <span class="badge badge-unavailable" style="font-size:0.75rem;"><i class="fa-regular fa-circle" style="font-size:0.35rem;vertical-align:middle;margin-right:0.2rem;"></i>Unavailable</span>
                @endif
            </div>
        </div>
        <span class="img-count-badge">
            <i class="fa-regular fa-images" style="margin-right:0.3rem;"></i>
            {{ $product->images->count() }} {{ $product->images->count() === 1 ? 'photo' : 'photos' }}
        </span>
    </div>

    @if($product->images->isEmpty())
        <div class="gallery-empty">
            <i class="fa-regular fa-image"></i>
            <p>No photos have been added for this piece yet.</p>
        </div>
    @else
        <div class="gallery-grid">
            @foreach($product->images as $i => $img)
                <div class="gallery-item" onclick="openLightbox({{ $i }})">
                    <img src="{{ route('products.image.single', [$product, $img]) }}"
                         alt="{{ $product->name }} — photo {{ $loop->iteration }}"
                         loading="lazy">
                    <span class="gallery-item-num">{{ $loop->iteration }} / {{ $product->images->count() }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="ornament-divider" style="margin-top:3rem;"><span>✦</span></div>
    <p style="text-align:center;font-family:'IM Fell English',serif;font-style:italic;color:var(--sepia-light);font-size:0.88rem;letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>

</div>

{{-- Lightbox --}}
<div class="lb-overlay" id="lb">
    <div class="lb-inner" onclick="event.stopPropagation()">
        <button class="lb-close" onclick="closeLb()" title="Close"><i class="fa-solid fa-xmark"></i></button>
        <button class="lb-nav lb-prev" onclick="stepLb(-1)" title="Previous"><i class="fa-solid fa-chevron-left"></i></button>
        <img src="" alt="" class="lb-img" id="lb-img">
        <button class="lb-nav lb-next" onclick="stepLb(1)" title="Next"><i class="fa-solid fa-chevron-right"></i></button>
        <p class="lb-caption" id="lb-caption"></p>
    </div>
</div>

<script>
const imgs = [
    @foreach($product->images as $i => $img)
    { src: "{{ route('products.image.single', [$product, $img]) }}", caption: "{{ addslashes($product->name) }} — photo {{ $i + 1 }}" }{{ !$loop->last ? ',' : '' }}
    @endforeach
];
let current = 0;

function openLightbox(i) {
    current = i;
    render();
    document.getElementById('lb').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLb() {
    document.getElementById('lb').classList.remove('open');
    document.body.style.overflow = '';
}
function stepLb(dir) {
    current = (current + dir + imgs.length) % imgs.length;
    render();
}
function render() {
    document.getElementById('lb-img').src = imgs[current].src;
    document.getElementById('lb-caption').textContent = imgs[current].caption;
}
document.getElementById('lb').addEventListener('click', function(e) {
    if (e.target === this) closeLb();
});
document.addEventListener('keydown', e => {
    if (!document.getElementById('lb').classList.contains('open')) return;
    if (e.key === 'Escape') closeLb();
    else if (e.key === 'ArrowLeft')  stepLb(-1);
    else if (e.key === 'ArrowRight') stepLb(1);
});
</script>
</body>
</html>
