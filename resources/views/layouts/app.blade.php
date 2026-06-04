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

    {{-- Page-specific styles (from @push('styles')) --}}
    @stack('styles')
</head>
<body>

    {{-- Navbar (included from hero partial) --}}
    @include('partials.hero')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Booking Modal --}}
    @include('partials.booking-modal')

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
