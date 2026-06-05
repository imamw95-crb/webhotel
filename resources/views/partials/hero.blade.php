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
        <button class="hamburger-btn" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 12h18M3 6h18M3 18h18"/>
            </svg>
        </button>
    </div>
</nav>

{{-- Mobile Overlay --}}
<div class="mobile-overlay"></div>

{{-- Mobile Menu --}}
<div id="mobile-menu" class="mobile-menu" role="dialog" aria-modal="true" aria-label="Navigation menu">
    <div class="mobile-menu-inner">
        <div class="mobile-menu-header">
            <span class="text-gold-400 font-display text-lg font-semibold">Menu</span>
            <button class="mobile-close-btn" aria-label="Close menu">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
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
{{-- HERO SECTION WITH SLIDER --}}
{{-- ============================================ --}}
@php
    $heroSlides = [
        [
            'image'   => 'depanbanner/1.jpeg',
            'label'   => 'The Icon Hotel Kuningan',
            'title'   => 'A Stay Worth<br>Remembering',
            'desc'    => 'Experience unparalleled comfort and luxury in the heart of Kuningan. A 4-star hotel offering an unforgettable stay for both business and leisure travelers.',
        ],
        [
            'image'   => 'depanbanner/2.jpg',
            'label'   => 'Premium Accommodation',
            'title'   => 'Experience<br>Luxury Living',
            'desc'    => 'Our executive rooms and suites offer stunning views, premium amenities, and the finest comfort for discerning guests.',
        ],
        [
            'image'   => 'depanbanner/3.jpg',
            'label'   => 'Relax & Rejuvenate',
            'title'   => 'Your Home<br>Away From Home',
            'desc'    => 'Enjoy our facilities and warm hospitality designed to make your stay truly memorable.',
        ],
        [
            'image'   => 'depanbanner/4.jpg',
            'label'   => 'Book Your Stay',
            'title'   => 'Experience<br>The Icon',
            'desc'    => 'Book your stay today and discover the perfect blend of comfort, luxury, and warm hospitality.',
        ],
    ];
@endphp

<section id="hero" class="hero hero-slider" aria-roledescription="carousel" aria-label="Hotel highlights">
    {{-- Slides --}}
    <div class="hero-slides-track" id="hero-slides-track">
        @foreach($heroSlides as $index => $slide)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                 role="group"
                 aria-roledescription="slide"
                 aria-label="{{ $index + 1 }} of {{ count($heroSlides) }}: {{ strip_tags($slide['title']) }}">
                <div class="hero-slide-bg {{ $index === 0 ? 'ken-burns' : '' }}"
                     style="background-image: url('{{ asset('storage/' . $slide['image']) }}');"
                     role="img"
                     aria-label="{{ strip_tags($slide['title']) }} — {{ $slide['label'] }}">
                </div>
            </div>
        @endforeach
    </div>

    {{-- Overlay --}}
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>

    {{-- Content (per slide) --}}
    <div class="hero-content">
        @foreach($heroSlides as $index => $slide)
            <div class="hero-text {{ $index === 0 ? 'active' : '' }}"
                 data-slide="{{ $index }}"
                 aria-hidden="{{ $index !== 0 ? 'true' : 'false' }}">
                <span class="sec-label">{{ $slide['label'] }}</span>
                <h1 class="hero-title gradient-gold">{!! $slide['title'] !!}</h1>
                <p class="hero-subtitle">{{ $slide['desc'] }}</p>
                <div class="hero-buttons">
                    <button type="button" class="btn-gold" onclick="window.openBookingModal ? window.openBookingModal() : null">Book Now <i class="fa-solid fa-calendar-check"></i></button>
                    <a href="#explore-spaces" class="btn-ghost">View Gallery</a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Navigation Arrows --}}
    <button type="button" class="hero-slider-arrow hero-arrow-prev" aria-label="Previous slide">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button type="button" class="hero-slider-arrow hero-arrow-next" aria-label="Next slide">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    {{-- Dots --}}
    <div class="hero-slider-dots" role="tablist" aria-label="Slide navigation">
        @foreach($heroSlides as $index => $slide)
            <button type="button"
                    class="hero-dot {{ $index === 0 ? 'active' : '' }}"
                    role="tab"
                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}: {{ strip_tags($slide['title']) }}"
                    data-slide="{{ $index }}">
            </button>
        @endforeach
    </div>

    {{-- Scroll Indicator --}}
    <div class="scroll-indicator bounce">
        <svg width="20" height="32" viewBox="0 0 20 32" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="1" y="1" width="18" height="30" rx="9" opacity="0.4"/>
            <circle cx="10" cy="10" r="2" fill="currentColor" class="scroll-dot"/>
        </svg>
    </div>
</section>

