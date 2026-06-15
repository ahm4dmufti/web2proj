<nav class="admin-navbar">
    <div class="admin-navbar-inner">

        {{-- Brand --}}
        <a href="{{ route('catalog') }}" class="admin-brand">
            <img src="{{ asset('images/muftigallery-logo.png') }}"
                 alt="Mufti Gallery" class="admin-brand-logo">
            <div class="admin-brand-text">
                <span class="admin-brand-name">Mufti Gallery</span>
                <span class="admin-brand-sub">Antiques &amp; Rarities</span>
            </div>
        </a>

        <div class="admin-nav-sep"></div>

        {{-- Primary nav links --}}
        <div class="admin-nav-links">
            <a href="{{ route('catalog') }}"
               class="admin-nav-link {{ request()->routeIs('catalog') ? 'is-active' : '' }}">
                <i class="fa-solid fa-store"></i>
                Browse
            </a>
            @auth
                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('cart.index') }}"
                       class="admin-nav-link {{ request()->routeIs('cart.*') ? 'is-active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Cart
                        @isset($cartCount)
                            @if($cartCount > 0)
                                <span class="admin-nav-badge">{{ $cartCount }}</span>
                            @endif
                        @endisset
                    </a>
                    <a href="{{ route('orders.index') }}"
                       class="admin-nav-link {{ request()->routeIs('orders.*') ? 'is-active' : '' }}">
                        <i class="fa-solid fa-box-open"></i>
                        My Orders
                    </a>
                @else
                    <a href="{{ route('products.index') }}"
                       class="admin-nav-link">
                        <i class="fa-solid fa-gauge"></i>
                        Admin Dashboard
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                       class="admin-nav-link">
                        <i class="fa-solid fa-inbox"></i>
                        Orders
                    </a>
                @endif
            @endauth
        </div>

        <div class="admin-nav-spacer"></div>

        {{-- Right actions --}}
        <div class="admin-nav-actions">
            @guest
                <a href="{{ route('login') }}" class="admin-nav-site-link">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Log In
                </a>
                <a href="{{ route('register') }}" class="admin-nav-register-btn">
                    <i class="fa-solid fa-user-plus"></i>
                    Register
                </a>
            @endguest
            @auth
                <form method="POST" action="/logout" style="margin:0;line-height:1;">
                    @csrf
                    <button type="submit" class="admin-logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            @endauth
        </div>

    </div>
</nav>
