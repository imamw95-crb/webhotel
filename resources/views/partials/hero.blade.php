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
                <h1 class="hero-title gradient-gold text-split-reveal">{!! strip_tags($slide['title']) !!}</h1>
                <p class="hero-subtitle">{{ $slide['desc'] }}</p>
                <div class="hero-buttons">
                    <button type="button" class="btn-gold ripple-btn" onclick="window.openBookingModal ? window.openBookingModal() : null">Book Now <i class="fa-solid fa-calendar-check"></i></button>
                    <a href="#explore-spaces" class="btn-ghost ripple-btn">View Gallery</a>
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
                        <div class="bw-date-range">
                            <div class="bw-date-slot">
                                <input type="date" class="bw-input" id="av-checkin"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('check_in', date('Y-m-d')) }}">
                                <span class="bw-date-display" id="checkin-display">
                                    <span id="checkin-date-text">{{ date('D, d M Y') }}</span>
                                    <span class="date-day">Today</span>
                                </span>
                            </div>
                            <div class="bw-date-range-connector">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M13 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <div class="bw-date-slot">
                                <input type="date" class="bw-input" id="av-checkout"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       value="{{ old('check_out', date('Y-m-d', strtotime('+1 day'))) }}">
                                <span class="bw-date-display" id="checkout-display">
                                    <span id="checkout-date-text">{{ date('D, d M Y', strtotime('+1 day')) }}</span>
                                    <span class="date-day">Tomorrow</span>
                                </span>
                            </div>
                            <span class="bw-night-count" id="night-count">1 Night</span>
                        </div>
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
                    <button type="button" class="bw-btn" id="av-search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Search</span>
                    </button>
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

