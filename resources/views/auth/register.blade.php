<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Mufti Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }
        .brand-logo {
            height: 96px;
            width: auto;
            filter: drop-shadow(0 3px 12px rgba(60, 30, 10, 0.2));
            transition: transform 0.4s ease;
        }
        .brand-logo:hover { transform: scale(1.03); }
        .brand-tagline {
            font-family: 'IM Fell English', Georgia, serif;
            font-style: italic;
            font-size: 0.95rem;
            color: var(--sepia-light);
            letter-spacing: 0.09em;
            margin: 0;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: var(--parchment);
            border: 1px solid var(--border-vintage);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2.75rem;
            box-shadow: 0 8px 40px rgba(60, 40, 15, 0.12), 0 2px 8px rgba(60, 40, 15, 0.08);
            position: relative;
            overflow: hidden;
        }
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), var(--border-ornate), var(--gold), transparent);
        }

        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            font-weight: 600;
            color: var(--sepia-text);
            text-align: center;
            margin-bottom: 0.3rem;
        }
        .auth-title em { font-style: italic; color: var(--crimson); }

        .auth-subtitle {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.92rem;
            color: var(--sepia-light);
            text-align: center;
            letter-spacing: 0.04em;
            margin-bottom: 2rem;
        }

        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--sepia-light);
            margin-bottom: 0.45rem;
        }
        .form-input {
            width: 100%;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            padding: 0.7rem 1rem;
            border: 1px solid var(--border-vintage);
            background: #fffef9;
            color: var(--sepia-text);
            border-radius: var(--radius);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--border-ornate);
            box-shadow: 0 0 0 3px rgba(196, 169, 106, 0.2);
        }
        .form-input.is-invalid {
            border-color: var(--crimson);
            box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.12);
        }
        .field-error {
            margin-top: 0.35rem;
            font-size: 0.85rem;
            color: var(--crimson);
            font-family: 'Cormorant Garamond', serif;
        }
        .field-error i { margin-right: 0.25rem; font-size: 0.78rem; }

        .btn-register {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.8rem 1.5rem;
            border-radius: var(--radius);
            cursor: pointer;
            background: var(--crimson);
            border: 1px solid var(--crimson);
            color: #faf5ec;
            box-shadow: 0 2px 10px rgba(139, 26, 26, 0.28);
            transition: all 0.25s ease;
            margin-bottom: 1.5rem;
        }
        .btn-register:hover {
            background: var(--crimson-hover);
            border-color: var(--crimson-hover);
            box-shadow: 0 4px 18px rgba(139, 26, 26, 0.38);
            transform: translateY(-1px);
        }
        .btn-register:active { transform: translateY(0); }

        .auth-divider {
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: 1.25rem; color: var(--border-ornate);
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px;
            background: var(--border-vintage);
        }
        .auth-divider span { font-size: 0.9rem; color: var(--gold); flex-shrink: 0; }

        .login-prompt {
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.97rem;
            color: var(--sepia-light);
        }
        .login-link {
            color: var(--crimson);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .login-link:hover { color: var(--crimson-hover); text-decoration: underline; }

        .auth-footer {
            margin-top: 2rem;
            font-family: 'IM Fell English', serif;
            font-style: italic;
            font-size: 0.82rem;
            color: var(--sepia-light);
            text-align: center;
            letter-spacing: 0.04em;
        }
    </style>
</head>
<body>

    <a href="{{ route('catalog') }}" class="brand">
        <img src="{{ asset('images/muftigallery-logo.png') }}" alt="Mufti Gallery" class="brand-logo">
        <p class="brand-tagline">A Curated Collection of Rare & Timeless Pieces</p>
    </a>

    <div class="auth-card">

        <h1 class="auth-title"><em>Create</em> Your Account</h1>
        <p class="auth-subtitle">Join Mufti Gallery to browse & purchase</p>

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input id="name"
                       type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       placeholder="Your full name"
                       autocomplete="name"
                       autofocus
                       required>
                @error('name')
                    <p class="field-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       placeholder="your@email.com"
                       autocomplete="email"
                       required>
                @error('email')
                    <p class="field-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password"
                       type="password"
                       name="password"
                       class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       placeholder="At least 8 characters"
                       autocomplete="new-password"
                       required>
                @error('password')
                    <p class="field-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                       placeholder="Repeat your password"
                       autocomplete="new-password"
                       required>
                @error('password_confirmation')
                    <p class="field-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-register">
                <i class="fa-solid fa-user-plus"></i> Create Account
            </button>

            <div class="auth-divider"><span>✦</span></div>
            <p class="login-prompt">
                Already have an account?&ensp;
                <a href="{{ route('login') }}" class="login-link">Sign in</a>
            </p>
        </form>
    </div>

    <p class="auth-footer">© {{ date('Y') }} Mufti Gallery for Antiques &mdash; All Rights Reserved</p>

</body>
</html>
