<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Piece — Mufti Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
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

        .img-previews {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.65rem;
            margin-bottom: 0.65rem;
        }
        .img-preview-item {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border-ornate);
            background: var(--aged-paper);
            aspect-ratio: 1;
        }
        .img-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .img-preview-del {
            position: absolute; top: 5px; right: 5px;
            background: rgba(139,26,26,0.82); color: #fff;
            border: none; border-radius: 50%;
            width: 1.5rem; height: 1.5rem;
            font-size: 0.72rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.18s, transform 0.15s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.22);
        }
        .img-preview-del:hover { background: var(--crimson); transform: scale(1.12); }
        .img-count-hint { font-size: 0.8rem; color: var(--sepia-light); font-family: 'Cormorant Garamond', serif; }
    </style>
</head>
<body>
@include('partials.admin-nav')
<div class="page-wrapper" style="padding-top:2rem;">

    <div class="form-page">
        <div class="form-header">
            <a href="{{ route('products.index') }}" class="btn-back" id="btn-back-create">
                <span class="arrow">←</span> Collection
            </a>
            <div class="ornament-divider" style="flex:0;width:1px;height:24px;margin:0;background:var(--border-vintage);"></div>
            <h1>Add New <em>Piece</em></h1>
        </div>

        <div class="form-card">
            <form action="{{ route('products.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="form-create-product">
                @csrf

                <div class="form-card-inner">

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Piece Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               placeholder="e.g. 19th Century Ottoman Vase"
                               required class="form-control">
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Category & Price --}}
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" required class="form-control">
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select category…</option>
                                <option value="painting"       {{ old('category') == 'painting'       ? 'selected' : '' }}>Painting</option>
                                <option value="antique_piece"  {{ old('category') == 'antique_piece'  ? 'selected' : '' }}>Antique Piece</option>
                                <option value="vase"           {{ old('category') == 'vase'           ? 'selected' : '' }}>Vase</option>
                                <option value="handcraft"      {{ old('category') == 'handcraft'      ? 'selected' : '' }}>Handcraft</option>
                                <option value="old_electronic" {{ old('category') == 'old_electronic' ? 'selected' : '' }}>Old Electronic</option>
                            </select>
                            @error('category')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="price" class="form-label">Price (USD)</label>
                            <input type="number" step="0.01" min="0" name="price" id="price"
                                   value="{{ old('price') }}" placeholder="0.00"
                                   required class="form-control">
                            @error('price')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="Provenance, era, material, condition…"
                                  class="form-control">{{ old('description') }}</textarea>
                        @error('description')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Photos --}}
                    <div class="form-group">
                        <label class="form-label">
                            Photos <span class="img-count-hint">(up to 10 images)</span>
                        </label>
                        <div class="img-previews" id="img-previews"></div>
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
                                   {{ old('is_available', '1') == '1' ? 'checked' : '' }}>
                            <label for="is_available">
                                <strong>Available for purchase</strong> — list this piece in the active collection
                            </label>
                        </div>
                    </div>

                </div>

                <div class="form-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost" id="btn-cancel-create">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" id="btn-submit-create">
                        <i class="fa-solid fa-floppy-disk"></i> Save Piece
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="ornament-divider" style="margin-top:3rem;"><span>✦</span></div>
    <p style="text-align:center;font-family:'IM Fell English',serif;font-style:italic;color:var(--sepia-light);font-size:0.88rem;letter-spacing:0.06em;">
        © {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved
    </p>

</div>

<script>
(function () {
    const input    = document.getElementById('images-input');
    const dropZone = document.getElementById('drop-zone');
    const previews = document.getElementById('img-previews');
    let   queue    = [];

    dropZone.addEventListener('click', () => input.click());

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

    function removeFile(i) {
        queue.splice(i, 1);
        render();
    }

    function render() {
        previews.innerHTML = '';
        queue.forEach((file, i) => {
            const wrap = document.createElement('div');
            wrap.className = 'img-preview-item';

            const img = document.createElement('img');
            img.alt = file.name;
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; };
            reader.readAsDataURL(file);

            const del = document.createElement('button');
            del.type = 'button';
            del.className = 'img-preview-del';
            del.title = 'Remove';
            del.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            del.addEventListener('click', () => removeFile(i));

            wrap.appendChild(img);
            wrap.appendChild(del);
            previews.appendChild(wrap);
        });

        const dt = new DataTransfer();
        queue.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }
})();
</script>
</body>
</html>