{{-- Custom Calendar Popup --}}
<div class="bw-calendar" id="bwCalendar" role="dialog" aria-label="Date picker" aria-hidden="true">
    <div class="bw-cal-inner">
        <div class="bw-cal-header">
            <button type="button" class="bw-cal-nav" id="cal-prev" aria-label="Previous month">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="bw-cal-title" id="cal-title">June 2026</div>
            <button type="button" class="bw-cal-nav" id="cal-next" aria-label="Next month">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
        <div class="bw-cal-days">
            <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
        </div>
        <div class="bw-cal-grid" id="cal-grid" role="grid" aria-label="Calendar days"></div>
        <div class="bw-cal-footer">
            <button type="button" class="bw-cal-footer-btn" id="cal-today">Today</button>
            <button type="button" class="bw-cal-footer-btn secondary" id="cal-clear">Clear</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================================
    // DOM refs
    // ============================================================
    const checkin     = document.getElementById('av-checkin');
    const checkout    = document.getElementById('av-checkout');
    const ciDisplay   = document.getElementById('checkin-display');
    const coDisplay   = document.getElementById('checkout-display');
    const ciText      = document.getElementById('checkin-date-text');
    const coText      = document.getElementById('checkout-date-text');
    const nightCount  = document.getElementById('night-count');
    const ciSlot      = document.querySelector('#av-checkin').closest('.bw-date-slot');
    const coSlot      = document.querySelector('#av-checkout').closest('.bw-date-slot');

    // Calendar DOM refs
    const calendar    = document.getElementById('bwCalendar');
    const calGrid     = document.getElementById('cal-grid');
    const calTitle    = document.getElementById('cal-title');
    const calPrev     = document.getElementById('cal-prev');
    const calNext     = document.getElementById('cal-next');
    const calToday    = document.getElementById('cal-today');
    const calClear    = document.getElementById('cal-clear');

    // ============================================================
    // Calendar state
    // ============================================================
    let activeInput = null;       // 'checkin' or 'checkout'
    let viewYear    = 2026;
    let viewMonth   = 5;          // 0-indexed (June)

    const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    const DAYS   = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

    // ============================================================
    // Helpers
    // ============================================================
    function parseDate(str) {
        if (!str) return null;
        const parts = str.split('-');
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    function formatDisplay(date) {
        const d = date.getDate();
        const day = DAYS[date.getDay()];
        const mon = MONTHS[date.getMonth()].substring(0,3);
        const y = date.getFullYear();
        return day + ', ' + d + ' ' + mon + ' ' + y;
    }

    function toDateStr(date) {
        return date.getFullYear() + '-'
            + String(date.getMonth() + 1).padStart(2,'0') + '-'
            + String(date.getDate()).padStart(2,'0');
    }

    function dayLabel(date) {
        const today = new Date();
        today.setHours(0,0,0,0);
        const target = new Date(date);
        target.setHours(0,0,0,0);
        const diff = Math.round((target - today) / 86400000);
        if (diff === 0) return 'Today';
        if (diff === 1) return 'Tomorrow';
        if (diff === -1) return 'Yesterday';
        return '';
    }

    function daysBetween(a, b) {
        const diff = Math.round((b - a) / 86400000);
        return diff > 0 ? diff : 0;
    }

    function normalizeDate(date) {
        const d = new Date(date);
        d.setHours(0,0,0,0);
        return d;
    }

    function updateDateDisplay() {
        const ci = parseDate(checkin.value);
        const co = parseDate(checkout.value);
        if (!ci) return;

        ciText.textContent = formatDisplay(ci);
        ciDisplay.querySelector('.date-day').textContent = dayLabel(ci);

        if (co) {
            coText.textContent = formatDisplay(co);
            coDisplay.querySelector('.date-day').textContent = dayLabel(co);
            const nights = daysBetween(ci, co);
            nightCount.textContent = nights + ' Night' + (nights > 1 ? 's' : '');
            nightCount.style.display = 'inline-flex';
        } else {
            coText.textContent = 'Select date';
            coDisplay.querySelector('.date-day').textContent = '';
            nightCount.style.display = 'none';
        }
    }

    // ============================================================
    // Auto-select checkout when checkin changes
    // ============================================================
    function onCheckinChange() {
        const ci = parseDate(checkin.value);
        const co = parseDate(checkout.value);
        if (!ci) return;

        if (!co || co <= ci) {
            const next = new Date(ci);
            next.setDate(ci.getDate() + 1);
            checkout.value = toDateStr(next);
            checkout.min = checkin.value;
        }

        if (ciSlot) {
            ciSlot.classList.remove('bw-date-updated');
            void ciSlot.offsetWidth;
            ciSlot.classList.add('bw-date-updated');
        }
        updateDateDisplay();
    }

    function onCheckoutChange() {
        const ci = parseDate(checkin.value);
        const co = parseDate(checkout.value);
        if (ci && co && co <= ci) {
            const next = new Date(ci);
            next.setDate(ci.getDate() + 1);
            checkout.value = toDateStr(next);
        }
        checkout.min = checkin.value;

        if (coSlot) {
            coSlot.classList.remove('bw-date-updated');
            void coSlot.offsetWidth;
            coSlot.classList.add('bw-date-updated');
        }
        updateDateDisplay();
    }

    checkin.addEventListener('change', onCheckinChange);
    checkout.addEventListener('change', onCheckoutChange);

    // ============================================================
    // Booking Widget Mobile Toggle
    // ============================================================
    const toggle = document.getElementById('bwToggle');
    const body = document.getElementById('bwBody');
    if (toggle && body) {
        toggle.addEventListener('click', () => {
            const isOpen = body.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen);
            toggle.querySelector('.bw-toggle-icon').style.transform = isOpen ? 'rotate(180deg)' : '';
        });
    }

    // ============================================================
    // Quick select buttons
    // ============================================================
    document.querySelectorAll('.bw-q-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const days = parseInt(this.dataset.days);
            if (!checkin || !checkout) return;

            const today = new Date();
            today.setHours(0,0,0,0);
            checkin.value = toDateStr(today);

            const coDate = new Date(today);
            coDate.setDate(today.getDate() + days);
            checkout.value = toDateStr(coDate);
            checkout.min = checkin.value;

            document.querySelectorAll('.bw-q-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            updateDateDisplay();
        });
    });

    // ============================================================
    // CUSTOM CALENDAR POPUP
    // ============================================================

    // --- Open calendar ---
    function openCalendar(target) {
        activeInput = target; // 'checkin' or 'checkout'
        const inputEl = target === 'checkin' ? checkin : checkout;
        const dt = parseDate(inputEl.value) || new Date();
        viewYear  = dt.getFullYear();
        viewMonth = dt.getMonth();
        renderCalendar();
        calendar.classList.add('open');
        calendar.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeCalendar() {
        calendar.classList.remove('open');
        calendar.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        activeInput = null;
    }

    // --- Render calendar grid ---
    function renderCalendar() {
        calTitle.textContent = MONTHS[viewMonth] + ' ' + viewYear;

        const today    = normalizeDate(new Date());
        const ci       = parseDate(checkin.value);
        const co       = parseDate(checkout.value);
        const minRaw   = activeInput === 'checkin'
            ? normalizeDate(new Date())
            : (ci ? normalizeDate(new Date(ci.getTime() + 86400000)) : normalizeDate(new Date()));

        const firstDay = new Date(viewYear, viewMonth, 1);
        const lastDay  = new Date(viewYear, viewMonth + 1, 0);
        const startDow = firstDay.getDay(); // 0=Sun
        const daysInMonth = lastDay.getDate();

        // Previous month trailing days
        const prevLast = new Date(viewYear, viewMonth, 0);
        const prevDays = prevLast.getDate();

        let html = '';
        let dayCount = 0;

        // Previous month cells
        for (let i = startDow - 1; i >= 0; i--) {
            const d = prevDays - i;
            const dt = new Date(viewYear, viewMonth - 1, d);
            html += '<button type="button" class="bw-cal-day other-month" disabled>' + d + '</button>';
            dayCount++;
        }

        // Current month cells
        for (let d = 1; d <= daysInMonth; d++) {
            const dt = new Date(viewYear, viewMonth, d);
            const dtNorm = normalizeDate(dt);
            const dateStr = toDateStr(dt);
            const isToday  = dtNorm.getTime() === today.getTime();
            const isMin    = dtNorm.getTime() < minRaw.getTime();
            const isSelected = (activeInput === 'checkin' && ci && dtNorm.getTime() === normalizeDate(ci).getTime())
                           || (activeInput === 'checkout' && co && dtNorm.getTime() === normalizeDate(co).getTime());
            const inRange = ci && co
                && dtNorm.getTime() > normalizeDate(ci).getTime()
                && dtNorm.getTime() < normalizeDate(co).getTime();
            const isRangeStart = ci && dtNorm.getTime() === normalizeDate(ci).getTime();
            const isRangeEnd   = co && dtNorm.getTime() === normalizeDate(co).getTime();

            let cls = 'bw-cal-day';
            if (isToday) cls += ' today';
            if (isSelected) cls += ' selected';
            if (isMin) cls += ' disabled';
            if (inRange) cls += ' in-range';
            if (isRangeStart && activeInput === 'checkout') cls += ' range-start';
            if (isRangeEnd && activeInput === 'checkin') cls += ' range-end';

            html += '<button type="button" class="' + cls + '" data-date="' + dateStr + '"'
                 + (isMin ? ' disabled' : '')
                 + '>' + d + '</button>';
            dayCount++;
        }

        // Fill remaining cells
        const remaining = 42 - dayCount;
        for (let d = 1; d <= remaining; d++) {
            html += '<button type="button" class="bw-cal-day other-month" disabled>' + d + '</button>';
        }

        calGrid.innerHTML = html;

        // Attach click events to day buttons
        calGrid.querySelectorAll('.bw-cal-day:not(.disabled):not(.other-month)').forEach(btn => {
            btn.addEventListener('click', function() {
                const dateStr = this.dataset.date;
                selectDate(dateStr);
            });
        });
    }

    // --- Select a date ---
    function selectDate(dateStr) {
        const inputEl = activeInput === 'checkin' ? checkin : checkout;
        inputEl.value = dateStr;

        // Update min for checkout
        if (activeInput === 'checkin') {
            checkout.min = checkin.value;
        }

        // Trigger change event for auto-select logic
        inputEl.dispatchEvent(new Event('change', { bubbles: true }));

        // If selecting checkin and checkout is empty/behind, auto-update
        if (activeInput === 'checkin') {
            onCheckinChange();
        } else {
            onCheckoutChange();
        }

        closeCalendar();
    }

    // --- Navigation ---
    calPrev.addEventListener('click', () => {
        viewMonth--;
        if (viewMonth < 0) { viewMonth = 11; viewYear--; }
        renderCalendar();
    });

    calNext.addEventListener('click', () => {
        viewMonth++;
        if (viewMonth > 11) { viewMonth = 0; viewYear++; }
        renderCalendar();
    });

    // --- Today button ---
    calToday.addEventListener('click', () => {
        const today = new Date();
        viewYear  = today.getFullYear();
        viewMonth = today.getMonth();
        renderCalendar();
        selectDate(toDateStr(today));
    });

    // --- Clear button ---
    calClear.addEventListener('click', () => {
        closeCalendar();
    });

    // --- Open calendar on slot click ---
    ciSlot.addEventListener('click', (e) => {
        if (e.target.tagName === 'INPUT') return;
        e.stopPropagation();
        openCalendar('checkin');
    });

    coSlot.addEventListener('click', (e) => {
        if (e.target.tagName === 'INPUT') return;
        e.stopPropagation();
        openCalendar('checkout');
    });

    // --- Close on backdrop click ---
    calendar.addEventListener('click', (e) => {
        if (e.target === calendar) closeCalendar();
    });

    // --- Close on Escape ---
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && calendar.classList.contains('open')) {
            closeCalendar();
        }
    });

    // ============================================================
    // Initial render
    // ============================================================
    updateDateDisplay();
});
</script>
@endpush

