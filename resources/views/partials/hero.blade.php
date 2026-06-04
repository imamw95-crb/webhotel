{{-- ============================================================
   PARTIAL: HERO — The Icon Hotel Kuningan
   Includes: Navbar, Hero Section, Availability Search Box
   ============================================================ --}}

@php
    $heroSettings = [
        'hotel_name' => 'THE ICON',
        'phone' => $settings['phone'] ?? '',
        'whatsapp' => $settings['whatsapp'] ?? '',
        'instagram_url' => $settings['instagram_url'] ?? '',
        'logo_path' => $settings['logo_path'] ?? 'logo/icon.png',
    ];
@endphp

{{-- ============================================ --}}
{{-- NAVBAR (#navbar) --}}
{{-- ============================================ --}}
<nav id="navbar" class="navbar">
    <div class="navbar-inner">
        {{-- Logo --}}
        <a href="/" class="navbar-logo">
            <img src="{{ asset('storage/' . $heroSettings['logo_path']) }}"
                 alt="{{ $heroSettings['hotel_name'] }}"
                 class="h-10 w-auto rounded-lg object-cover shadow-lg">
        </a>

        {{-- Desktop Links --}}
        <div class="nav-links">
            <a href="#hero" class="nav-link">Home</a>
            <a href="#about" class="nav-link">About</a>
            <a href="#rooms" class="nav-link">Rooms</a>
            <a href="#facilities" class="nav-link">Facilities</a>
            <a href="#explore-spaces" class="nav-link">Gallery</a>
            <a href="{{ route('booking.track') }}" class="nav-link">Track Booking</a>
        </div>

        {{-- Right Side --}}
        <div class="nav-right">
            @if($heroSettings['phone'])
                <span class="nav-phone">
                    <i class="fa-solid fa-phone"></i> {{ $heroSettings['phone'] }}
                </span>
            @endif
            <button type="button" class="btn-gold small" onclick="window.openBookingModal ? window.openBookingModal() : null">Book Now</button>
        </div>

        {{-- Hamburger (Mobile) --}}
        <button class="hamburger-btn" aria-label="Toggle menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 12h18M3 6h18M3 18h18"/>
            </svg>
        </button>
    </div>
</nav>

{{-- Mobile Overlay --}}
<div class="mobile-overlay"></div>

{{-- Mobile Menu --}}
<div class="mobile-menu">
    <div class="mobile-menu-inner">
        <a href="#hero" class="mobile-link">Home</a>
        <a href="#about" class="mobile-link">About</a>
        <a href="#rooms" class="mobile-link">Rooms</a>
        <a href="#facilities" class="mobile-link">Facilities</a>
        <a href="{{ route('booking.track') }}" class="mobile-link">Track Booking</a>
        <a href="#explore-spaces" class="mobile-link">Gallery</a>
        <div class="mobile-menu-divider"></div>
        <button type="button" class="btn-gold mobile-book-btn" onclick="window.openBookingModal ? window.openBookingModal() : null">Book Now</button>
    </div>
</div>

{{-- ============================================ --}}
{{-- HERO SECTION --}}
{{-- ============================================ --}}
<section id="hero" class="hero">
    {{-- Background Image with Parallax --}}
    <div class="hero-bg-img"
         style="background-image: url('{{ asset('storage/room-types/executive/IMG_20260315_154622_380.jpg') }}');">
    </div>
    <div class="hero-overlay"></div>

    {{-- Content --}}
    <div class="hero-content">
        <div class="hero-text">
            <span class="sec-label">The Icon Hotel Kuningan</span>
            <h1 class="hero-title">A Stay Worth<br>Remembering</h1>
            <p class="hero-subtitle">Experience unparalleled comfort and luxury in the heart of Kuningan. A 4-star hotel offering an unforgettable stay for both business and leisure travelers.</p>
            <div class="hero-buttons">
                <button type="button" class="btn-gold" onclick="window.openBookingModal ? window.openBookingModal() : null">Book Now <i class="fa-solid fa-calendar-check"></i></button>
                <a href="#explore-spaces" class="btn-ghost">View Gallery</a>
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="scroll-indicator bounce">
        <svg width="20" height="32" viewBox="0 0 20 32" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="1" y="1" width="18" height="30" rx="9" opacity="0.4"/>
            <circle cx="10" cy="10" r="2" fill="currentColor" class="scroll-dot"/>
        </svg>
    </div>
</section>

{{-- ============================================ --}}
{{-- AVAILABILITY SEARCH BOX --}}
{{-- ============================================ --}}
<div class="availability-wrapper">
    <div class="availability-box glass">
        <div class="av-field">
            <label class="sec-label">Check-in</label>
            <input type="date" class="av-input" id="av-checkin"
                   min="{{ date('Y-m-d') }}"
                   value="{{ old('check_in', date('Y-m-d')) }}">
        </div>
        <div class="av-divider"></div>
        <div class="av-field">
            <label class="sec-label">Check-out</label>
            <input type="date" class="av-input" id="av-checkout"
                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                   value="{{ old('check_out', date('Y-m-d', strtotime('+1 day'))) }}">
        </div>
        <div class="av-divider"></div>
        <div class="av-field">
            <label class="sec-label">Guests</label>
            <select class="av-input" id="av-guests">
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ old('guests', 2) == $i ? 'selected' : '' }}>{{ $i }} {{ $i > 1 ? 'Adults' : 'Adult' }}</option>
                @endfor
            </select>
        </div>
        <div class="av-divider"></div>
        <div class="av-field av-action">
            <a href="#rooms" class="btn-gold av-search-btn" id="av-search-btn">Search</a>
        </div>
    </div>
</div>