{{-- Push slider keyframes (can't be in CSS file) --}}
@push('styles')
<style>
@keyframes heroContentIn {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes heroContentOut {
    from { opacity: 1; transform: translateY(0); }
    to   { opacity: 0; transform: translateY(-20px); }
}
</style>
@endpush

{{-- Push slider JS --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track  = document.getElementById('hero-slides-track');
    if (!track) return;

    const slides    = track.querySelectorAll('.hero-slide');
    const texts     = document.querySelectorAll('.hero-text[data-slide]');
    const dots      = document.querySelectorAll('.hero-dot');
    const prevBtn   = document.querySelector('.hero-arrow-prev');
    const nextBtn   = document.querySelector('.hero-arrow-next');
    const total     = slides.length;
    let current     = 0;
    let autoplayTimer = null;
    const interval  = 5000; // 5 seconds

    function goTo(index) {
        if (index === current) return;
        if (index < 0) index = total - 1;
        if (index >= total) index = 0;

        // Exit current text
        texts.forEach(t => {
            if (parseInt(t.dataset.slide) === current) {
                t.classList.remove('active');
                t.classList.add('exit');
                t.setAttribute('aria-hidden', 'true');
            }
        });

        // Remove active from current slide
        slides[current].classList.remove('active');
        // Remove ken-burns from current bg
        const currentBg = slides[current].querySelector('.hero-slide-bg');
        if (currentBg) currentBg.classList.remove('ken-burns');

        // Set new slide active (crossfade via CSS transition)
        slides[index].classList.add('active');
        // Add ken-burns to new bg
        const nextBg = slides[index].querySelector('.hero-slide-bg');
        if (nextBg) nextBg.classList.add('ken-burns');

        // Update text after a brief delay for smooth crossfade
        setTimeout(() => {
            texts.forEach(t => {
                t.classList.remove('exit');
                if (parseInt(t.dataset.slide) === index) {
                    t.classList.add('active');
                    t.setAttribute('aria-hidden', 'false');
                } else {
                    t.classList.remove('active');
                }
            });
        }, 350);

        // Update dots
        dots.forEach((d, i) => {
            d.classList.toggle('active', i === index);
            d.setAttribute('aria-selected', i === index ? 'true' : 'false');
        });

        current = index;
    }

    function nextSlide() { goTo(current + 1); }
    function prevSlide() { goTo(current - 1); }

    function startAutoplay() {
        stopAutoplay();
        autoplayTimer = setInterval(nextSlide, interval);
    }
    function stopAutoplay() {
        if (autoplayTimer) { clearInterval(autoplayTimer); autoplayTimer = null; }
    }

    // Event listeners
    nextBtn.addEventListener('click', () => { nextSlide(); startAutoplay(); });
    prevBtn.addEventListener('click', () => { prevSlide(); startAutoplay(); });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            goTo(parseInt(dot.dataset.slide));
            startAutoplay();
        });
    });

    // Pause on hover
    const hero = document.querySelector('.hero-slider');
    hero.addEventListener('mouseenter', stopAutoplay);
    hero.addEventListener('mouseleave', startAutoplay);

    // Keyboard navigation
    hero.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') { prevSlide(); startAutoplay(); }
        if (e.key === 'ArrowRight') { nextSlide(); startAutoplay(); }
    });

    // Start
    startAutoplay();
});
</script>
@endpush

{{-- ============================================ --}}
{{-- PREMIUM BOOKING WIDGET --}}
{{-- ============================================ --}}
<div class="booking-widget-wrapper">
    <div class="booking-widget" id="bookingWidget">
        {{-- Mobile toggle --}}
        <button class="booking-widget-toggle" type="button" id="bwToggle" aria-expanded="false">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Check Availability</span>
            <i class="fa-solid fa-chevron-down bw-toggle-icon"></i>
        </button>

        <div class="booking-widget-body" id="bwBody">
            <div class="bw-row">
                {{-- Check-in --}}
                <div class="bw-field bw-field-date">
                    <div class="bw-field-icon">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="bw-field-content">
                        <label class="bw-label">Check-in</label>
                        <input type="date" class="bw-input" id="av-checkin"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('check_in', date('Y-m-d')) }}">
                    </div>
                </div>

                <div class="bw-separator"></div>

                {{-- Check-out --}}
                <div class="bw-field bw-field-date">
                    <div class="bw-field-icon">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="bw-field-content">
                        <label class="bw-label">Check-out</label>
                        <input type="date" class="bw-input" id="av-checkout"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               value="{{ old('check_out', date('Y-m-d', strtotime('+1 day'))) }}">
                    </div>
                </div>

                <div class="bw-separator"></div>

                {{-- Guests --}}
                <div class="bw-field bw-field-guests">
                    <div class="bw-field-icon">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="bw-field-content">
                        <label class="bw-label">Guests</label>
                        <select class="bw-input bw-select" id="av-guests">
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('guests', 2) == $i ? 'selected' : '' }}>{{ $i }} {{ $i > 1 ? 'Guests' : 'Guest' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- CTA Button --}}
                <div class="bw-action">
                    <a href="#rooms" class="bw-btn" id="av-search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Search</span>
                    </a>
                </div>
            </div>

            {{-- Quick options row --}}
            <div class="bw-quick-options">
                <span class="bw-q-label">Quick Select:</span>
                <button type="button" class="bw-q-btn" data-days="1">Tonight</button>
                <button type="button" class="bw-q-btn" data-days="2">2 Nights</button>
                <button type="button" class="bw-q-btn" data-days="3">Weekend</button>
                <button type="button" class="bw-q-btn" data-days="7">1 Week</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Booking Widget Mobile Toggle
    const toggle = document.getElementById('bwToggle');
    const body = document.getElementById('bwBody');
    if (toggle && body) {
        toggle.addEventListener('click', () => {
            const isOpen = body.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen);
            toggle.querySelector('.bw-toggle-icon').style.transform = isOpen ? 'rotate(180deg)' : '';
        });
    }

    // Quick select buttons
    document.querySelectorAll('.bw-q-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const days = parseInt(this.dataset.days);
            const checkin = document.getElementById('av-checkin');
            const checkout = document.getElementById('av-checkout');
            if (!checkin || !checkout) return;

            const today = new Date();
            const checkinDate = new Date(today);
            checkin.value = checkinDate.toISOString().split('T')[0];

            const checkoutDate = new Date(today);
            checkoutDate.setDate(today.getDate() + days);
            checkout.value = checkoutDate.toISOString().split('T')[0];

            // Update checkout min
            checkout.min = checkin.value;

            // Visual feedback
            document.querySelectorAll('.bw-q-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
@endpush

