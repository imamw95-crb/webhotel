<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Booking - {{ $settings['meta_title'] ?? config('app.name', 'The Icon Hotel') }}</title>
    <meta name="description" content="Track your booking status at The Icon Hotel Kuningan">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Styles --}}
    @vite([
        'resources/css/design-system.css',
        'resources/css/animations.css',
        'resources/css/app.css',
    ])

    @stack('styles')
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg-page);
        }
        main {
            flex: 1;
        }

        /* === DECORATIVE BG === */
        .track-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image:
                radial-gradient(rgba(201, 168, 76, 0.05) 1px, transparent 1px),
                radial-gradient(circle at 20% 30%, rgba(201, 168, 76, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(201, 168, 76, 0.02) 0%, transparent 50%);
            background-size: 30px 30px, 100% 100%, 100% 100%;
        }

        /* === TRACK WRAPPER === */
        .track-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
            padding: 120px 16px 40px;
        }

        .track-card {
            width: 100%;
            max-width: 560px;
            background: var(--bg-surface);
            border: 1px solid var(--border-default);
            border-radius: var(--radius-xl);
            padding: 40px 36px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .track-card:hover {
            border-color: rgba(201, 168, 76, 0.15);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.4);
        }

        /* === ANIMATIONS === */
        @keyframes trackFadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes trackFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .track-header { animation: trackFadeUp 0.5s ease forwards; }
        .track-form { animation: trackFadeUp 0.5s ease 0.12s both; }
        .track-result { animation: trackFadeUp 0.5s ease 0.25s both; }

        /* === INPUT === */
        .track-input-wrap {
            position: relative;
            flex: 1;
        }
        .track-input-wrap .bm-input {
            padding: 14px 48px 14px 18px;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.02em;
            background: var(--bg-surface-2);
            border: 2px solid var(--border-default);
            border-radius: var(--radius-lg);
            transition: all 0.3s ease;
        }
        .track-input-wrap .bm-input::placeholder {
            color: var(--text-muted);
            font-weight: 400;
            font-size: 13px;
            opacity: 0.5;
        }
        .track-input-wrap .bm-input:focus {
            border-color: var(--gold-primary);
            background: #1e1e2e;
            box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.08), 0 0 24px rgba(201, 168, 76, 0.04);
        }
        .track-input-wrap .bm-input:focus::placeholder { opacity: 0.2; }
        .track-input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
            pointer-events: none;
            transition: color 0.3s;
        }
        .track-input-wrap .bm-input:focus ~ .track-input-icon { color: var(--gold-primary); }
        .track-input-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }
        .track-input-label span { color: var(--gold-primary); }
        .track-input-error {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #f87171;
            font-size: 13px;
            margin-top: 8px;
            padding: 8px 12px;
            background: rgba(248, 113, 113, 0.06);
            border: 1px solid rgba(248, 113, 113, 0.12);
            border-radius: var(--radius-md);
        }

        /* === BUTTONS === */
        .track-btn { transition: all 0.3s ease !important; }
        .track-btn:hover { transform: translateY(-1px) !important; box-shadow: 0 4px 20px rgba(201, 168, 76, 0.3) !important; }
        .track-btn:active { transform: translateY(0) !important; }

        .track-pay-btn { animation: trackFadeUp 0.5s ease 0.7s both; transition: all 0.3s ease !important; }
        .track-pay-btn:hover { transform: translateY(-2px) !important; box-shadow: 0 6px 24px rgba(201, 168, 76, 0.35) !important; }

        /* === RESULT === */
        .track-result-card {
            border: 1px solid var(--border-default) !important;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .track-result-card:hover {
            border-color: rgba(201, 168, 76, 0.2) !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
        }
        .track-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            animation: trackFadeIn 0.4s ease 0.4s both;
        }
        .track-detail-item { animation: trackFadeUp 0.4s ease both; }
        .track-detail-item:nth-child(1) { animation-delay: 0.3s; }
        .track-detail-item:nth-child(2) { animation-delay: 0.34s; }
        .track-detail-item:nth-child(3) { animation-delay: 0.38s; }
        .track-detail-item:nth-child(4) { animation-delay: 0.42s; }
        .track-detail-item:nth-child(5) { animation-delay: 0.46s; }
        .track-detail-item:nth-child(6) { animation-delay: 0.5s; }
        .track-detail-item:nth-child(7) { animation-delay: 0.54s; }
        .track-detail-item:nth-child(8) { animation-delay: 0.58s; }
        .track-detail-item:nth-child(9) { animation-delay: 0.62s; }

        .track-code-value {
            position: relative;
            display: inline-block;
        }
        .track-code-value::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold-primary), transparent);
            border-radius: 2px;
        }

        @media (max-width: 640px) {
            .track-card { padding: 28px 20px; }
            .track-wrapper { padding: 100px 12px 24px; }
        }
    </style>
</head>
<body>

    {{-- Simple Navbar --}}
    <nav class="navbar" style="position:fixed;">
        <div class="navbar-inner">
            <a href="/" class="navbar-logo">
                <img src="{{ asset('storage/' . ($settings['logo_path'] ?? 'logo/icon.png')) }}"
                     alt="The Icon Hotel"
                     class="h-10 w-auto rounded-lg object-cover shadow-lg">
            </a>
            <div class="nav-links">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
                <a href="{{ url('/') }}#rooms" class="nav-link">Rooms</a>
                <a href="{{ url('/') }}#facilities" class="nav-link">Facilities</a>
            </div>
            <div class="nav-right">
                <a href="{{ url('/') }}" class="btn-gold small">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer style="padding:24px 0;border-top:1px solid var(--border-default);background:var(--bg-surface);">
        <div class="section-container">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                <p style="color:var(--text-muted);font-size:13px;margin:0;">
                    &copy; {{ date('Y') }} {{ $settings['hotel_name'] ?? 'The Icon Hotel' }}. All rights reserved.
                </p>
                <a href="{{ url('/') }}" style="color:var(--gold-primary);font-size:13px;text-decoration:none;">
                    <i class="fa-solid fa-building"></i> Back to Home
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
