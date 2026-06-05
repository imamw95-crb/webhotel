<!DOCTYPE html>
{{-- ============================================================
   LAYOUT: APP — The Icon Hotel Kuningan
   Dark luxury with gold accent
   ============================================================ --}}
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['meta_title'] ?? config('app.name', 'The Icon Hotel') }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/logo/icon.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">

    {{-- Preload hero image for performance --}}
    <link rel="preload" as="image" href="{{ asset('storage/depanbanner/1.jpeg') }}" fetchpriority="high">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">

    {{-- Page Loader CSS (inline, loads before everything else) --}}
    <style>
    /* ---- Page Loader ---- */
    .page-loader {
        position: fixed; inset: 0; z-index: 999999;
        display: flex; align-items: center; justify-content: center;
        background: #09090f;
        transition: opacity 0.6s ease, visibility 0.6s ease;
    }
    .page-loader.loaded {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
    .loader-inner {
        display: flex; flex-direction: column; align-items: center;
        gap: 16px;
    }
    .loader-icon {
        width: 64px; height: 64px;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid rgba(201, 168, 76, 0.3);
        border-radius: 16px;
        color: #c9a84c;
        animation: loader-icon-pulse 1.4s ease-in-out infinite;
    }
    @keyframes loader-icon-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(201, 168, 76, 0.15); transform: scale(1); }
        50% { box-shadow: 0 0 24px 6px rgba(201, 168, 76, 0.1); transform: scale(1.04); }
    }
    .loader-brand {
        font-family: 'Cormorant Garamond', 'Times New Roman', serif;
        font-size: 28px; font-weight: 700; letter-spacing: 6px;
        color: #c9a84c;
    }
    .loader-sub {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 400; letter-spacing: 4px;
        color: #55555f; margin-top: -8px; text-transform: uppercase;
    }
    .loader-bar-track {
        width: 120px; height: 2px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 2px; overflow: hidden; margin-top: 8px;
    }
    .loader-bar-fill {
        height: 100%; width: 0;
        background: linear-gradient(90deg, #c9a84c, #e2c06a, #c9a84c);
        border-radius: 2px;
        animation: loader-bar-fill 1.2s ease-in-out infinite;
    }
    @keyframes loader-bar-fill {
        0%   { width: 0; margin-left: 0; }
        50%  { width: 100%; margin-left: 0; }
        100% { width: 0; margin-left: 100%; }
    }
    @media (prefers-reduced-motion: reduce) {
        .page-loader { transition-duration: 0.01ms; }
        .loader-icon, .loader-bar-fill { animation: none; }
        .loader-icon { box-shadow: 0 0 12px 4px rgba(201, 168, 76, 0.1); }
        .loader-bar-fill { width: 60%; }
        .page-loader.loaded { opacity: 0; visibility: hidden; }
    }
    </style>

    {{-- Styles --}}
    @vite([
        'resources/css/design-system.css',
        'resources/css/animations.css',
        'resources/css/app.css',
    ])

    {{-- Page-specific styles (from @push('styles')) --}}
    @stack('styles')
</head>
<body>

    {{-- ============================================================ --}}
    {{-- PAGE LOADER — Fades out when page is ready --}}
    {{-- ============================================================ --}}
    <div id="page-loader" class="page-loader" role="status" aria-label="Loading">
        <div class="loader-inner">
            {{-- Icon circle --}}
            <div class="loader-icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="2" width="28" height="28" rx="6" stroke="currentColor" fill="none"/>
                    <path d="M11 22V10l10 12V10" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            {{-- Hotel name --}}
            <div class="loader-brand">THE ICON</div>
            <div class="loader-sub">Kuningan</div>
            {{-- Loading bar --}}
            <div class="loader-bar-track">
                <div class="loader-bar-fill"></div>
            </div>
        </div>
    </div>
    {{-- /page-loader --}}

    <script>
    (function() {
        // Hide loader once page is fully loaded
        var hideLoader = function() {
            var loader = document.getElementById('page-loader');
            if (!loader) return;
            loader.classList.add('loaded');
            // Remove from DOM after transition
            setTimeout(function() {
                if (loader.parentNode) loader.parentNode.removeChild(loader);
            }, 800);
        };
        if (document.readyState === 'complete') {
            hideLoader();
        } else {
            window.addEventListener('load', hideLoader);
            // Fallback: if DOMContentLoaded fires and 2s passed, hide anyway
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    if (!document.querySelector('.page-loader.loaded')) hideLoader();
                }, 3000);
            });
        }
    })();
    </script>

    {{-- Skip to content (Accessibility) --}}
    <a href="#main-content" class="skip-to-content">
        Skip to main content
    </a>

    {{-- Navbar (included from hero partial) --}}
    @include('partials.hero')

    {{-- Main Content --}}
    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Booking Modal --}}
    @include('partials.booking-modal')

    {{-- Reading Progress Bar --}}
    <div id="reading-progress" class="progress-bar" role="progressbar" aria-label="Reading progress"></div>

    {{-- Back to Top Button --}}
    <button id="back-to-top" class="back-to-top" aria-label="Back to top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    {{-- WhatsApp Floating Button --}}
    @if($settings['whatsapp'] ?? false)
    <a href="https://api.whatsapp.com/send?phone={{ $settings['whatsapp'] }}&text={{ urlencode('Halo, saya ingin menanyakan kamar di ' . ($settings['hotel_name'] ?? 'The Icon Hotel')) }}"
       target="_blank"
       class="whatsapp-float"
       aria-label="WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    @endif

    {{-- Scripts --}}
    @vite([
        'resources/js/animations.js',
        'resources/js/app.js',
    ])

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>

@push('styles')
<style>
/* ---- WhatsApp Float ---- */
.whatsapp-float {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 999;
    width: 56px;
    height: 56px;
    background: #22c55e;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(34, 197, 94, 0.3);
    transition: all 0.3s ease;
    animation: whatsapp-pulse 2s ease-in-out infinite;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 30px rgba(34, 197, 94, 0.5);
}

@keyframes whatsapp-pulse {
    0%, 100% { box-shadow: 0 4px 20px rgba(34, 197, 94, 0.3); }
    50% { box-shadow: 0 4px 30px rgba(34, 197, 94, 0.5); }
}
</style>
@endpush
