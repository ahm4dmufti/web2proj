<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Piece — Mufti Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        .img-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.65rem;
            margin-bottom: 0.9rem;
        }
        .img-thumb {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border-vintage);
            background: var(--aged-paper);
            aspect-ratio: 1;
            transition: box-shadow 0.18s;
        }
        .img-thumb:hover { box-shadow: 0 3px 12px rgba(60,40,15,0.15); }
        .img-thumb img {
            width: 100%; height: 100%;
            object-fit: cover; display: block;
            cursor: zoom-in;
        }
        .img-thumb-del {
            position: absolute; top: 5px; right: 5px;
            background: rgba(139,26,26,0.82); color: #fff;
            border: none; border-radius: 50%;
            width: 1.5rem; height: 1.5rem;
            font-size: 0.72rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.18s, transform 0.15s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.25);
        }
        .img-thumb-del:hover { background: var(--crimson); transform: scale(1.12); }
        .img-thumb-del.loading { pointer-events: none; opacity: 0.6; }
        .img-thumb.removing {
            opacity: 0; transform: scale(0.85);
            transition: opacity 0.22s, transform 0.22s;
        }

        .img-drop-zone {
            border: 2px dashed var(--border-vintage);
            border-radius: var(--radius);
            padding: 1.4rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #fffef9;
            color: var(--sepia-light);
            font-family: 'Cormorant Garamond', serif;
        }
        .img-drop-zone:hover,
        .img-drop-zone.drag-over {
            border-color: var(--border-ornate);
            background: var(--aged-paper);
            color: var(--sepia-text);
        }
        .img-drop-zone i { font-size: 1.8rem; display: block; margin-bottom: 0.4rem; }
        .img-drop-zone strong { font-size: 1rem; display: block; }
        .img-drop-zone small { font-size: 0.78rem; opacity: 0.75; }

        .new-img-previews {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.65rem;
            margin-top: 0.65rem;
        }
        .new-img-preview {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border-ornate);
            background: var(--aged-paper);
            aspect-ratio: 1;
        }
        .new-img-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .new-img-preview-del {
            position: absolute; top: 5px; right: 5px;
            background: rgba(139,26,26,0.82); color: #fff;
            border: none; border-radius: 50%;
            width: 1.5rem; height: 1.5rem;
            font-size: 0.72rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.18s, transform 0.15s;
        }
        .new-img-preview-del:hover { background: var(--crimson); transform: scale(1.12); }

        .img-section-label {
            font-family: 'Cormorant Garamond', serif; font-size: 0.76rem;
            font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--sepia-light); margin: 0.75rem 0 0.5rem;
        }
        .img-count-hint { font-weight: 400; letter-spacing: 0; text-transform: none; font-size: 0.8rem; }

        .toast {
            position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
            background: #2a5e27; color: #fff; padding: 0.65rem 1.25rem;
            border-radius: var(--radius); font-family: 'Cormorant Garamond', serif;
            font-size: 1rem; box-shadow: 0 4px 16px rgba(0,0,0,0.2);
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
            z-index: 9999;
        }
        .toast.show { opacity: 1; }
        .toast.error { background: var(--crimson); }
    </style>
