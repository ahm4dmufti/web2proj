<nav class="admin-navbar">
    <div class="admin-navbar-inner">

        {{-- Brand --}}
        <a href="{{ route('products.index') }}" class="admin-brand">
            <img src="{{ asset('images/muftigallery-logo.png') }}"
                 alt="Mufti Gallery" class="admin-brand-logo">
            <div class="admin-brand-text">
                <span class="admin-brand-name">Mufti Gallery</span>
                <span class="admin-brand-sub">Administration</span>
            </div>
        </a>

        <div class="admin-nav-sep"></div>

        {{-- Primary nav links --}}
        <div class="admin-nav-links">
            <a href="{{ route('products.index') }}"
               class="admin-nav-link {{ request()->routeIs('products.index','products.all','products.create','products.edit','products.gallery') ? 'is-active' : '' }}">
                <i class="fa-solid fa-layer-group"></i>
                Products
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}">
                <i class="fa-solid fa-inbox"></i>
                Orders
            </a>
        </div>

        <div class="admin-nav-spacer"></div>

        {{-- Right actions --}}
        <div class="admin-nav-actions">
            <a href="{{ route('catalog') }}" class="admin-nav-site-link" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                View Site
            </a>
            <form method="POST" action="/logout" style="margin:0;line-height:1;">
                @csrf
                <button type="submit" class="admin-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>

    </div>
</nav>