</head>
<body>
@include('partials.admin-nav')
<div class="page-wrapper" style="padding-top:2rem;">

    <div class="form-page">
        <div class="form-header">
            <a href="{{ route('products.index') }}" class="btn-back" id="btn-back-edit">
                <span class="arrow">←</span> Collection
            </a>
            <div style="width:1px;height:24px;background:var(--border-vintage);flex-shrink:0;"></div>
            <h1>Edit <em>Piece</em></h1>
        </div>

        <div class="form-card">

            {{-- ═══ MAIN EDIT FORM — NO nested forms inside ═══ --}}
            <form action="{{ route('products.update', $product) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="form-edit-product">
                @csrf
                @method('PUT')

                <div class="form-card-inner">

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Piece Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $product->name) }}"
                               placeholder="e.g. 19th Century Ottoman Vase"
                               required class="form-control">
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Category & Price --}}
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" required class="form-control">
                                <option value="painting"       {{ old('category', $product->category) == 'painting'       ? 'selected' : '' }}>Painting</option>
                                <option value="antique_piece"  {{ old('category', $product->category) == 'antique_piece'  ? 'selected' : '' }}>Antique Piece</option>
                                <option value="vase"           {{ old('category', $product->category) == 'vase'           ? 'selected' : '' }}>Vase</option>
                                <option value="handcraft"      {{ old('category', $product->category) == 'handcraft'      ? 'selected' : '' }}>Handcraft</option>
                                <option value="old_electronic" {{ old('category', $product->category) == 'old_electronic' ? 'selected' : '' }}>Old Electronic</option>
                            </select>
                            @error('category')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="price" class="form-label">Price (USD)</label>
                            <input type="number" step="0.01" min="0" name="price" id="price"
                                   value="{{ old('price', $product->price) }}"
                                   placeholder="0.00" required class="form-control">
                            @error('price')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="Provenance, era, material, condition…"
                                  class="form-control">{{ old('description', $product->description) }}</textarea>
                        @error('description')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- ── Photos ── --}}
                    <div class="form-group">
                        <label class="form-label">
                            Photos <span class="img-count-hint">(up to 10 — click ✕ on any to remove instantly)</span>
                        </label>

                        {{-- Existing saved images --}}
                        @if($product->images->isNotEmpty())
                            <div class="img-gallery" id="existing-gallery">
                                @foreach($product->images as $img)
                                    <div class="img-thumb" id="img-thumb-{{ $img->id }}">
                                        <img src="{{ route('products.image.single', [$product, $img]) }}"
                                             alt="Photo {{ $loop->iteration }}"
                                             onclick="openLightbox(this.src)">
                                        <button type="button"
                                                class="img-thumb-del"
                                                title="Remove this photo"
                                                data-id="{{ $img->id }}"
                                                data-url="{{ route('products.image.remove', [$product, $img]) }}"
                                                onclick="deleteImage(this)">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- New images to add --}}
                        <p class="img-section-label" style="margin-top:{{ $product->images->isNotEmpty() ? '1rem' : '0' }}">
                            Add New Photos
                        </p>
                        <div class="new-img-previews" id="new-previews"></div>
                        <div class="img-drop-zone" id="drop-zone">
                            <i class="fa-regular fa-images"></i>
                            <strong>Click or drag photos here</strong>
                            <small>JPEG, PNG, WebP — max 5 MB each</small>
                        </div>
                        <input type="file" name="images[]" id="images-input"
                               accept="image/*" multiple style="display:none;">

                        @error('images')<p class="field-error">{{ $message }}</p>@enderror
                        @error('images.*')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Availability --}}
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Availability</label>
                        <div class="availability-toggle">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" name="is_available" id="is_available" value="1"
                                   {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                            <label for="is_available">
                                <strong>Available for purchase</strong> — list this piece in the active collection
                            </label>
                        </div>
                    </div>

                </div>

                <div class="form-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="btn-submit-edit">
                        <i class="fa-solid fa-floppy-disk"></i> Update Piece
                    </button>
                </div>

            </form>
            {{-- ═══ END MAIN FORM ═══ --}}

        </div>
    </div>

    <div class="ornament-divider" style="margin-top:3rem;"><span>✦</span></div>
    <p style="text-align:center;font-family:'IM Fell English',serif;font-style:italic;color:var(--sepia-light);font-size:0.88rem;letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>

</div>

{{-- Lightbox --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fa-solid fa-xmark"></i></button>
    <img src="" alt="" class="lightbox-img" id="lightbox-img" onclick="event.stopPropagation()">
</div>

{{-- Toast notification --}}
<div class="toast" id="toast"></div>

<script>
/* ── Lightbox ── */
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').classList.add('lightbox--open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('lightbox--open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

/* ── Toast ── */
function showToast(msg, isError) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast show' + (isError ? ' error' : '');
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove('show'), 2800);
}

/* ── AJAX image delete ── */
async function deleteImage(btn) {
    const url  = btn.dataset.url;
    const id   = btn.dataset.id;
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    btn.classList.add('loading');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

    try {
        const res = await fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        });
        if (res.ok) {
            const thumb = document.getElementById('img-thumb-' + id);
            thumb.classList.add('removing');
            setTimeout(() => thumb.remove(), 230);
            showToast('Photo removed.');
        } else {
            btn.classList.remove('loading');
            btn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            showToast('Could not remove photo.', true);
        }
    } catch {
        btn.classList.remove('loading');
        btn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        showToast('Network error.', true);
    }
}

/* ── New image picker ── */
(function () {
    const input    = document.getElementById('images-input');
    const dropZone = document.getElementById('drop-zone');
    const previews = document.getElementById('new-previews');
    let   queue    = [];

    function openPicker() { input.click(); }
    dropZone.addEventListener('click', openPicker);

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        addFiles(Array.from(e.dataTransfer.files));
    });

    input.addEventListener('change', function () {
        const selected = Array.from(this.files);
        this.value = '';          // clear native selection BEFORE syncing queue
        addFiles(selected);       // adds to queue → render() → syncInput() runs last
    });

    function addFiles(list) {
        list.filter(f => f.type.startsWith('image/')).forEach(f => {
            if (queue.length < 10) queue.push(f);
        });
        render();
    }

    function removeNew(i) {
        queue.splice(i, 1);
        render();
    }

    function render() {
        previews.innerHTML = '';
        queue.forEach((file, i) => {
            const wrap = document.createElement('div');
            wrap.className = 'new-img-preview';

            const img = document.createElement('img');
            img.alt = file.name;
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; };
            reader.readAsDataURL(file);

            const del = document.createElement('button');
            del.type = 'button';
            del.className = 'new-img-preview-del';
            del.title = 'Remove';
            del.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            del.addEventListener('click', () => removeNew(i));

            wrap.appendChild(img);
            wrap.appendChild(del);
            previews.appendChild(wrap);
        });

        /* sync hidden file input */
        const dt = new DataTransfer();
        queue.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }
})();
</script>
</body>
</html>
